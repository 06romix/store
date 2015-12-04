<?php
namespace Admin\Controller;

use Admin\Form\MyProductFilter;
use Store\Db\MyDbAdapter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Element;

use Admin\Form\ProductAddForm;

use Store\Db\DbFunctions;
use Store\Entity\Product;

class ProductController extends AbstractActionController
{

  public function indexAction()
  {
    return new ViewModel(array('products' => DbFunctions::getEntity('product')));
  }

  public function addAction()
  {
    //initialization
    $form = new ProductAddForm;
    $status = $message = '';

    //check request if(post) save  else show form on view
    $request = $this->getRequest();
    if ($request->isPost()){

      $form->setData($request->getPost());
      $filter = new MyProductFilter();
      $form->setInputFilter($filter->getInputFilter());
      if ($form->isValid()){

        //save product
        $product = new Product();
        $product->exchangeArray($form->getData());
        $product->save();

        $status = 'success';
        $message = 'Продукт добавлений';

      } else {
        $status = 'error';
        $message = 'Помилка параметрів';
      }
    } else {
      return array('form' => $form);
    }

    //make message
    if ($message){
      $this->flashMessenger()
        ->setNamespace($status)
        ->addMessage($message);
    }

    //go to product list
    return $this->redirect()->toRoute();
  }

  public function editAction()
  {
    //initialization
    $form = new ProductAddForm;
    $status = $message = '';
    $id = (int) $this->params()->fromRoute('id', 0);


    $product = new Product();
    $db = new DbFunctions();

    //get product data
    $data = $db->getEntity('product', $id);
    //if find 0 go product list
    if (empty($data)){
      $status = 'error';
      $message = 'Продукт не знайдено';
      $this->flashMessenger()
        ->setNamespace($status)
        ->addMessage($message);
      return $this->redirect()->toRoute('admin/product');
    }
    $product->dbToProduct($data);
    $form->bind($product);


    //check request if(post) save  else show filled form on view
    $request = $this->getRequest();
    if ($request->isPost()){

      $form->setData($request->getPost());
      if ($form->isValid()){
        //save
        $product->update($id);

        $status = 'success';
        $message = 'Зміни збережено';

      } else {
        $status = 'error';
        $message = 'Помилка параметрів';
        foreach ($form->getInputFilter()->getInvalidInput() AS $errors){
          foreach ($errors->getMessages() AS $error){
            $message .= ' ' . $error;
          }
        }
      }

    } else {
      return array('form' => $form, 'id' => $id);
    }

    //make message
    if ($message){
      $this->flashMessenger()
        ->setNamespace($status)
        ->addMessage($message);
    }

    //go to product list
    return $this->redirect()->toRoute();
  }

  public function deleteAction()
  {
    //initialization
    $status = $message = '';
    $id = (int) $this->params()->fromRoute('id');

    $request = $this->getRequest();
    if ($request->isPost()){
      $product = new Product();
      //delete
      if ($product->delete($id) == 1) {
        $status = 'success';
        $message = 'Товар видалено';
      } else {
        $status = 'error';
        $message = 'Помилка при видалені';
      }
    }

    //make message for JS
    if ($message){
      echo json_encode(array('status' => $status, 'message' => $message));
    }
    return true;
  }
}