<?php

class Application_Model_PostOrderCart extends Application_Model_AbstractModel
{
	public function getClassName(){ return 'Application_Model_PostOrderCart';}
	
	protected $_cart_id;
	protected $_ref_oid;
	protected $_ref_pid;
	protected $_ref_uid;
	protected $_price_paid;
	protected $_tax;
	protected $_promo;
	protected $_discount;
	protected $_quantity;
	protected $_created_at;

	// =================================================
	// ================ Getters / Setters
	// =================================================
	public function setCart_id($id){ $this->_cart_id = $id; return $this; }
	public function getCart_id(){ return $this->_cart_id; }
	
	public function getRef_oid(){ return $this->_ref_oid;}
	public function setRef_oid($d){ $this->_ref_oid = $d; return $this;}
	
	public function getRef_pid(){ return $this->_ref_pid;}
	public function setRef_pid($d){ $this->_ref_pid = $d; return $this;}

	public function getRef_uid(){ return $this->_ref_uid;}
	public function setRef_uid($d){ $this->_ref_uid = $d; return $this;}

	public function getPrice_paid(){ return $this->_price_paid; }
	public function setPrice_paid($d){ $this->_price_paid = $d; return $this;}
	
	public function setTax($d){ $this->_tax = $d; return $this; }
	public function getTax(){ return $this->_tax;}
	
	public function getPromo(){ return $this->_promo;}
	public function setPromo($d){ $this->_promo = $d; return $this;}
	
	public function setDiscount($d){ $this->_discount = $d; return $this; }
	public function getDiscount(){ return $this->_discount;}

	public function getQuantity(){ return $this->_quantity;}
	public function setQuantity($d){ $this->_quantity = $d; return $this;}
	
	public function getCreated_at(){ return $this->_created_at;}
	public function setCreated_at($d){	$this->_created_at	= $d; return $this;}

}//end class

