<?php
class ORed_Checkout_Utils{
	
	public function createCustomer($shipping1){
		$c 			= new Application_Model_Customer();
		$options	= array('fname'=>$shipping1['cust_first_name'],
							'lname'=>$shipping1['cust_last_name'],
							'email'=>$shipping1['cust_email'],
							'phone'=>$shipping1['cust_phone']
			);
		$c->setOptions($options);
		return $c;
	}
}