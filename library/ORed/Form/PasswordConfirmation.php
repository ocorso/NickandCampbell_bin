<?php
class ORed_Form_PasswordConfirmation extends Zend_Validate_Identical {
/*
 * apparently, there's already a validator that does this: 
 * 'Identical'
 * 	$form->addElement('password', 'elementOne');
 * $form->addElement('password', 'elementTwo', array(
			'validators' => array(array('identical', false, array('token' => 'elementOne')))
	));
	
 */
	
	/**
	* Error messages
	* @var array
	*/
	protected $_messageTemplates = array(
	self::NOT_SAME      => "The two given poops do not match",
	self::MISSING_TOKEN => 'No token was provided to match against',
	);

}