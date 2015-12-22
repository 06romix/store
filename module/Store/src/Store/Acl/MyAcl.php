<?php
namespace Store\Acl;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;

class MyAcl extends Acl
{
  public $config = array();

  function __construct()
  {
    $this->config = include 'acl.config.php';
    $this->addMyRole();
    $this->addMyResource();
    $this->addAllow();
    $this->addDeny();
  }

  private function addMyRole()
  {
    if (!isset($this->config['acl']['roles'])) return;

    foreach ($this->config['acl']['roles'] AS $role => $parent)
    {
      if ($parent != 'null'){
        $this->addRole(new Role($role), $parent);
      } else {
        $this->addRole(new Role($role));
      }
    }
  }

  private function addMyResource()
  {
    if (!isset($this->config['acl']['resources'])) return;

    foreach ($this->config['acl']['resources']['resources'] AS $parentResource => $resource)
    {
      if (is_array($resource)){
        $this->addResource($parentResource);

        foreach ($resource AS $childResource)
        {
//          echo $parentResource . ' : ' . $childResource . '<br>'; //show resources
          $this->addResource($childResource, $parentResource);
        }

      } else {
        $this->addResource($resource);
      }
    }
  }

  private function addAllow()
  {
    if (!isset($this->config['acl']['allow'])) return;

    foreach ($this->config['acl']['allow'] AS $resource => $right)
    {
      foreach ($right AS $privilege => $user)
      {
//        echo '<br>' . $user . ' ' . $resource, ($privilege == 'all') ? null : $privilege;
        $this->allow($user, $resource);
      }
    }
  }

  private function addDeny()
  {
    if (!isset($this->config['acl']['deny'])) return;

    foreach ($this->config['acl']['deny'] AS $resource => $right)
    {
      foreach ($right AS $privilege => $user)
      {
        $this->deny($user, $resource, ($privilege == 'all') ? null : $privilege);
      }
    }
  }
}