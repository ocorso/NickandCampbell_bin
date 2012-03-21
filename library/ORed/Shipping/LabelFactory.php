<?php
class ORed_Shipping_LabelFactory{
	
	public function createInstance(){
		
		$opts	= array();
		
		$s		= new Application_Model_ShippingInfo($opts);
		return $s;
	}
}