<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter;
//use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class ProductForm extends Form
{
	public function __construct()
	{
		parent::__construct('product');
		$this->setAttribute('method', 'post');
		$this->addInputFilter();
	}

	public function addInputFilter($boolUpdate = false)
	{
	    $inputFilter = new InputFilter\InputFilter();

	    $inputFilter->add(array(
	        'name' => 'name',
	        'required' => true,
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
	                     'max' => 160,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Maximun 160 chacacteres ultrapassed',
	                         'stringLengthTooLong' => 'Minimun 3 chacacteres not reached',
	                     ),
	                ),
	                 /* PERMITE APENAS ALPHA NUMERICO!!
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
	        'name' => 'category',
	        'required' => true,
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
	                     'max' => 80,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Maximun 80 chacacteres ultrapassed',
	                         'stringLengthTooLong' => 'Minimun 3 chacacteres not reached',
	                     ),
	                ),
	            ),
	        ),
	    ));

	    $inputFilter->add(array(
	        'name' => 'category_parent',
	        'required' => true,
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
	                     'max' => 80,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Maximun 80 chacacteres ultrapassed',
	                         'stringLengthTooLong' => 'Minimun 3 chacacteres not reached',
	                     ),
	                ),
	            ),
	        ),
	    ));

	    $inputFilter->add(array(
	        'name' => 'category_parent',
	        'required' => true,
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
	                     'max' => 64,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Maximun 64 chacacteres ultrapassed',
	                         'stringLengthTooLong' => 'Minimun 3 chacacteres not reached',
	                     ),
	                ),
	            ),
	        ),
	    ));

	    $inputFilter->add(array(
	        'name' => 'unit_measure',
	        'required' => true,
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
	                     'max' => 64,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Maximun 1 chacacteres ultrapassed',
	                         'stringLengthTooLong' => 'Minimun 3 chacacteres not reached',
	                     ),
	                ),
	            ),
	        ),
	    ));
	    //Adiciona somente se for validar o cadastro
	    if (!$boolUpdate) {
		    $inputFilter->add(array(
		        'name' => 'price',
		        'required' => true,
		        'validators' => array(
		            array(
		                'name' => 'notEmpty',
		                'options' => array(
		                    'messages' => array(
		                        'isEmpty' => 'The field not is empty'
		                    ),
		                ),
		            ),
		        ),
		    ));

		    $inputFilter->add(array(
		        'name' => 'height',
		        'required' => true,
		        'validators' => array(
		            array(
		                'name' => 'notEmpty',
		                'options' => array(
		                    'messages' => array(
		                        'isEmpty' => 'The field not is empty'
		                    ),
		                ),
		            ),
		        ),
		    ));

		    $inputFilter->add(array(
		        'name' => 'width',
		        'required' => true,
		        'validators' => array(
		            array(
		                'name' => 'notEmpty',
		                'options' => array(
		                    'messages' => array(
		                        'isEmpty' => 'The field not is empty'
		                    ),
		                ),
		            ),
		        ),
		    ));

		     $inputFilter->add(array(
		        'name' => 'lenght',
		        'required' => true,
		        'validators' => array(
		            array(
		                'name' => 'notEmpty',
		                'options' => array(
		                    'messages' => array(
		                        'isEmpty' => 'The field not is empty'
		                    ),
		                ),
		            ),
		        ),
		    ));
	    }

	    $this->setInputFilter($inputFilter);
	}

}