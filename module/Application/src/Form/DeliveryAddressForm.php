<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter;
//use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class DeliveryAddressForm extends Form
{
	public function __construct()
	{
		parent::__construct('deliveryaddress');
		$this->setAttribute('method', 'post');
		//$this->addInputFilter();
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
		        'name' => 'street',
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
		                     'max' => 124,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Maximun 1 chacacteres ultrapassed',
		                         'stringLengthTooLong' => 'Minimun 124 chacacteres not reached',
		                     ),
		                ),
		            ),
		        ),
		    ));

		    $inputFilter->add(array(
		        'name' => 'number',
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
		                     'max' => 8,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Maximun 1 chacacteres ultrapassed',
		                         'stringLengthTooLong' => 'Minimun 8 chacacteres not reached',
		                     ),
		                ),
		            ),
		        ),
		    ));

		    $inputFilter->add(array(
		        'name' => 'district',
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
		                     'max' => 124,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Maximun 2 chacacteres ultrapassed',
		                         'stringLengthTooLong' => 'Minimun 124 chacacteres not reached',
		                     ),
		                ),
		            ),
		        ),
		    ));

	    //Adiciona somente se for validar add
	    if (!$boolUpdate) {
		    $inputFilter->add(array(
		        'name' => 'city',
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
		                     'max' => 124,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Maximun 2 chacacteres ultrapassed',
		                         'stringLengthTooLong' => 'Minimun 124 chacacteres not reached',
		                     ),
		                ),
		            ),
		        ),
		    ));

		    $inputFilter->add(array(
		        'name' => 'state',
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
		                     'max' => 64,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Maximun 2 chacacteres ultrapassed',
		                         'stringLengthTooLong' => 'Minimun 64 chacacteres not reached',
		                     ),
		                ),
		            ),
		        ),
		    ));

		    $inputFilter->add(array(
		        'name' => 'country',
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
		                     'max' => 64,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Maximun 2 chacacteres ultrapassed',
		                         'stringLengthTooLong' => 'Minimun 64 chacacteres not reached',
		                     ),
		                ),
		            ),
		        ),
		    ));

		    /* nao é obrigatório
		    $inputFilter->add(array(
		        'name' => 'reference',
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
		                     'max' => 256,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Maximun 3 chacacteres ultrapassed',
		                         'stringLengthTooLong' => 'Minimun 256 chacacteres not reached',
		                     ),
		                ),
		            ),
		        ),
		    ));

		    $inputFilter->add(array(
		        'name' => 'complement',
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
		                     'max' => 256,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Maximun 3 chacacteres ultrapassed',
		                         'stringLengthTooLong' => 'Minimun 256 chacacteres not reached',
		                     ),
		                ),
		            ),
		        ),
		    ));
			*/
	    }
	    $this->setInputFilter($inputFilter);
	}

}