<?php
namespace Admin\Form;

use Zend\Form\Form;


class ProductAddForm extends Form
{
  public function __construct($name = null)
  {
    parent::__construct('productAddForm');
    $this->setAttribute('method', 'post');
    $this->setAttribute('class', 'form-horizontal');

    $this->add(array(
      'name' => 'name',
      'type' => 'Text',
      'options' => array(
        'label' => 'Назва товару',
      ),
      'attributes' => array(
        'class' => 'form-control',
        'required' => 'required',
      ),
    ));

    $this->add(array(
      'name' => 'description',
      'type' => 'textarea',
      'options' => array(
        'label' => 'Опис',
      ),
      'attributes' => array(
        'class' => 'form-control',
        'required' => 'required',
      ),
    ));

    $this->add(array(
      'name' => 'price',
      'type' => 'Text',
      'options' => array(
        'label' => 'Ціна',
      ),
      'attributes' => array(
        'class' => 'form-control',
        'required' => 'required',
      ),
    ));

    $this->add(array(
      'name' => 'quantity',
      'type' => 'text',
      'options' => array(
        'label' => 'Кількість на складі',
      ),
      'attributes' => array(
        'class' => 'form-control',
        'required' => 'required',
      ),
    ));

    $this->add(array(
      'name' => 'submit',
      'type' => 'submit',
      'attributes' => array(
        'value' => 'Зберегти',
        'id' => 'btmSubmit',
        'class' => 'btn btnSubmit',
      ),
    ));
  }
}