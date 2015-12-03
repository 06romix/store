<?php
namespace Store\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;

use Store\Entity\Order;
use Store\Entity\Product;
use Store\Form\OrderForm;
class IndexController extends AbstractActionController
{
  public function indexAction()
  {
    session_start();
    if (!isset($_SESSION['sort'])) $_SESSION['sort'] = null;
    if (!isset($_SESSION['limit'])) $_SESSION['limit'] = 5;
    $sort = $_SESSION['sort'];
    $limit = $_SESSION['limit'];
    $id = $this->params()->fromRoute('id');

    $currentPage = $this->params()->fromRoute('id', 1);
    $pageCount = ceil(Product::getCount()/$limit);
    if ($currentPage > $pageCount){
      $id = $currentPage = $pageCount;
    }


    $auth = new AuthenticationService();
    $userRole = ($auth->getIdentity()) ? 'user' : 'guest';

    $navigation = ($limit < Product::getCount()) ? Product::getCount(): false;
    return new ViewModel(array(
      'products'    => Product::getAllByPage(array('product_id', 'product_name', 'product_price'), $sort, $limit, $id),
      'userRole'    => $userRole,
      'limit'       => $limit,
      'sort'        => $sort,
      'navigation'  => $navigation,
      'pageCount'   => $pageCount,
      'currentPage' => $currentPage,
    ));

  }

  public function configAction()
  {
    $request = $this->getRequest();
    if ($request->isPost()){
      $config = $request->getPost();
      session_start();
      if (isset($config['sort'])) $_SESSION['sort'] = $config['sort'];
      if (isset($config['limit'])) $_SESSION['limit'] = $config['limit'];
    }
    return new ViewModel();
  }

  public function showAction()
  {
    $auth = new AuthenticationService();
    //if you guest - go to product list
    if (!$auth->getIdentity()) return $this->redirect()->toRoute('store');

    //initialization
    $form = new OrderForm();
    $status = $message = '';
    $id = $this->params()->fromRoute('id', 0);

    //check request if not Post show form on view
    $request = $this->getRequest();
    if($request->isPost()){

      //validation and save
      $form->setData($request->getPost());
      if ($form->isValid()){
        $order = new Order();
        $order->exchangeArray($form->getData());
        $product = Product::getOne($id);
        $order->setProductId($product['product_id']);
        $order->setProductPrice($product['product_price']);
        $order->setUserId($auth->getIdentity());
        $order->save();

        $status = 'success';
        $message = 'Замовлення здійснено';
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
      return $this->redirect()->refresh();
    }

    //show form
    return new ViewModel(array(
      'product' => Product::getOne($id),
      'form' => $form,
      'id' => $id,
    ));
  }
}