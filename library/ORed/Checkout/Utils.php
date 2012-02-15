<?php
class ORed_Checkout_Utils{
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//++++++++++++++++++++++ MODEL FACTORIES +++++++++++++++++++++++++++++++++
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	* Create Customer Model using form data from checkout
	* @param  $shipping1 	- the first subform on the checkout
	* @return $c			- the first class citizen Customer object
	* */
	public function createCustomer($shipping1){
		$c 			= new Application_Model_Customer();
		$options	= array('fname'=>$shipping1['cust_first_name'],
							'lname'=>$shipping1['cust_last_name'],
							'email'=>$shipping1['cust_email'],
							'phone'=>$shipping1['cust_phone']
			);
		$c->setOptions($options);
		return $c;
	}//end function
	
	/**
	* Create ShippingAddress Model using form data from checkout
	* @param  $shipping1 	- the first subform on the checkout
	* @return $sh			- the first class citizen Customer object
	* */
	public function createShippingAddress($cid, $shipping1){
		$sh			= new Application_Model_ShippingAddress();
		$options	= array('ref_cid'=>$cid,
							'address1'=>$shipping1['addr1'],
							'address2'=>$shipping1['addr2'],
							'city'=>$shipping1['city'],
							'state'=>$shipping1['state'],
							'zip'=>$shipping1['zip'],
							'country'=>$shipping1['country']
			);
		$sh->setOptions($options);
		return $sh;
	}//end function
	/**
	* Create BillinggAddress Model using form data from checkout
	* @param  $billing1 	- the first subform on the checkout
	* @return $sh			- the first class citizen Customer object
	* */
	public function createBillingAddress($cid, $billing1){
		$b			= new Application_Model_BillingAddress();
		$options	= array('ref_cid'=>$cid,
							'address1'=>$billing1['addr1'],
							'address2'=>$billing1['addr2'],
							'city'=>$billing1['city'],
							'state'=>$billing1['state'],
							'zip'=>$billing1['zip'],
							'country'=>$billing1['country']
			);
		$b->setOptions($options);
		return $b;
	}//end function
	
	public function createOrder($cid, $shid, $bid, $shType){
		$o	= new Application_Model_Order();
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//++++++++++++++++++++++ SHIPPING CALCULATIONS +++++++++++++++++++++++++++
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function calcShipping(){
		return array (2=>4.95,4=>6.95,9=>10.95);
	}//end function 
}//end class