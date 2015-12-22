<?php
namespace Api\Controller;

use Store\Entity\Product;
use Store\Entity\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Api\Methods\Methods;

class IndexController extends AbstractActionController
{
  public function indexAction()
  {
    return new ViewModel();
  }

  public function productsAction()
  {
    //initialization
    $message = $status = '';
    $version = $this->params()->fromRoute('v', false);
    if (in_array($version, Methods::getSupportedVersion()))
    {
      $param = $this->params()->fromRoute('param', false);
      $resource = $this->params()->fromRoute('resource', false);

      switch (Methods::getMethod())
      {
        case 'GET':
          $status = 'GET';
          $message = Product::getProduct($param);
          break;
        case 'POST':
          $status = 'POST';
          $message = 'POST';
          break;
        case 'PUT':
          $status = 'PUT';
          $message = 'PUT';
          break;
        case 'DELETE':
          $status = 'DELETE';
          $message = 'DELETE';
          break;
      }
    } else {
      $status = 'ERROR';
      $message = 'Not supported Version API';
    }


    //make message for JS
    if ($message){
      echo json_encode(array('method' => $status, 'message' => $message));
    }
    return true;
  }

  public function usersAction()
  {
    //initialization
    $message = $status = '';
    $version = $this->params()->fromRoute('v', false);
    if (in_array($version, Methods::getSupportedVersion()))
    {
      $param = $this->params()->fromRoute('param', false);
      $resource = $this->params()->fromRoute('resource', false);

      switch (Methods::getMethod())
      {
        case 'GET':
          $status = 'GET';
          $message = User::getUserLogin($param);
          break;
        case 'POST':
          $status = 'POST';
          $message = 'POST';
          break;
        case 'PUT':
          $status = 'PUT';
          $message = 'PUT';
          break;
        case 'DELETE':
          $status = 'DELETE';
          $message = 'DELETE';
          break;
      }
    } else {
      $status = 'ERROR';
      $message = 'Not supported Version API';
    }


    //make message for JS
    if ($message){
      echo json_encode(array('method' => $status, 'message' => $message));
    }
    return true;
  }

}