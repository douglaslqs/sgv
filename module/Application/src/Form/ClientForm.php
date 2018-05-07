<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter;

class ClientForm extends Form
{
	public function __construct()
	{
		parent::__construct('client');
		$this->setAttribute('method', 'post');
	}

	public function addInputFilter($boolUpdate = false, $typeDocument = 'PF')
	{
	    $inputFilter = new InputFilter\InputFilter();

	    $inputFilter->add(array(
	        'name' => 'email',
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
	    //Adiciona somente se for validar o cadastro
	    if (!$boolUpdate) {
		    $inputFilter->add(array(
		        'name' => 'type',
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
		                     'max' => 2,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Minimun 2 chacacteres not reached',
		                         'stringLengthTooLong' => 'Maximun 2 chacacteres ultrapassed',
		                     ),
		                ),
		                'name' => 'InArray',
                         'options' => array(
                            'haystack' => array('PJ','PF'),
                            'messages' => array(
                                'notInArray' => "Types acepts 'PF' or 'PJ'"
                            ),
                        ),
		            ),
		        ),
		    ));

		    if ($typeDocument == 'PJ') {
		    	$inputFilter->add(array(
			        'name' => 'document',
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
			                 	'encoding' => 'UTF-8',
			                     'min' => 8,
			                     'max' => 20,
			                     'messages' => array(
			                         'stringLengthTooShort' => 'Minimun 8 chacacteres not reached',
			                         'stringLengthTooLong' => 'Maximun 20 chacacteres ultrapassed',
			                     ),
			                ),
			            ),
			            array(
	                        'name' => 'DiegoBrocanelli\Validators\CNPJ' // Inserir a namespace.
	                    ),
			        ),
			    ));
		    } else {
		    	$inputFilter->add(array(
			        'name' => 'document',
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
			                 	'encoding' => 'UTF-8',
			                     'min' => 8,
			                     'max' => 20,
			                     'messages' => array(
			                         'stringLengthTooShort' => 'Minimun 8 chacacteres not reached',
			                         'stringLengthTooLong' => 'Maximun 20 chacacteres ultrapassed',
			                     ),
			                ),
			            ),
			            array(
	                        'name' => 'DiegoBrocanelli\Validators\CPF' // Inserir a namespace.
	                    ),
			        ),
			    ));
		    }

		    $inputFilter->add(array(
		        'name' => 'password',
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
		                     'min' => 6,
		                     'max' => 20,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Minimun 6 chacacteres not reached',
		                         'stringLengthTooLong' => 'Maximun 20 chacacteres ultrapassed',
		                     ),
		                ),
		            ),
		        ),
		    ));

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
		                     'max' => 128,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Minimun 3 chacacteres not reached',
		                         'stringLengthTooLong' => 'Maximun 128 chacacteres ultrapassed',
		                     ),
		                ),
		            ),
		        ),
		    ));

		    $inputFilter->add(array(
		        'name' => 'phone_primary',
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
		                     'min' => 10,
		                     'max' => 15,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Minimun 10 chacacteres not reached',
		                         'stringLengthTooLong' => 'Maximun 15 chacacteres ultrapassed',
		                     ),
		                ),
		            ),
		        ),
		    ));

		    $inputFilter->add(array(
		        'name' => 'phone_segundary',
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
		                     'min' => 10,
		                     'max' => 15,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Minimun 10 chacacteres not reached',
		                         'stringLengthTooLong' => 'Maximun 15 chacacteres ultrapassed',
		                     ),
		                ),
		            ),
		        ),
		    ));
		    /* SOMENTE PARA PJ
		    $inputFilter->add(array(
		        'name' => 'tribute_info',
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
		                         'stringLengthTooShort' => 'Minimun 2 chacacteres not reached',
		                         'stringLengthTooLong' => 'Maximun 45 chacacteres ultrapassed',
		                     ),
		                ),
		            ),
		        ),
		    ));

		    $inputFilter->add(array(
		        'name' => 'state_register',
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
		                     'max' => 20,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Minimun 3 chacacteres not reached',
		                         'stringLengthTooLong' => 'Maximun 20 chacacteres ultrapassed',
		                     ),
		                ),
		            ),
		        ),
		    ));
			*/
		    $inputFilter->add(array(
		        'name' => 'receive_marketing',
		        'required' => true,
		        'validators' => array(
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
		}

	    $this->setInputFilter($inputFilter);
	}

}