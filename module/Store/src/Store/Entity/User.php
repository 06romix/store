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

  public static function getUser($id = 0)
  {
    return DbFunctions::getEntity('user', $id);
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
    return array('status' => true, 'data' => $result);
  }

  public function addUser()
  {
    $this->findUserIp();
    $this->role = 'user';

    $setField = "'"
      . $this->name . "', '"
      . md5($this->pass) . "', '"
      . $this->email . "', '"
      . $this->tel . "', '"
      . $this->ip . "', '"
      . $this->role . "'";

    DbFunctions::insertEntity('user', $setField);
  }

  public function exchangeArray($data)
  {
    foreach ($data AS $key => $val){
      if (property_exists($this, $key)){
        $this->$key = ($val !== null) ? $val : null;
      }
    }
  }
}