<?php
namespace Store;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Zend\Authentication\AuthenticationService;
use Store\Acl\MyAcl;
use Store\Entity\User;

class Module
{
  public function onBootstrap($e)
  {
    $e->getApplication()->getServiceManager()->get('translator');
    $eventManager        = $e->getApplication()->getEventManager();
    $moduleRouteListener = new ModuleRouteListener();
    $moduleRouteListener->attach($eventManager);

    $app = $e->getParam('application');
    $app->getEventManager()->attach('dispatch', array($this, 'setLayout'), -90);
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

    if (__NAMESPACE__ !== 'Store') {
      // not a controller from this module
      return;
    }

    $matches    = $e->getRouteMatch();
    $controller = $matches->getParam('controller');
    $action = $matches->getParam('action');

    // Blank page for JS
    if ($action == 'updateBasket') {
      $viewModel = $e->getViewModel();
      $viewModel->setTemplate('layout/blank');
      return;
    }

    if (0 === strpos(__NAMESPACE__, 'Store', 0)){
      // Set the layout template
      $viewModel = $e->getViewModel();
      $viewModel->setTemplate('layout/index');
    }
    if (0 !== strpos($controller, 'Store', 0)) {
      // not a controller from this module
      return;
    } else {
      $viewModel = $e->getViewModel();
      $viewModel->setTemplate('layout/index');
    }

    // Set the layout template


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