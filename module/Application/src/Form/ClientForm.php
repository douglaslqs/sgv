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
	                     'max' => 64,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Minimun 3 chacacteres not reached',
	                         'stringLengthTooLong' => 'Maximun 64 chacacteres ultrapassed',
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

	    //Adiciona Prefix e retira require se for update
	    //Adiciona os campos chaves com o prefixo
		if ($boolUpdate) {
			$required = false;
			$prefixNew = 'new_';

			$inputFilter->add(array(
		        'name' => $prefixNew.'email',
		        'required' => $required,
		        'continue_if_empty' => true,//not empty
		        'validators' => array(
		            array(
		                'name' => 'StringLength',
		                 'options' => array(
		                     'min' => 3,
		                     'max' => 64,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Minimun 3 chacacteres not reached',
		                         'stringLengthTooLong' => 'Maximun 64 chacacteres ultrapassed',
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
		} else {
			$required = true;
			$prefixNew = '';
		}

	    $inputFilter->add(array(
	        'name' => 'type',
	        'required' => $required,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
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
		        'name' => $prefixNew.'document',
		        'required' => $required,
		        'continue_if_empty' => true,//not empty
		        'validators' => array(
		            array(
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
		    $inputFilter->add(array(
		        'name' => $prefixNew.'tribute_info',
		        'required' => false,
		        'continue_if_empty' => true,//not empty
		        'validators' => array(
		            array(
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
		        'name' => $prefixNew.'state_register',
		        'required' => false,
		        'continue_if_empty' => false,//not empty
		        'validators' => array(
		            array(
		                'name' => 'Float',
		                'options' => array(
			                'min' => 0,
			                'locale' => 'en_US'
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
	    } else {
	    	$inputFilter->add(array(
		        'name' => $prefixNew.'document',
		        'required' => $required,
		        'continue_if_empty' => true,//not empty
		        'validators' => array(
		            array(
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
	        'name' => $prefixNew.'password',
	        'required' => $required,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
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
	        'name' => $prefixNew.'name',
	        'required' => $required,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
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
	        'name' => $prefixNew.'phone_primary',
	        'required' => $required,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
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
	        'name' => $prefixNew.'phone_segundary',
	        'required' => false,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
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
	        'name' => $prefixNew.'receive_marketing',
	        'required' => $required,
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