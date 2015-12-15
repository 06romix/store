<?php
namespace Admin;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Zend\Authentication\AuthenticationService;
use Store\Acl\MyAcl;
use Store\Entity\User;



class Module
{
  /**
   * @param  MvcEvent $e
   */
  public function onBootstrap($e)
  {

    $e->getApplication()->getServiceManager()->get('translator');
    $eventManager        = $e->getApplication()->getEventManager();
    $moduleRouteListener = new ModuleRouteListener();
    $moduleRouteListener->attach($eventManager);
    $app = $e->getParam('application');

    $app->getEventManager()->attach('dispatch', array($this, 'setLayout'), -100);
  }

  /**
   * @param MvcEvent $e
   * @return bool
   */

  public function AuthAndAcl($e)
  {
    $acl  = new MyAcl();
    $auth = new AuthenticationService();

    // Get User Role
    $role = ($auth->getIdentity()) ? User::getUserRole($auth->getIdentity()) : 'guest';
    return $acl->isAllowed($role, $e->getRouteMatch()->getParam('controller'));
  }

  /**
   * @param MvcEvent $e
   */

  public function setLayout($e)
  {
    if (!$this->AuthAndAcl($e)){
      $viewModel = $e->getViewModel();
      $viewModel->setTemplate('layout/exit');
      return;
    }
    $matches    = $e->getRouteMatch();
    $action = $matches->getParam('action');
    $controller = $matches->getParam('controller');

    // Blank page for JS
    if (in_array($action, array('delete', 'updateBasket'), 0)) {
      $viewModel = $e->getViewModel();
      $viewModel->setTemplate('layout/blank');
      return;
    }
    if (in_array($controller, array('product', 'user', 'order', 'Admin\Controller\Index'), 0)){
      // Set the layout template
      $viewModel = $e->getViewModel();
      $viewModel->setTemplate('layout/layout');
      return;
    }
    if (in_array($action, array('login', 'registration'), 0)){
      // Set the layout template
      $viewModel = $e->getViewModel();
      $viewModel->setTemplate('layout/auth');
      return;
    }
  }

  public function getConfig()
  {
    return include __DIR__ . '/config/module.config.php';
  }

  public function getAutoloaderConfig()
  {
    return array(
      'Zend\Loader\StandardAutoloader' => array(
        'namespaces' => array(
          __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
        ),
      ),
    );
  }
}