<?php
namespace Admin\Form;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;


class MyProductFilter implements  InputFilterAwareInterface
{

  private $inputFilter;

  public function setInputFilter(InputFilterInterface $inputFilter)
  {
    throw new \Exception("Not used");
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
              'min'      => 1,
              'max'      => 100,
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
              'min'      => 1,
              'max'      => 10,
            ),
          ),
          array(
            'name' => 'Digits',
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
              'min'      => 1,
              'max'      => 11,
            ),
          ),
          array(
            'name' => 'Digits',
          ),
        ),
      ));
      $this->inputFilter = $inputFilter;
    }
    return $this->inputFilter;
  }

}