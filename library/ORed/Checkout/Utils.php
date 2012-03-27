<?php
class ORed_Checkout_Utils{
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//++++++++++++++++++++++ MODEL FACTORIES +++++++++++++++++++++++++++++++++
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	* Create Customer Model using form data from checkout
	* @param  $data 	- the first subform on the checkout
	* @return $c			- the first class citizen Customer object
	* */
	public function createUser($data){
		$c 			= new Application_Model_User();
		$pwd		= isset($data['password']) ? $data['password'] : Zend_Session::getId();
		
		$options	= array('fname'=>$data['cust_first_name'],
							'lname'=>$data['cust_last_name'],
							'email'=>$data['cust_email'],
							'password'=>$pwd,
							'phone'=>$data['cust_phone'],
							'ref_rid'=>2
			);
		$c->setOptions($options);
		return $c;
	}//end function
	
	/**
	* Create ShippingAddress Model using form data from checkout
	* @param  $data 	- the first subform on the checkout
	* @return $sh			- the first class citizen Customer object
	* */
	public function createShippingAddress($cid, $data){
		$sh			= new Application_Model_ShippingAddress();
		$options	= array('ref_cid'=>$cid,
							'address1'=>$data['addr1'],
							'address2'=>$data['addr2'],
							'city'=>$data['city'],
							'state'=>$data['state'],
							'zip'=>$data['zip'],
							'country'=>$data['country']
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
	
	public function createOrder($cid, $origin, $destination, $shType){
		$o	= new Application_Model_Order();
	}

}//end class