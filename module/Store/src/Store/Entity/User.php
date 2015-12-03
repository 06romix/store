<?php
namespace Store\Entity;

use Store\Db\DbFunctions;

class User
{
  private $id;
  private $name;
  private $pass;
  private $email;
  private $tel;
  private $ip;
  private $role;

  function __construct($id = 0)
  {
    if ($id != 0) $this->id = (int) $id;
  }

  public static function getUserLogin($id)
  {
    return DbFunctions::getEntity('user', $id)['user_name'];
  }

  public static function getUserRole($id)
  {
    return DbFunctions::getFieldEntity('user', array('user_role'), $id)['user_role'];
  }

  private function findUserIp()
  {
    $this->ip = $_SERVER['REMOTE_ADDR'];
    // getenv(HTTP_X_FORWARDED_FOR); // if user use proxy server
  }

  public function dbToUser($data)
  {
    foreach ($data AS $key => $val){
      $key = preg_replace('/user_/', '', $key);
      if (property_exists($this, $key)){
        $this->$key = ($val !== null) ? $val : null;
      }
    }
  }

  /**
   * @param $name String user_name
   * @param $pass String user_pass
   * @return array
   */
  public function authenticateUser($name, $pass)
  {
    $result = DbFunctions::authenticateUser($name, $pass);
    if($result == false){
      return array('status' => false);
    }
    //fill Object
//    $this->dbToUser($result);
    return array('status' => true, 'data' => $result);
  }
}