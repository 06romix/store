<?php
namespace Store\Db;

use Zend\Config\Config;
use Zend\Db\Adapter\Adapter;

class MyDbAdapter
{
  public static function getDbAdapter(){
    $dbConfig = new Config(include 'dbConfig.php');
    return new Adapter(array('driver'         => $dbConfig->driver,
                             'dsn'            => $dbConfig->dsn,
                             'username'       => $dbConfig->username,
                             'password'       => $dbConfig->password,
                             'driver_options' => $dbConfig->driver_options,
    ));
  }
}