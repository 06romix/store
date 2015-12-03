<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Store\Db\DbFunctions;

class UserController extends AbstractActionController
{

  public function indexAction()
  {
    $fields = array('user_id', 'user_name', 'user_email');

    return new ViewModel(array('users' => DbFunctions::getFieldEntity('user', $fields)));
  }

  public function viewAction()
  {
    $id = $this->params()->fromRoute('id', 0);

    return new ViewModel(array('user' => DbFunctions::getEntity('user', $id)));
  }
}