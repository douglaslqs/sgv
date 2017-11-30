<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter;
//use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class CategoryForm extends Form
{
	public function __construct()
	{
		parent::__construct('consultor');

		$this->setAttribute('method', 'post');
		$this->addInputFilter();
	}

	public function addInputFilter()
	{
	    $inputFilter = new InputFilter\InputFilter();	    

	    $inputFilter->add(array(
	        'name' => 'name',
	        'required' => true,
	        'filters' => array(	            
	            array('name' => 'StringTrim'),	            
	        ),
	        'validators' => array(
	            array(
	                'name' => 'notEmpty',
	                'options' => array(
	                    'messages' => array(
	                        'isEmpty' => 'The field not is empty'),
	                ),
	                'name' => 'StringLength',
	                 'options' => array(
	                     'min' => 5,
	                     'max' => 60,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Maximun chacacteres ultrapassed',
	                         'stringLengthTooLong' => 'Minimun chacacteres not reached',
	                     ),
	                 ),
	            ),	        
	        ),
	    ));
	     
	    $this->setInputFilter($inputFilter);
	}

}