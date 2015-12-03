<?php
namespace Auth\Form;

use Zend\Form\Form;
//use Zend\InputFilter\Factory as InputFactory;
//use Zend\InputFilter\InputFilter;

class RegistrationForm extends Form
{
  public function __construct($name = null)
  {
    parent::__construct('registrationForm');
    $this->setAttribute('method', 'post');
    $this->setAttribute('class', 'form-horizontal');

//    $this->setInputFilter(new ProductAddInputFilter());

    $this->add(array(
      'name' => 'name',
      'type' => 'Text',
      'options' => array(
        'min' => 2,
        'max' => 100,
        'label' => 'Login',
      ),
      'attributes' => array(
        'class' => 'form-control',
        'required' => 'required',
      ),
    ));

    $this->add(array(
      'name' => 'email',
      'type' => 'Text',
      'options' => array(
        'min' => 3,
        'max' => 500,
        'label' => 'E-mail',
      ),
      'attributes' => array(
        'class' => 'form-control',
        'required' => 'required',
      ),
    ));

    $this->add(array(
      'name' => 'tel',
      'type' => 'Text',
      'options' => array(
        'min' => 1,
        'max' => 10,
        'label' => 'Телефон',
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