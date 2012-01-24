<?php 

class Application_Form_Checkout extends Zend_Form
{
	protected $_cart; //this is the session var that we'll hopefully populate in init
	protected $_statesArr = array('AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado','CT'=>'Connecticut','DE'=>'Delaware','DC'=>'District Of Columbia','FL'=>'Florida','GA'=>'Georgia','HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois', 'IN'=>'Indiana', 'IA'=>'Iowa',  'KS'=>'Kansas','KY'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland', 'MA'=>'Massachusetts','MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana','NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico','NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma', 'OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island','SC'=>'South Carolina','SD'=>'South Dakota','TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington','WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming');
	protected function _formatCartContents($cart)
	{
	
		//calc cost of all items in the cart
		$subTotal 	= 0;
		foreach ($cart->items as $item){
			$subTotal += (int) $item['quantity']* (float)$item['price'];
		}
		 
		//3. return json so JS can populate shopping cart
		$cartObj 			= new stdClass();
		$cartObj->subTotal 	= number_format($subTotal, 2);
		$cartObj->items		= $cart->items;
		return $cartObj;
	}
	

    public function init()
    {
    	
    	//debug
    	$debugRadioBtn = new Zend_Form_Element_Checkbox("debug");
    	$debugRadioBtn->setLabel("Fill out shit")
    	->setAttrib("class", "debug-radio");
    	$this->addElement($debugRadioBtn);
    	//get cart
    	$this->_cart = new Zend_Session_Namespace('cart');
    	
    	//print_r( $this->_formatCartContents($this->_cart));
    	$cart = $this->_formatCartContents($this->_cart);
    	
    	$this->setAction("/checkout/transaction-results")
			->setMethod("post")
			->setAttrib('id', 'checkout_form');
		
    	//oc: add data from session obj
    	$this->addHid('subtotal', $cart->subTotal);
		
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
		$shType2->setLabel("Priority Mail 3-4 Business Days $6.95")
			->setAttrib("class", "co-shipping-type");
			
		$shType3 = new Zend_Form_Element_Checkbox("sh_type3");
		$shType3->setLabel("First Class 1-2 Business Days $10.95")
			->setAttrib("class", "co-shipping-type");
			
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
		//omg we have a valid form and it looks like this:
		// 		[debug] => 1
		// 		[subtotal] => 19.95
		// 		[shipping1] => Array
		// 		(
		// 		[cust_first_name] => owen
		// 		[cust_last_name] => corso
		// 		[cust_phone] => 2016020069
		// 		[cust_email] => owen@ored.net
		// 		[sh_addr1] => 281 stewart lane
		// 		[sh_addr2] =>
		// 		[sh_city] => franklin lakes
		// 		[sh_state] => NJ
		// 		[sh_zip] => 07417
		// 		)
		
		// 		[shipping2] => Array
		// 		(
		// 		[sh_type1] => 0
		// 		[sh_type2] => 0
		// 		[sh_type3] => 0
		// 		)
		
		// 		[billing1] => Array
		// 		(
		// 		[bill_as_ship] => 0
		// 		[bill_addr1] => 281 stewart lane
		// 		[bill_addr2] =>
		// 		[bill_city] => franklin lakes
		// 		[bill_state] => NJ
		// 		[bill_zip] => 07417
		// 		)
		
		// 		[billing2] => Array
		// 		(
		// 		[name_on_card] => owen m corso
		// 		[card_type] => 1
		// 		[card_num] => 1234123412341234
		// 		[ccv] => 123
		// 		[exp_date] => 052012
		// 		)


		//exp_date 
		//todo: make decorators explaning some of this stuff.
		$expDate		= new Zend_Form_Element("exp_date");
		$expDate->setLabel("Expiration")
			->setRequired(true)
			//->addValidator()
			->addFilters(array($filterDigits));
		
		$ccv			= new Zend_Form_Element_Text("ccv");
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
		
		
// =================================================
// ============= Confirm : Submit
// =================================================		
		//amount
// 		$confirm->addElement('text','amount',array(
// 			'label'		=> 	'Amount:',
// 			'required'	=>	true,
// 			'validators'=> 	array(
// 						array('validator'=>'StringLength', 'options'=>array(0,20))
// 						)
// 		));	

		
		//submit button
		
		//todo: make new decorator for submit button.
		$submitBtn	= new Zend_Form_Element_Submit("submit");
		$submitBtn->setLabel('Confirm Purchase')
			->setAttrib("class", "vip")
			->removeDecorator('DtDdWrapper')
			->setIgnore(true);
		
		$confirm->addElement($submitBtn);
	
		
// =================================================
// ============= Add Subforms to form
// =================================================		
		$subForms 		= array(	'shipping1'=> $shipping1,
									'shipping2'=> $shipping2,
									'billing1'=> $billing1,
									'billing2'=> $billing2,
									'confirm'=>	$confirm);
		
		$this->addSubForms($subForms);
		
	}//end init

	/**
	* Add Hidden Element
	* @param $field
	* @param value
	* @return nothing - adds hidden element
	* */
	public function addHid($field, $value){
		$hiddenIdField = new Zend_Form_Element_Hidden($field);
		$hiddenIdField->setValue($value)
		->removeDecorator('label')
		->removeDecorator('HtmlTag');
		$this->addElement($hiddenIdField);
	}
	
}//end class

