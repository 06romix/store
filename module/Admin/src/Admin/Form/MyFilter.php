<?php
namespace Admin\Form;

use Zend\Form\Form;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;


class MyFilter implements  InputFilterAwareInterface
{

  private $inputFilter;

  public function setInputFilter(InputFilterInterface $inputFilter)
  {
    throw new \Exception("Not used");
  }

  public function test()
  {
    return 1;
  }

  /**
   * Retrieve input filter
   *
   * @return InputFilterInterface
   */
  public function getInputFilter()
  {
    if (!$this->inputFilter) {
      $inputFilter = new InputFilter();

      $inputFilter->add(array(
        'name'     => 'name',
        'required' => true,
        'filters'  => array(
          array('name' => 'StripTags'),
          array('name' => 'StringTrim'),
        ),
        'validators' => array(
          array(
            'name'    => 'StringLength',
            'options' => array(
              'encoding' => 'UTF-8',
              'min'      => 1,
              'max'      => 3,
            ),
          ),
        ),
      ));

      $inputFilter->add(array(
        'name'     => 'description',
        'required' => true,
        'filters'  => array(
          array('name' => 'StripTags'),
          array('name' => 'StringTrim'),
        ),
        'validators' => array(
          array(
            'name'    => 'StringLength',
            'options' => array(
              'encoding' => 'UTF-8',
            ),
          ),
        ),
      ));

      $inputFilter->add(array(
        'name'     => 'price',
        'required' => true,
        'filters'  => array(
          array('name' => 'StripTags'),
          array('name' => 'StringTrim'),
        ),
        'validators' => array(
          array(
            'name'    => 'StringLength',
            'options' => array(
              'encoding' => 'UTF-8',
              'min'      => 1,
              'max'      => 10,
            ),
          ),
        ),
      ));

      $inputFilter->add(array(
        'name'     => 'quantity',
        'required' => true,
        'filters'  => array(
          array('name' => 'StripTags'),
          array('name' => 'StringTrim'),
        ),
        'validators' => array(
          array(
            'name'    => 'StringLength',
            'options' => array(
              'encoding' => 'UTF-8',
              'min'      => 1,
              'max'      => 10,
            ),
          ),
        ),
      ));
      $this->inputFilter = $inputFilter;
    }
    return $this->inputFilter;
  }

}