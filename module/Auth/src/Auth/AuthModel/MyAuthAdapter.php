<?php
namespace Auth\AuthModel;

use Zend\Db\Adapter\Driver;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

use Store\Entity\User;

use Zend\Permissions\Acl\AclInterface;

class MyAuthAdapter implements AdapterInterface
{
  protected $username = null;
  protected $password = null;
  /**
   * Sets username and password for authentication
   * @param $userName
   * @param $password
   */
  public function __construct($userName, $password)
  {
    $this->username = $userName;
    $this->password = $password;
  }

  /**
   * Performs an authentication attempt
   *
   * @return \Zend\Authentication\Result
   * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface
   *               If authentication cannot be performed
   */
  public function authenticate()
  {
    $user = new User();

    $result = $user->authenticateUser($this->username, $this->password);
    if ($result['status'] == false){
      return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, $this->username);
    }
    return new Result(Result::SUCCESS, $result['data']['user_id']);
  }
}