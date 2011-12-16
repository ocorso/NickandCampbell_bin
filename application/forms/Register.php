<?php

class Application_Form_Register extends Zend_Form
{

    public function init()
    {
       	$user 	= new Zend_Form_SubForm();
       	$usn 	= new Zend_Form_Element_Text('username');
    	$usn->setRequired(true)
    		->setLabel('Username')
    		->setFilters(array('StringTrim','StringToLower'))
    		->addValidator(	'Alnum',
    						array('Regex', false, array('/^[a-z][a-z0-9]{2,}$/'))
    						);
       	$pwd 	= new Zend_Form_Element_Text('password');
    	$pwd->setRequired(true)
    		->setLabel('Password')
    		->setFilters(array('StringTrim'))
    		->addValidator(	'NotEmpty',
    						array('StringLength', false, array(6))
    						);
    	
    	$user->addElements(array($usn, $pwd));
    	$this->addSubForms(array($user));
    					
    }


}

