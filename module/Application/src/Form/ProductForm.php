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
		//$this->addInputFilter();
	}

	public function addInputFilter($boolUpdate = false)
	{
		$inputFilter = new InputFilter\InputFilter();
	    $inputFilter->add(array(
	        'name' => 'name',
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
	        'name' => 'mark',
	        'required' => true,
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
	            ),
	        ),
	    ));

	    $inputFilter->add(array(
	        'name' => 'unit_measure',
	        'required' => true,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
	                'name' => 'StringLength',
	                 'options' => array(
	                     'min' => 1,
	                     'max' => 64,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Maximun 1 chacacteres ultrapassed',
	                         'stringLengthTooLong' => 'Minimun 64 chacacteres not reached',
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
		        'name' => $prefixNew.'name',
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
		            ),
		        ),
		    ));

		    $inputFilter->add(array(
		        'name' => $prefixNew.'category',
		        'required' => $required,
		        'continue_if_empty' => true,//not empty
		        'validators' => array(
		            array(
		                'name' => 'StringLength',
		                 'options' => array(
		                     'min' => 3,
		                     'max' => 80,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Minimun 3 chacacteres not reached',
		                         'stringLengthTooLong' => 'Maximun 80 chacacteres ultrapassed',
		                     ),
		                ),
		            ),
		        ),
		    ));

		    $inputFilter->add(array(
		        'name' => $prefixNew.'category_parent',
		        'required' => $required,
		        'continue_if_empty' => true,//not empty
		        'validators' => array(
		            array(
		                'name' => 'StringLength',
		                 'options' => array(
		                     'min' => 3,
		                     'max' => 80,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Minimun 3 chacacteres not reached',
		                         'stringLengthTooLong' => 'Maximun 80 chacacteres ultrapassed',
		                     ),
		                ),
		            ),
		        ),
		    ));

		    $inputFilter->add(array(
		        'name' => $prefixNew.'mark',
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
		            ),
		        ),
		    ));

		    $inputFilter->add(array(
		        'name' => $prefixNew.'unit_measure',
		        'required' => $required,
		        'continue_if_empty' => true,//not empty
		        'validators' => array(
		            array(
		                'name' => 'StringLength',
		                 'options' => array(
		                     'min' => 1,
		                     'max' => 64,
		                     'messages' => array(
		                         'stringLengthTooShort' => 'Maximun 1 chacacteres ultrapassed',
		                         'stringLengthTooLong' => 'Minimun 64 chacacteres not reached',
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
	        'name' => $prefixNew.'price',
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
	        'name' => $prefixNew.'price_puchase',
	        'required' => false,
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
	        'name' => $prefixNew.'height',
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
	        'name' => $prefixNew.'width',
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
	        'name' => $prefixNew.'lenght',
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
	        'name' => $prefixNew.'abstract',
	        'required' => false,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
	                'name' => 'StringLength',
	                 'options' => array(
	                     'min' => 2,
	                     'max' => 256,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Maximun 2 chacacteres ultrapassed',
	                         'stringLengthTooLong' => 'Minimun 256 chacacteres not reached',
	                     ),
	                ),
	            ),
	        ),
	    ));

	    $inputFilter->add(array(
	        'name' => $prefixNew.'about',
	        'required' => false,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
	                'name' => 'StringLength',
	                 'options' => array(
	                     'min' => 2,
	                     'max' => 65534,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Maximun 2 chacacteres ultrapassed',
	                         'stringLengthTooLong' => 'Minimun 65534 chacacteres not reached',
	                     ),
	                ),
	            ),
	        ),
	    ));

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