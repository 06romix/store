<?php
namespace Store\Form;

use Zend\Form\Form;

class OrderForm extends Form
{
  public function __construct($name = null)
  {
    parent::__construct('orderForm');
    $this->setAttribute('method', 'post');
    $this->setAttribute('class', 'orderForm');
    $this->setAttribute('id', 'orderForm');

    $this->add(array(
      'name' => 'quantity',
      'type' => 'text',
      'options' => array(
        'label' => 'Кількість:',
      ),
      'attributes' => array(
        'required' => 'required',
        'value' => 1
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