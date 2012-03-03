<?php

class Application_Form_Register extends Zend_Form
{

    public function init()
    {
       	$user 	= new Zend_Form_SubForm();
       	
       	//2 in 1 package
       	$filters 						= array('StringTrim', 'StringToLower');
       	$validatorEmail					= new Zend_Validate_EmailAddress();

       	
       	//first name
       	$firstName		= new Zend_Form_Element_Text("cust_first_name");
       	$firstName->setLabel('First Name')
       	->setRequired(true)
       	->setFilters($filters);
       	
       	//last name
       	$lastName		= new Zend_Form_Element_Text("cust_last_name");
       	$lastName->setLabel('Last Name')
       	->setRequired(true)
       	->setFilters($filters);

       	$email 	= new Zend_Form_Element_Text('cust_email');
    	$email->setRequired(true)
    		->setLabel('Email')
    		->setFilters(array('StringTrim','StringToLower'))
    		->addValidator(	'EmailAddress',
    						array('Regex', false, array('/^[a-z][a-z0-9]{2,}$/'))
    						);
       	$pwd 	= new Zend_Form_Element_Password('password');
    	$pwd->setRequired(true)
    		->setLabel('Password')
    		->setFilters(array('StringTrim'))
    		->addValidator(	'NotEmpty', 
    						array('StringLength', false, array(6))
    						);
    	$validatorPasswordConfirmation 	= new ORed_Form_PasswordConfirmation(array('token'=>'password'));
       	$pwd2 	= new Zend_Form_Element_Password('password2');
    	$pwd2->setRequired(true)
    		->setLabel('Confirm Password')
    		->setFilters(array('StringTrim'))
    		->addValidator($validatorPasswordConfirmation);
       	
       	//phone
       	$phone			= new Zend_Form_Element_Text('cust_phone');
       	$phone->setLabel('Phone')
       	->setRequired(true)
       	->addFilter("Digits");
    	
       	//submit button
       	
       	//todo: make new decorator for submit button.
       	$submitBtn	= new Zend_Form_Element_Submit("submit");
       	$submitBtn->setLabel('Submit')
       	->setAttrib("class", "vip")
       	//->removeDecorator('DtDdWrapper')
       	->setIgnore(true);
       	
       	
    	$user->addElements(array($firstName, $lastName, $phone, $email, $pwd, $pwd2, $submitBtn));
    	$this->addSubForms(array($user));
    					
    }


}

