<?php

class Application_Form_Login extends Zend_Form
{
    public function init()
    {
    	$filters 	= array('StringTrim', 'StringToLower');
    	$validatorEmail	= new Zend_Validate_EmailAddress();
    	
        $this->setName("form_login");
        $this->setMethod('post');
             
        $this->addElement('text', 'email', array(
            'filters'    => $filters,
            'validators' => array($validatorEmail),
            'required'   => true,
            'label'      => 'Email:',
        ));

        $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required'   => true,
            'label'      => 'Password:',
        ));

        $this->addElement('submit', 'login', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Login',
        ));        
    }
}