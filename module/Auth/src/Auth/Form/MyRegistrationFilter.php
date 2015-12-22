<?php
namespace Auth\Form;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;


class MyRegistrationFilter implements  InputFilterAwareInterface
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
              'min'      => 2,
              'max'      => 20,
            ),
          ),
        ),
      ));

      $inputFilter->add(array(
        'name'     => 'email',
        'required' => true,
        'filters'  => array(
          array('name' => 'StripTags'),
          array('name' => 'StringTrim'),
        ),
        'validators' => array(
          array(
            'name'    => 'EmailAddress',
          ),
          array(
            'name'    => 'StringLength',
            'options' => array(
              'min'      => 5,
              'max'      => 50,
            ),
          ),
        ),
      ));

      $inputFilter->add(array(
        'name'     => 'tel',
        'required' => true,
        'filters'  => array(
          array('name' => 'StripTags'),
          array('name' => 'StringTrim'),
        ),
        'validators' => array(
          array(
            'name'    => 'StringLength',
            'options' => array(
              'min'      => 10,
              'max'      => 20,
            ),
          ),
          array(
            'name'    => 'Regex',
            'options' => array(
              'pattern' => '/\+?[0-9 )(-]+/'
            ),
          ),
        ),
      ));

      $inputFilter->add(array(
        'name'     => 'pass',
        'required' => true,
        'filters'  => array(
          array('name' => 'StripTags'),
          array('name' => 'StringTrim'),
        ),
        'validators' => array(
          array(
            'name'    => 'StringLength',
            'options' => array(
              'min'      => 5,
              'max'      => 16,
            ),
          ),
        ),
      ));

      $inputFilter->add(array(
        'name'     => 'rePass',
        'required' => true,
        'filters'  => array(
          array('name' => 'StripTags'),
          array('name' => 'StringTrim'),
        ),
        'validators' => array(
          array(
            'name'    => 'StringLength',
            'options' => array(
              'min'      => 5,
              'max'      => 16,
            ),
          ),
        ),
      ));

      $this->inputFilter = $inputFilter;
    }
    return $this->inputFilter;
  }

}