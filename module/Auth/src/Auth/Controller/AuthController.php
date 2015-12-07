<?php
namespace Auth\Controller;


use Auth\Form\MyRegistrationFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Element;
use Zend\Db\Adapter\Driver;
use Zend\Authentication\AuthenticationService;

use Auth\AuthModel\MyAuthAdapter;
use Auth\Form\AuthForm;
use Auth\Form\RegistrationForm;
use Store\Entity\User;
class AuthController extends AbstractActionController
{
  public function loginAction()
  {
    $form = new AuthForm;
    $auth = new AuthenticationService();
    $status = $message = '';

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
        $authAdapter = new MyAuthAdapter($userData['name'], md5($userData['pass']));
        $result = $auth->authenticate($authAdapter);

        if ($result->isValid()){
          return $this->redirect()->toRoute('store');
        } else {
          $status = 'error';
          $message = 'Невірний логін або пароль';
        }
      }
    }

    if ($message){
      $this->flashMessenger()
        ->setNamespace($status)
        ->addMessage($message);
    }
    return array('form' => $form);
  }

  public function registrationAction()
  {
    $form = new RegistrationForm();
    $auth = new AuthenticationService();
    $status = $message = '';

    if ($auth->hasIdentity()) {
      // Identity exists
      return $this->redirect()->toRoute('store');
    }

    $request = $this->getRequest();
    if ($request->isPost()){

      $filters = new MyRegistrationFilter();
      $form->setInputFilter($filters->getInputFilter());

      $form->setData($request->getPost());
      if ($form->isValid()){

        //add user
        $userData = $form->getData();
        $user = new User();
        $user->exchangeArray($form->getData());
        $user->addUser();

        //Authentication
        $authAdapter = new MyAuthAdapter($userData['name'], md5($userData['pass']));
        $result = $auth->authenticate($authAdapter);

        if ($result->isValid()){
          $status = 'success';
          $message = 'Реєстрація пройшла успішно';
          if ($message){
            $this->flashMessenger()
              ->setNamespace($status)
              ->addMessage($message);
          }
          return $this->redirect()->toRoute('store');
        } else {
          $status = 'error';
          $message = 'Виникла непередбачувана помилка';
        }

      } else {
        $status = 'error';
        $message = 'Помилка параметрів';
      }
    }

    //make message
    if ($message){
      $this->flashMessenger()
        ->setNamespace($status)
        ->addMessage($message);
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