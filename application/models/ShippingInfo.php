<?php

class Application_Model_ShippingInfo extends Application_Model_AbstractModel
{
	public function getClassName(){	return 'Application_Model_ShippingInfo';}
	
	protected $_shipping_id;
	protected $_shipping_price;
	protected $_label_id;
	protected $_carrier;
	protected $_origin;
	protected $_destination;
	protected $_total_weight;
	protected $_tracking_num;
	protected $_ship_date;
	
	// =================================================
	// ================ Getters / Setters
	// =================================================
	public function setShipping_id($d){ $this->_shipping_id = $d; return $this; }
	public function getShipping_id(){ return $this->_shipping_id; }
		
	public function setShipping_price($d){
		$this->_shipping_price = $d; return $this;
	}
	public function getShipping_price(){
		return $this->_shipping_price;
	}
	
	public function setLabel_id($d){ $this->_label_id = $d; return $this; }
	public function getLabel_id(){ return $this->_label_id; }
	
	public function setCarrier($d){ $this->_carrier = $d; return $this; }
	public function getCarrier(){ return $this->_carrier; }
	
	public function setOrigin($d){ $this->_origin = $d; return $this; }
	public function getOrigin(){ return $this->_origin; }
	
	public function setDestination($d){ $this->_destination = $d; return $this; }
	public function getDestination(){ return $this->_destination; }
	
	public function setTotal_weight($d){
		$this->_total_weight = $d; return $this;
	}
	public function getTotal_weight(){
		return $this->_total_weight;
	}
	
	public function setTracking_num($d){
		$this->_tracking_num = $d; return $this;
	}
	public function getTracking_num(){
		return $this->_tracking_num;
	}
	
	public function setShip_date($d){
		$this->_ship_date = $d; return $this;
	}
	public function getShip_date(){
		return $this->_ship_date;
	}
	
}

