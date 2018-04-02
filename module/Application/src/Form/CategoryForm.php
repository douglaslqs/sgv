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
	            array(
	            	'name' => 'Zend\Filter\StringTrim',
	            	'name' => 'Zend\Filter\StripTags'
	        	),
	        ),
	        'validators' => array(
	            array(
	                'name' => 'notEmpty',
	                'options' => array(
	                    'messages' => array(
	                        'isEmpty' => 'The field not is empty'
	                    ),
	                ),
	                'name' => 'StringLength',
	                 'options' => array(
	                     'min' => 3,
	                     'max' => 40,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Maximun 40 chacacteres ultrapassed',
	                         'stringLengthTooLong' => 'Minimun 3 chacacteres not reached',
	                     ),
	                ),
	                 /* PESQUISAR MAIS SOBRE ISSO!!
	                'name' => 'Alnum',
	                 'options' => array(
	                    'allowWhiteSpace' => true,
	                    'messages' => array(
	                        'allowWhiteSpace' => 'Spaces white duple not permission',
	                    ),
	                ), */
	            ),
	        ),
	    ));

	    $inputFilter->add(array(
	        'name' => 'name_parent',
	        'required' => true,
	        'filters' => array(
	            array(
	            	'name' => 'StringTrim',
	            	'name' => 'StripTags',
	            	//'name' => 'StripNewlines',
	        	),
	        ),
	        'validators' => array(
	            array(
	                'name' => 'notEmpty',
	                'options' => array(
	                    'messages' => array(
	                        'isEmpty' => 'The field not is empty'
	                    ),
	                ),
	                'name' => 'StringLength',
	                 'options' => array(
	                     'min' => 3,
	                     'max' => 40,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Maximun 40 chacacteres ultrapassed',
	                         'stringLengthTooLong' => 'Minimun 3 chacacteres not reached',
	                     ),
	                ),
	                 /* PESQUISAR MAIS SOBRE ISSO!!
	                'name' => 'Alnum',
	                 'options' => array(
	                    'allowWhiteSpace' => true,
	                    'messages' => array(
	                        'allowWhiteSpace' => 'Spaces white duple not permission',
	                    ),
	                ), */
	            ),
	        ),
	    ));

	    $this->setInputFilter($inputFilter);
	}

}