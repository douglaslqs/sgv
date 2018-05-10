<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter;
//use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class CategoryForm extends Form
{
	public function __construct()
	{
		parent::__construct('category');
		$this->setAttribute('method', 'post');
		//$this->addInputFilter();
	}

	public function addInputFilter($boolUpdate = false)
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
	                     'min' => 1,
	                     'max' => 40,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Minimun 1 chacacteres not reached',
	                         'stringLengthTooLong' => 'Maximun 40 chacacteres ultrapassed',
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
	                     'min' => 1,
	                     'max' => 40,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Minimun 1 chacacteres not reached',
	                         'stringLengthTooLong' => 'Maximun 40 chacacteres ultrapassed',
	                     ),
	                ),
	            ),
	        ),
	    ));

	    //Adiciona Prefix e retira require se for update
	    ////Adiciona os campos chaves com o prefixo
		if ($boolUpdate) {
			$required = false;
			$prefixNew = 'new_';

			$inputFilter->add(array(
		        'name' => $prefixNew.'name',
		        'required' => $required,
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
		                     'min' => 1,
		                     'max' => 40,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Minimun 1 chacacteres not reached',
		                         'stringLengthTooLong' => 'Maximun 40 chacacteres ultrapassed',
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
		        'name' => $prefixNew.'name_parent',
		        'required' => $required,
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
		                     'min' => 1,
		                     'max' => 40,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Minimun 1 chacacteres not reached',
		                         'stringLengthTooLong' => 'Maximun 40 chacacteres ultrapassed',
		                     ),
		                ),
		            ),
		        ),
		    ));

		} else {
			$required = true;
			$prefixNew = '';
		}

	    $inputFilter->add(array(
	        'name' => $prefixNew.'active',
	        'required' => false,
	        'validators' => array(
	            array(
	                'name' => 'Int',
	            ),
	            array(
	                'name' => 'Between',
					'options' => array(
					  'min' => 0,
					  'max' => 1,
					  'inclusive' => true,
					),
	            ),
	        ),
	    ));

	    $this->setInputFilter($inputFilter);
	}

}