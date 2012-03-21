<?php

class Application_Model_Order extends Application_Model_AbstractModel
{
	public function getClassName(){		return 'Application_Model_Order';}

	protected $_oid;
	protected $_anet_id;
	protected $_amount;
	protected $_total_tax;
	protected $_ref_uid;
	protected $_ref_bid;
	protected $_ref_shipping_id;
	protected $_description;
	protected $_created_at;
	protected $_status;
	
// =================================================
// ================ Getters / Setters
// =================================================
	
	public function setOid($d){ $this->_oid = $d; return $this;}
	public function getOid(){ return $this->_oid;}
	
	public function setAnet_id($d){ $this->_anet_id = $d; return $this; }
	public function getAnet_id(){ return $this->_anet_id; }
	
	public function setAmount($d){ $this->_amount = $d; return $this; }
	public function getAmount(){ $this->_amount; }
	
	public function setTotal_tax($d){ $this->_total_tax = $d; return $this; }
	public function getTotal_tax(){ return $this->_total_tax; }

	public function setRef_uid($d){ $this->_ref_uid = $d; return $this; }
	public function getRef_uid(){ return $this->_ref_uid; }
	
	public function setRef_bid($d){ $this->_ref_bid = $d; return $this; }
	public function getRef_bid(){ return $this->_ref_uid; }
	
	public function setRef_shipping_id($d){	$this->_ref_shipping_id = $d; return $this;}
	public function getRef_shipping_id(){ return $this->_ref_shipping_id; }
	
	public function setDescription($d){ $this->_description = $d; return $this; }
	public function getDescription(){ return $this; }
	
	public function setCreated_At($d){ $this->_created_at = $d; return $this; }
	public function getCreated_At(){ return $this->_created_at; }
	
	public function setStatus($d){ $this->_status = $d; return $this; }
	public function getStatus(){ return $this->_status; }

}

