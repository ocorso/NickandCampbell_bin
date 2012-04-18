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
		$uModel		= new Application_Model_UserMapper();
		$pwd		= isset($data['password']) ? $data['password'] : Zend_Session::getId();
		
		$options	= array('fname'=>$data['cust_first_name'],
							'lname'=>$data['cust_last_name'],
							'email'=>$data['cust_email'],
							'password'=>$pwd,
							'phone'=>$data['cust_phone'],
							'ref_rid'=>2
			);
		$u 			= new Application_Model_User($options);
		$uid		= $uModel->save($u);
		return $uid;
	}//end function
	
	/**
	* Create ShippingAddress Model using form data from checkout
	* @param  $data 	- the first subform on the checkout
	* @return $sh			- the first class citizen Customer object
	* */
	public function createShippingAddress($uid, $data){
		$shModel	= new Application_Model_ShippingAddressMapper();
		$options	= array('ref_uid'=>$uid,
							'address1'=>$data['addr1'],
							'address2'=>$data['addr2'],
							'city'=>$data['city'],
							'state'=>$data['state'],
							'zip'=>$data['zip'],
							'country'=>$data['country']
			);
		$sh			= new Application_Model_ShippingAddress($options);
		$dest_id	= $shModel->save($sh);
		return $dest_id;
	}//end function
	/**
	* Create BillinggAddress Model using form data from checkout
	* @param  $billing1 	- the first subform on the checkout
	* @return $sh			- the first class citizen Customer object
	* */
	public function createBillingAddress($uid, $billing1){
		$bModel		= new Application_Model_BillingAddressMapper();
		$options	= array('ref_uid'=>$uid,
							'address1'=>$billing1['addr1'],
							'address2'=>$billing1['addr2'],
							'city'=>$billing1['city'],
							'state'=>$billing1['state'],
							'zip'=>$billing1['zip'],
							'country'=>$billing1['country']
			);
		$b			= new Application_Model_BillingAddress($options);
		$bid		= $bModel->save($b);
		return $bid;
	}//end function
	
	public function createOrder($uid, $bid, Application_Model_ShippingInfo $shippingInfo ){
		
		$cartM	= new Application_Model_CartMapper();
		$tbl	= new Application_Model_DbTable_Order();
		
		$status	= Application_Model_SiteModel::$ORDER_STATUS[1];//order received
		$shCost	= $shippingInfo->getShipping_price_paid();
		$cart	= ORed_ShoppingCart_Utils::getCart();
		$tax	= $shippingInfo->getTaxable() ? $cart->subTotal*Application_Model_SiteModel::$NEW_YORK_CITY_TAX : 0;
		$amount	= $cart->subTotal + $tax + $shCost;
		
		$opts = array(
						'amount'			=>$amount,
						'total_tax'			=>$tax,
						'ref_uid'			=>$uid,
						'ref_bid'			=>$bid,
						'ref_shipping_id'	=>$shippingInfo->getShipping_id(),
						'details'			=>"NA",
						'status'			=>$status
			);
		$o		= new Application_Model_Order($opts);
		$oid 	= $tbl->insert($o->toArray());
		$o->setOid($oid);
//print_r($o->toArray());
		return $o;
	}

}//end class