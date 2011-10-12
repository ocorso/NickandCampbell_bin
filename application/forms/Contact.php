<?php

class Application_Form_Contact extends Zend_Form
{

    public function init()
    {
       $this->setMethod('post');

       //name
       $this->addElement(new Zend_Form_Element_Text('givenName', array(
       		'required'	=> true,
       		'label'		=> 'Name',
       		'filters'	=> array('StringTrim'),
       		'validators'=> array(
       			array('Regex',
       				false,
       				array('/^[a-z][a-z0-9., \'-]{2,}$/i'))
       				)
       			)));
       $this->getElement('givenName')
		     ->addDecorator('Label', array('class' => 'form-label'))	
	 		 ->addDecorator('Errors', array('class' => 'err-phone-number'));
	 		 
       //phone
		$this->addElement(new Zend_Form_Element_Text('phone_number'));
		$this->getElement('phone_number')
		     ->setLabel('Phone Number')
		     ->addDecorator('Label', array('class' => 'form-label'))	
	 		 ->addDecorator('Errors', array('class' => 'err-phone-number'))
		     ->setRequired(true)
		     ->addValidators(array(
		         array(
		             'validator'   => 'Regex',
		             'breakChainOnFailure' => true,
		             'options'     => array( 
		             'pattern' => '/^[+]?[-\d() .]*$/i',
		                 'messages' => array(
		                     Zend_Validate_Regex::NOT_MATCH =>'Please provide a valid Phone Number.'
		                 )
		             )
		         ),
		         array(
		             'validator' => 'StringLength',
		             'breakChainOnFailure' => true,
		             'options' => array(
		                 'min' => 10
		             )
		         )
		     ));
		       			   			
       //email field
       $this->addElement('text', 'email', array(
       		'label'		=> "Email",
      		'required'	=> true,
			'filters'	=> array('StringTrim'),
       		'validators'=> array('EmailAddress')
       	));
       $this->getElement('email')
		     ->addDecorator('Label', array('class' => 'form-label'))	
	 		 ->addDecorator('Errors', array('class' => 'err-phone-number'));
       	
       	//comment field
       	$this->addElement('textarea', 'comment', array(
       		'label'		=> "Comments",
       		'required'	=> true,
//       		'validators'=> array(
//       			'validator'=> 'StringLength', 'options' => array('min'=>0, 'max'=>255) )
       	));
       $this->getElement('comment')
		     ->addDecorator('Label', array('class' => 'form-label'))	
	 		 ->addDecorator('Errors', array('class' => 'err-phone-number'));
       	
       	//submit
       	$this->addElement('submit', 'submit', array(
       		'ignore'	=> true,
       		'label'		=> 'Submit'));
       	
       	//csrf
       	$this->addElement('hash', 'csrf',array('ignore'=>true) );
       	
    }//end function init


}

