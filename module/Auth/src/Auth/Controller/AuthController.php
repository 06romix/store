<?php
namespace Auth\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Element;
use Zend\Db\Adapter\Driver;
use Zend\Authentication\AuthenticationService;

use Auth\AuthModel\MyAuthAdapter;
use Auth\Form\AuthForm;
class AuthController extends AbstractActionController
{
  public function loginAction()
  {
    $form = new AuthForm;
    $auth = new AuthenticationService();

    if ($auth->hasIdentity()) {
      // Identity exists
      return $this->redirect()->toRoute('store');
    }

    $request = $this->getRequest();
    if ($request->isPost()){
      $form->setData($request->getPost());
      if ($form->isValid()){
        $userData = $form->getData();

        //Authentication
        $authAdapter = new MyAuthAdapter($userData['name'], $userData['pass']);
        $result = $auth->authenticate($authAdapter);

        if ($result->isValid()){
          return $this->redirect()->toRoute('store');
        } else {
          echo 'error';
        }
      }
    }
    return array('form' => $form);
  }

  public function logoutAction()
  {
    $auth = new AuthenticationService();
    $auth->clearIdentity();
    session_unset();
    session_destroy();
    return $this->redirect()->toRoute('store');
  }
}