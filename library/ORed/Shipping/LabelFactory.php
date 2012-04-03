<?php
class ORed_Shipping_LabelFactory{
	
	protected $_regular		= 4.95;
	protected $_oneDay		= 14.95;
	protected $_twoDay		= 14.95;
	
	public function getShippingOpts(){
		
		
		//oc: todo: create a good array of options
	//	$pricesById = $this->calcShipping();
		return array(
			"regular"=>"Regular 5-7 Business Days $$this->_regular",
			"two-day"=>"Express 3-4 Business Days $$this->_twoDay",
			"one-day"=>"Overnight 1-2 Business Days $$this->_oneDay"
		);
	}
	public function getRegular(){ return $this->_regular; }
	
	public function createLabel($origin_id, $destination_id, $shType){
		$shTypeArr 		= $this->calcShipping();
		$shPricePaid	= $shTypeArr[$shType];
		$cartMapper		= new Application_Model_CartMapper();
		
		$opts	= array(
											'origin'		=>$origin_id,
											'destination'	=>$destination_id,
											'shipping_price_paid'=>$shPricePaid,
											'total_weight'	=>$cartMapper->fetchCartWeight(Application_Model_SiteModel::$CART_TYPE_REAL)
		);
		$s		= new Application_Model_ShippingInfo($opts);
		$db 	= new Application_Model_DbTable_ShippingInfo();
		$s->setShipping_id($db->insert($s->toArray()));
		
		return $s->getShipping_id();
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//++++++++++++++++++++++ SHIPPING CALCULATIONS +++++++++++++++++++++++++++
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function calcShipping(){
		return array (	$this->_regular,
						$this->_twoDay,
						$this->_oneDay
		);
	}//end function
	
}