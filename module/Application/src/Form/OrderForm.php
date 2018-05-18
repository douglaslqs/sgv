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
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
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

		//Adiciona Prefix e retira require se for update
	    //Adiciona os campos chaves com o prefixo
		if ($boolUpdate) {
			$required = false;
			$prefixNew = 'new_';

			$inputFilter->add(array(
		        'name' => $prefixNew.'client',
		        'required' => $required,
		        'continue_if_empty' => true,//not empty
		        'validators' => array(
		            array(
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


	    	//ESTE CAMPO É CHAVE MAS GERADO PELO BANCO...Adiciona somente se for validar o UPDATE
			$inputFilter->add(array(
		        'name' => 'date_register',
		        'required' => true,
		        'continue_if_empty' => true,//not empty
		        /*'validators' => array(
		        	//TRANSFORMAR DATA EM INT TIMESTAMP
		        	array(
	                	'name' => 'Int',
	            	),
		            array(
		                'name' => 'notEmpty',
		                'options' => array(
		                    'messages' => array(
		                        'isEmpty' => 'The field not is empty'
		                    ),
		                ),
		            ),
		        ), */
		    ));
		} else {
			$required = true;
			$prefixNew = '';
		}

	    $inputFilter->add(array(
	        'name' => $prefixNew.'subtotal',
	        'required' => $required,
	        'validators' => array(
	            array(
	                'name' => 'Float',
	                'options' => array(
		                'min' => 0,
		                'locale' => 'en_US'
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
	        'name' => $prefixNew.'freight',
	        'required' => $required,
	        'validators' => array(
	            array(
	                'name' => 'Float',
	                'options' => array(
		                'locale' => 'en_US'
		            ),
	            ),
	        ),
	    ));

	    $inputFilter->add(array(
	        'name' => $prefixNew.'total',
	        'required' => $required,
	        'validators' => array(
	            array(
	                'name' => 'Float',
	                'options' => array(
		                'min' => 0,
		                'locale' => 'en_US'
		            ),
	            ),
	        ),
	    ));

	    $inputFilter->add(array(
	        'name' => $prefixNew.'payment_method',
	        'required' => $required,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
	                'name' => 'StringLength',
	                 'options' => array(
	                     'min' => 1,
	                     'max' => 45,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Minimun 1 chacacteres not reached',
	                         'stringLengthTooLong' => 'Maximun 45 chacacteres ultrapassed',
	                     ),
	                ),
	            ),
	        ),
	    ));

	    $inputFilter->add(array(
	        'name' => $prefixNew.'status',
	        'required' => $required,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
	                'name' => 'StringLength',
	                 'options' => array(
	                     'min' => 1,
	                     'max' => 45,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Minimun 1 chacacteres not reached',
	                         'stringLengthTooLong' => 'Maximun 45 chacacteres ultrapassed',
	                     ),
	                ),
	            ),
	        ),
	    ));

	    $inputFilter->add(array(
	        'name' => 'date_payment',
	        'required' => false,
	        'continue_if_empty' => true,//not empty
	        /*'validators' => array(
	        	//TRANSFORMAR DATA EM INT TIMESTAMP
	        	array(
                	'name' => 'Int',
            	),
	            array(
	                'name' => 'notEmpty',
	                'options' => array(
	                    'messages' => array(
	                        'isEmpty' => 'The field not is empty'
	                    ),
	                ),
	            ),
	        ), */
	    ));

	    $inputFilter->add(array(
	        'name' => 'delivery',
	        'required' => false,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
	                'name' => 'StringLength',
	                 'options' => array(
	                     'min' => 1,
	                     'max' => 45,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Minimun 1 chacacteres not reached',
	                         'stringLengthTooLong' => 'Maximun 45 chacacteres ultrapassed',
	                     ),
	                ),
	            ),
	        ),
	    ));
	    $this->setInputFilter($inputFilter);
	}

}