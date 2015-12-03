<?php
namespace Admin\Controller;

use Store\Db\DbFunctions;
use Store\Entity\Order;
use Zend\Db\Adapter\Driver;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class OrderController extends AbstractActionController
{

  public function indexAction()
  {

    return new ViewModel(array( 'orders' => Order::getOrder() ));
  }

  public function viewAction()
  {
    $id = $this->params()->fromRoute('id', 0);
    return new ViewModel(array( 'order' => Order::getOrder($id) ));
  }
}