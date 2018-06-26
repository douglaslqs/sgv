<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter;
//use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class ResourceForm extends Form
{
	public function __construct()
	{
		parent::__construct('resource');
		$this->setAttribute('method', 'post');
		//$this->addInputFilter();
	}

	public function addInputFilter($boolUpdate = false)
	{
	    $inputFilter = new InputFilter\InputFilter();

	    $inputFilter->add(array(
	        'name' => 'module',
	        'required' => true,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
	                'name' => 'StringLength',
	                 'options' => array(
	                     'min' => 2,
	                     'max' => 124,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Minimun 2 chacacteres not reached',
	                         'stringLengthTooLong' => 'Maximun 124 chacacteres ultrapassed',
	                     ),
	                ),
	            ),
	        ),
	    ));

	    $inputFilter->add(array(
	        'name' => 'controller',
	        'required' => true,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
	                'name' => 'StringLength',
	                 'options' => array(
	                     'min' => 2,
	                     'max' => 124,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Minimun 2 chacacteres not reached',
	                         'stringLengthTooLong' => 'Maximun 124 chacacteres ultrapassed',
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
	        'name' => $prefixNew.'module',
	        'required' => false,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
	                'name' => 'StringLength',
	                 'options' => array(
	                     'min' => 2,
	                     'max' => 124,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Minimun 2 chacacteres not reached',
	                         'stringLengthTooLong' => 'Maximun 124 chacacteres ultrapassed',
	                     ),
	                ),
	            ),
	        ),
	    ));

	    $inputFilter->add(array(
	        'name' => $prefixNew.'controller',
	        'required' => false,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
	                'name' => 'StringLength',
	                 'options' => array(
	                     'min' => 2,
	                     'max' => 124,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Minimun 2 chacacteres not reached',
	                         'stringLengthTooLong' => 'Maximun 124 chacacteres ultrapassed',
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
	        'name' => $prefixNew.'description',
	        'required' => false,
	        'continue_if_empty' => true,//not empty
	        'validators' => array(
	            array(
	                'name' => 'StringLength',
	                 'options' => array(
	                     'min' => 2,
	                     'max' => 255,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Minimun 2 chacacteres not reached',
	                         'stringLengthTooLong' => 'Maximun 255 chacacteres ultrapassed',
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