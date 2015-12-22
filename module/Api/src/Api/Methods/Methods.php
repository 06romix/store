<?php
namespace Api\Methods;

class Methods
{
  public static function getSupportedVersion()
  {
    return array(0.1);
  }

  public static function getMethod(){
    $method = 'unknown';
    switch ($_SERVER["REQUEST_METHOD"])
    {
      case 'GET':
        $method = 'GET';
        break;
      case 'POST':
        $method = 'POST';
        break;
      case 'PUT':
        $method = 'PUT';
        break;
      case 'DELETE':
        $method = 'DELETE';
        break;
    }
    return $method;
  }

  public static function getData(){
    $data = '';
    switch ($_SERVER["REQUEST_METHOD"])
    {
      case 'GET':
        $data = $_GET;
        break;
      case 'POST':
        $data = $_POST['json'];
        break;
      case 'PUT':
        $data = fread(fopen("php://input", "r"), 10000);
        break;
      case 'DELETE':
        $data = 'DELETE';
        break;
    }
    return $data;
  }
}

