<?php

class Application_Model_ShippingInfo extends Application_Model_AbstractModel
{
	public function getClassName(){	return 'Application_Model_ShippingInfo';}
	
	protected $_shipping_id;
	protected $_shipping_price_paid;
	protected $_shipping_cost;
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
		
	public function setShipping_price_paid($d){ $this->_shipping_price_paid = $d; return $this;}
	public function getShipping_price_paid(){ return $this->_shipping_price_paid;}

	public function setShipping_cost($d){ $this->_shipping_cost = $d; return $this;}
	public function getShipping_cost(){ return $this->_shipping_cost;}
	
	public function setLabel_id($d){ $this->_label_id = $d; return $this; }
	public function getLabel_id(){ return $this->_label_id; }
	
	public function setCarrier($d){ $this->_carrier = $d; return $this; }
	public function getCarrier(){ return $this->_carrier; }
	
	public function setOrigin($d){ $this->_origin = $d; return $this; }
	public function getOrigin(){ return $this->_origin; }
	
	public function setDestination($d){ $this->_destination = $d; return $this; }
	public function getDestination(){ return $this->_destination; }
	
	public function setTotal_weight($d){ $this->_total_weight = $d; return $this; }
	public function getTotal_weight(){ return $this->_total_weight; }
	
	public function setTracking_num($d){ $this->_tracking_num = $d; return $this; }
	public function getTracking_num(){ return $this->_tracking_num;}
	
	public function setShip_date($d){ $this->_ship_date = $d; return $this;}
	public function getShip_date(){ return $this->_ship_date;}
	
}//end class

