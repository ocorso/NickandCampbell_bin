<?php 

class Application_Form_Checkout extends Zend_Form
{
	protected $_statesArr = array('AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado','CT'=>'Connecticut','DE'=>'Delaware','DC'=>'District Of Columbia','FL'=>'Florida','GA'=>'Georgia','HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois', 'IN'=>'Indiana', 'IA'=>'Iowa',  'KS'=>'Kansas','KY'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland', 'MA'=>'Massachusetts','MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana','NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico','NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma', 'OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island','SC'=>'South Carolina','SD'=>'South Dakota','TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington','WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming');
	
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
    	$this->setAction("/checkout/transaction-results")
			->setMethod("post")
			->setAttrib('id', 'checkout_form');
		
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
//++++++++++++++++++++++ ZEND FILTERS ++++++++++++++++++++++++++++++++++++++		
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
		// Concrete filter instance:
		//$element->addFilter(new Zend_Filter_Alnum());
		$filterAlpha 		= new Zend_Filter_Alpha();
		$FilterStrTrim		= new Zend_Filter_StringTrim();
		$FilterStrToLower	= new Zend_Filter_StringToLower();
		$filterDigits		= new Zend_Filter_Digits();
		 
		// Short filter name:
		//$element->addFilter('Alnum');
		
		//3 in 1 package
		$filters 	= array('StringTrim', 'StringToLower');
		
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
//++++++++++++++++++++++++ZEND VALIDATORS +++++++++++++++++++++++++++++++++++++++		
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	$validatorEmail	= new Zend_Validate_EmailAddress();
	$validatorCC	= new Zend_Validate_CreditCard();
	
	$validatorAlNum	= new Zend_Validate_Alnum();
	$validatorAlpha	= new Zend_Validate_Alpha();
	$validators		= array($validatorAlpha);
	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
//++++++++++++++++++++++++ZEND SUB FORMS +++++++++++++++++++++++++++++++++++++++		
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
		$shipping1 	= new Zend_Form_SubForm();
		
		$shipping2 	= new Zend_Form_SubForm();
		$billing1	= new Zend_Form_SubForm();
		$billing2	= new Zend_Form_SubForm();
		$confirm	= new Zend_Form_SubForm();
		
// ===================================================================
// ============= Shipping1 : Customer Info and Shipping Address
// =====================================================================	
		//print_r($shipping1->getDecorators());

		$shipping1->removeDecorator('DtDdWrapper');
		$shipping2->removeDecorator('DtDdWrapper');
		$billing1->removeDecorator('DtDdWrapper');
		$billing2->removeDecorator('DtDdWrapper');
		$confirm->removeDecorator('DtDdWrapper');
		
		
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
		
		//phone
		$phone			= new Zend_Form_Element_Text('cust_phone');
		$phone->setLabel('Phone')
			->setRequired(true)
			->addFilter("Digits");
		
		//email	
		$email			= new Zend_Form_Element_Text('cust_email');
		$email->setLabel('Email')
			->setRequired(true)
			->addValidator($validatorEmail)
			->setFilters($filters);//todo: validate for email
			
		//address 1
		$shAddr1			= new Zend_Form_Element_Text("sh_addr1");
		$shAddr1->setLabel('Address 1')
			->setRequired(true)
			->setFilters($filters);
		
		//address 2
		$shAddr2			= new Zend_Form_Element_Text("sh_addr2");
		$shAddr2->setLabel('Address 2')
			->setFilters($filters);
		
		//city
		$shCity				= new Zend_Form_Element_Text("sh_city");
		$shCity->setLabel("City")
			->setRequired(true)
			->setFilters($filters);

		//state
		$shState			= new Zend_Form_Element_Select("sh_state");
		$shState->setLabel("State")
			->setRequired(true)
		//	->addFilter($filters)
			->setMultiOptions($this->_statesArr);
		
		//zip
		$shZip				= new Zend_Form_Element_Text("sh_zip");
		$shZip->setLabel("Zip Code")
			->setRequired(true)
			->addFilter("Digits");
			
		$shipping1->addElements(array(	$firstName, 
										$lastName, 
										$phone,
										$email,
										$shAddr1, 
										$shAddr2,
										$shCity,
										$shState,
										$shZip));
		
// =================================================
// ============= Shipping2 : Shipping Type
// =================================================		
		$shType1 = new Zend_Form_Element_Checkbox("sh_type1");
		$shType1->setLabel("Express Mail 5-7 Business Days $4.95")
			->setAttrib("class", "co-shipping-type");
			
		$shType2 = new Zend_Form_Element_Checkbox("sh_type2");
		$shType2->setLabel("Priority Mail 3-4 Business Days $6.95");
			
		$shType3 = new Zend_Form_Element_Checkbox("sh_type3");
		$shType3->setLabel("First Class 1-2 Business Days $10.95");
			
		$shipping2->addElements(array($shType1, $shType2, $shType3));
		
// =================================================
// ============= Billing1 : Billing Address
// =================================================	
		$billSameAsShipping = new Zend_Form_Element_Checkbox("bill_as_ship");
		$billSameAsShipping->setLabel("Same as shipping");

		//address 1
		$billAddr1			= new Zend_Form_Element_Text("bill_addr1");
		$billAddr1->setLabel('Address 1')
			->setRequired(true)
			->setFilters($filters);
		
		//address 2
		$billAddr2			= new Zend_Form_Element_Text("bill_addr2");
		$billAddr2->setLabel('Address 2')
			->setFilters($filters);
		
		//city
		$billCity				= new Zend_Form_Element_Text("bill_city");
		$billCity->setLabel("City")
			->setRequired(true)
			->setFilters($filters);

		//state
		$billState			= new Zend_Form_Element_Select("bill_state");
		$billState->setLabel("State")
			->setRequired(true)
		//	->addFilter($filters)
			->setMultiOptions($this->_statesArr);
		
		//zip
		$billZip				= new Zend_Form_Element_Text("bill_zip");
		$billZip->setLabel("Zip Code")
			->setRequired(true)
			->addFilter("Digits");
			
		
		$billing1->addElements(array(	$billSameAsShipping,
										$billAddr1, 
										$billAddr2,
										$billCity,
										$billState,
										$billZip
		));
		
// =================================================
// ============= Billing2 : Card info
// =================================================		
		$nameOnCard		= new Zend_Form_Element_Text('name_on_card');
		$nameOnCard->setLabel('Name On Card')
			->setRequired(true)
			->addFilters($filters);
//			->addValidators($validators);
		
		$cartTypeSelect = new Zend_Form_Element_Select('card_type');
		$cartTypeSelect->setRequired(true)
			->setLabel("Card Type")
			->setMultiOptions(array('Visa', 'Mastercard','Discover'));
			
		//card number
		$cardNum		= new Zend_Form_Element_Text('card_num');
		$cardNum->setRequired(true)
		//	->addValidator($validatorCC)
			->addFilter($filterDigits)
			->setLabel('Card Number:');
			

		//exp_date 
		$expDate		= new Zend_Form_Element("exp_date");
		$expDate->setLabel("Expiration")
			->setRequired(true)
			//->addValidator()
			->addFilters(array($filterDigits));
		
		$ccv			= new Zend_Form_Element_Text("cvv");
		$ccv->setLabel("CCV")
			->setAttrib("class", "ccv")
			->setRequired(true)
			->addFilter("Digits")
			->addValidator('digits');
		
		$billing2->addElements(array(	$nameOnCard, 
										$cartTypeSelect, 
										$cardNum, 
										$ccv,	
										$expDate
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

