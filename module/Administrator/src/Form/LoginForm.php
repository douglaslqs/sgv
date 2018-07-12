<?php
namespace Administrator\Form;

use Zend\Form\Form;
use Zend\InputFilter;
//use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class LoginForm extends Form
{
	public function __construct()
	{
		parent::__construct('login');
		$this->setAttribute('method', 'post');
		$this->addElement();
		$this->addInputFilter();
	}

	public function addElement()
	{
		$this->add(array(
	        'name' => 'email',
    		'type'  => 'text',
	        'required' => true,
	        'attributes' => array(
        		'class' => 'form-control',
                'id' => 'email',
                'autocomplete' => 'off',
                'placeholder' => 'E-mail',
            ),
	    ));

	    $this->add(array(
	        'name' => 'password',
    		'type'  => 'password',
	        'required' => true,
	        'attributes' => array(
	        		'class' => 'form-control',
                    'id' => 'password',
                    'autocomplete' => 'off',
                    'placeholder' => 'Password',
                ),
	    ));

	    $this->add(array(
	        'name' => 'remember',
    		'type'  => 'checkbox',
	        'attributes' => array(
	                'id' => 'remember',
	            ),
	    ));

		$this->add(array(
	        'name' => 'redirect_url',
	        'required' => false,
	        )
	    );
	}

	public function addInputFilter($boolUpdate = false)
	{
	    $inputFilter = new InputFilter\InputFilter();

	    $inputFilter->add(array(
	        'name' => 'email',
	        'required' => true,
	        'continue_if_empty' => true,//not empty
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
	                     'min' => 5,
	                     'max' => 64,
	                     'messages' => array(
	                         'stringLengthTooShort' => 'Minimun 5 chacacteres not reached',
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
	            ),
	        ),
	    ));

	    $inputFilter->add(array(
	        'name' => 'password',
	        'required' => true,
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

	    $this->setInputFilter($inputFilter);
	}

}