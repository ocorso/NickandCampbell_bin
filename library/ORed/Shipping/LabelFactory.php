<?php
class ORed_Shipping_LabelFactory{
	
	public function create($opts){
		
		
		$s		= new Application_Model_ShippingInfo($opts);
		return $s;
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//++++++++++++++++++++++ SHIPPING CALCULATIONS +++++++++++++++++++++++++++
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function calcShipping(){
		return array (2=>4.95,4=>6.95,9=>10.95);
	}//end function
	
	public function getShippingOpts(){
	
		//oc: todo: create a good array of options
	//	$pricesById = $this->calcShipping();
		return array(
			2=>"Express Mail 5-7 Business Days $4.95",
			4=>"Priority Mail 3-4 Business Days $6.95",
			9=>"First Class 1-2 Business Days $10.95"
		);
	}
}