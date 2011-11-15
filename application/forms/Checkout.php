<?php 

class Application_Form_Checkout extends Zend_Form
{
	//http://www.zend.com//code/codex.php?ozid=1320&single=1
// From a previous HTML Form, pass the following fields: 
// $FirstName = Customer's First Name 
// $LastName = Customer's Last Name 
// $Address = Customer's Address 
// $City = Customer's City 
// $State = Customer's State (Should be 2 letter code, CA, AZ, etc.) 
// $Zip = Customer's Zip Code 
// $Email = Customer's Email Address 
// $cost = Total Price of purchase 
// $CardNum = Customer's Credit Card Number 
// $Month = Customer's Credit Card Expiration Month (Should be 01, 02, etc.) 
// $Year = Customer's Credit Card Expiration Year (Should be 2003, 2004, etc.) 
	
    public function init()
    {
		$this->setMethod("post");
		
		$shipping1 	= new Zend_Form_SubForm();
		$shipping2 	= new Zend_Form_SubForm();
		$billing1	= new Zend_Form_SubForm();
		$billing2	= new Zend_Form_SubForm();
		$confirm	= new Zend_Form_SubForm();
		
		//first name
		$shipping1->addElement('text','fname',array(
			'label'		=> 	'First Name:',
			'required'	=>	true,
			'filters'	=>	array('StringTrim', 'StringToLower'),
			'validators'=> 	array(
									array('validator'=>'StringLength', 'options'=>array(0,20))
									)
		
		));
		
		//last name
		$shipping1->addElement('text','lname',array(
			'label'		=> 	'Last Name:',
			'required'	=>	true,
			'filters'	=>	array('StringTrim'),
			'validators'=> 	array(
									array('validator'=>'StringLength', 'options'=>array(0,20))
									)
		
		));
		//address 1
		$shipping1->addElement('text','addr1',array(
			'label'		=> 	'Address 1:',
			'required'	=>	true,
			'filters'	=>	array('StringTrim'),
			'validators'=> 	array(
									array('validator'=>'StringLength', 'options'=>array(0,20))
									)
		
		));
		
		//address 2
		$shipping1->addElement('text','addr2',array(
			'label'		=> 	'Address 2:',
			'required'	=>	false,
			'filters'	=>	array('StringTrim'),
			'validators'=> 	array(
									array('validator'=>'StringLength', 'options'=>array(0,20))
									)
		
		));
		
		//city
		$shipping1->addElement('text','city',array(
			'label'		=> 	'City:',
			'required'	=>	false,
			'filters'	=>	array('StringTrim'),
			'validators'=> 	array(
									array('validator'=>'StringLength', 'options'=>array(0,20))
									)
		
		));
		
		//states
		$statesArr = array('AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado','CT'=>'Connecticut','DE'=>'Delaware','DC'=>'District Of Columbia','FL'=>'Florida','GA'=>'Georgia','HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois', 'IN'=>'Indiana', 'IA'=>'Iowa',  'KS'=>'Kansas','KY'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland', 'MA'=>'Massachusetts','MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana','NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico','NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma', 'OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island','SC'=>'South Carolina','SD'=>'South Dakota','TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington','WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming'); 
		$state = new Zend_Form_Element_Select('state');
		$state->setLabel('State')
		->setMultiOptions($statesArr)
		->setRegisterInArrayValidator(false);
		$shipping1->addElement($state);
		
		//zip
		$shipping1->addElement('text','zip',array(
			'label'		=> 	'Zip Code:',
			'required'	=>	true,
			'validators'=> 	array(
							array('validator'=>'StringLength', 'options'=>array(0,20))
							)
		));
		
		//card number
		$billing2->addElement('text','card_num',array(
			'label'		=> 	'Credit Card Number:',
			'required'	=>	true,
			'validators'=> 	array(
							array('validator'=>'StringLength', 'options'=>array(0,20))
							)
		));

		//exp_date 
		$billing2->addElement('text','exp_date',array(
			'label'		=> 	'Expiration Date:',
			'required'	=>	true,
			'validators'=> 	array(
						array('validator'=>'StringLength', 'options'=>array(0,20))
						)
		));	
		//amount
		$confirm->addElement('text','amount',array(
			'label'		=> 	'Amount:',
			'required'	=>	true,
			'validators'=> 	array(
						array('validator'=>'StringLength', 'options'=>array(0,20))
						)
		));	
			
		//submit button
		$confirm->addElement('submit', 'submit', array(
													'ignore'=>true, 
													'label'	=>'Checkout'
		));
		$subForms 		= array(	'shipping1'=> $shipping1,
									'shipping2'=> $shipping2,
									'billing1'=> $billing1,
									'billing2'=> $billing2,
									'confirm'=>	$confirm);
		
		$this->addSubForms($subForms);
		
	}

}

