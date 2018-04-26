<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter;

class OrderForm extends Form
{
	public function __construct()
	{
		parent::__construct('order');
		$this->setAttribute('method', 'post');
	}

	public function addInputFilter($boolUpdate = false)
	{
	    $inputFilter = new InputFilter\InputFilter();

	    $inputFilter->add(array(
	        'name' => 'client',
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
	                         'stringLengthTooShort' => 'Minimun 3 chacacteres not reached',
	                         'stringLengthTooLong' => 'Maximun 160 chacacteres ultrapassed',
	                     ),
	                ),
	                'name' => 'EmailAddress',
	                'options' => array(
	                     'messages' => array(
	                         //'emailAddressInvalidFormat' => 'The input is not a valid email address. Use the basic format local-part@hostname',
	                         //'emailAddressInvalidHostname' => 'The host name not is valid'
	                     ),
	                ),
	            ),
	        ),
	    ));
	    //Adiciona somente se for validar o UPDATE
	    if ($boolUpdate) {
		    $inputFilter->add(array(
		        'name' => 'date_register',
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
	    //Adiciona somente se for validar o CADASTRO
		} else {	    
		    $inputFilter->add(array(
		        'name' => 'subtotal',
		        'required' => true,
		        'validators' => array(
		            array(
		                'name' => 'notEmpty',
		                'options' => array(
		                    'messages' => array(
		                        'isEmpty' => 'The field not is empty'
		                    ),
		                ),
		                /*'name' => 'StringLength',
		                 'options' => array(
					        'pattern' => '/[0-9a-zA-Z\s\'.;-]+/',
					            'messages' => array(
					            \Zend\Validator\Regex::INVALID_CHARACTERS => "Invalid characters in address"
					        )
					    ), */
		            ),
		        ),
		    ));

		    $inputFilter->add(array(
		        'name' => 'freight',
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
		        'name' => 'total',
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
		        'name' => 'payment_method',
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
		                     'min' => 2,
		                     'max' => 45,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Minimun 10 chacacteres not reached',
		                         'stringLengthTooLong' => 'Maximun 45 chacacteres ultrapassed',
		                     ),
		                ),
		            ),
		        ),
		    ));
		}

	    $this->setInputFilter($inputFilter);
	}

}