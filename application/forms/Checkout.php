<?php 

class Application_Form_Checkout extends Zend_Form
{

    public function init()
    {
		$this->setMethod("post");
		
		//first name
		$this->addElement('text','fname',array(
			'label'		=> 	'First Name:',
			'required'	=>	true,
			'filters'	=>	array('StringTrim'),
			'validators'=> 	array(
									array('validator'=>'StringLength', 'options'=>array(0,20))
									)
		
		));
		
		//last name
		$this->addElement('text','lname',array(
			'label'		=> 	'Last Name:',
			'required'	=>	true,
			'filters'	=>	array('StringTrim'),
			'validators'=> 	array(
									array('validator'=>'StringLength', 'options'=>array(0,20))
									)
		
		));
		//address 1
		$this->addElement('text','addr1',array(
			'label'		=> 	'Address 1:',
			'required'	=>	true,
			'filters'	=>	array('StringTrim'),
			'validators'=> 	array(
									array('validator'=>'StringLength', 'options'=>array(0,20))
									)
		
		));
		
		//address 2
		$this->addElement('text','addr2',array(
			'label'		=> 	'Address 2:',
			'required'	=>	false,
			'filters'	=>	array('StringTrim'),
			'validators'=> 	array(
									array('validator'=>'StringLength', 'options'=>array(0,20))
									)
		
		));
		
		//city
		$this->addElement('text','addr1',array(
			'label'		=> 	'City:',
			'required'	=>	false,
			'filters'	=>	array('StringTrim'),
			'validators'=> 	array(
									array('validator'=>'StringLength', 'options'=>array(0,20))
									)
		
		));
		
		//state
		$this->addElement('select','state',array(
			'label'		=> 	'State:',
			'required'	=>	true,
			'options'	=> 	array('nj'=>'NJ')//todo: fill out data provider
		
		));
		
		//zip
		$this->addElement('text','zip',array(
			'label'		=> 	'Zip Code:',
			'required'	=>	true,
			'validators'=> 	array(
							array('validator'=>'StringLength', 'options'=>array(0,20))
							)
		));
		
		//card number
		$this->addElement('text','card_num',array(
			'label'		=> 	'Credit Card Number:',
			'required'	=>	true,
			'validators'=> 	array(
							array('validator'=>'StringLength', 'options'=>array(0,20))
							)
		));

		//exp_date 
		$this->addElement('text','exp_date',array(
			'label'		=> 	'Expiration Date:',
			'required'	=>	true,
			'validators'=> 	array(
						array('validator'=>'StringLength', 'options'=>array(0,20))
						)
		));	
		//amount
		$this->addElement('text','amount',array(
			'label'		=> 	'Amount:',
			'required'	=>	true,
			'validators'=> 	array(
						array('validator'=>'StringLength', 'options'=>array(0,20))
						)
		));	
			
		//submit button
		$this->addElement('submit', 'submit', array(
													'ignore'=>true, 
													'label'	=>'Checkout'
		));
		
		
	}

}

