<?php
namespace Store\Form;

use Zend\Form\Form;
//use Zend\InputFilter\Factory as InputFactory;
//use Zend\InputFilter\InputFilter;

class OrderForm extends Form
{
  public function __construct($name = null)
  {
    parent::__construct('orderForm');
    $this->setAttribute('method', 'post');
    $this->setAttribute('class', 'orderForm');

//    $this->setInputFilter(new ProductAddInputFilter());

    $this->add(array(
      'name' => 'quantity',
      'type' => 'text',
      'options' => array(
        'label' => 'Кількість:',
      ),
      'attributes' => array(
        'required' => 'required',
      ),
    ));

    $this->add(array(
      'name' => 'submit',
      'type' => 'submit',
      'attributes' => array(
        'value' => 'Замовити',
        'id' => 'btmSubmit',
        'class' => 'purchaseButton',
      ),
    ));
  }
}