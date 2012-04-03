<?php

class Application_Model_PreOrderCart extends Application_Model_AbstractModel
{
	public function getClassName(){	return 'Application_Model_PreOrderCart';}
	
	protected $_id;
	protected $_sesh_id;
	protected $_type;
	protected $_promo;
	protected $_ref_pid;
	protected $_ref_uid;
	protected $_quantity;
	protected $_created_at;

	
	
	// =================================================
	// ================ Getters / Setters
	// =================================================
	public function getId(){ return $this->_id; }
	public function setId($id){ $this->_id = $id; return $this; }
	
	public function getSesh_id(){ return $this->_sesh_id;}
	public function setSesh_id($d){ $this->_sesh_id = $d; return $this;}
	
	public function getType(){ return $this->_type; }
	public function setType($d){ $this->_type = $d; return $this;}
	
	public function getPromo(){ return $this->_promo;}
	public function setPromo($d){ $this->_promo = $d; return $this;}
	
	public function getRef_pid(){ return $this->_ref_pid;}
	public function setRef_pid($d){ $this->_ref_pid = $d; return $this;}
	
	public function getRef_uid(){ return $this->_ref_uid;}
	public function setRef_uid($d){ $this->_ref_uid = $d; return $this;}
	
	public function getQuantity(){ return $this->_quantity;}
	public function setQuantity($d){ $this->_quantity = $d; return $this;}
	
	public function getCreated_at(){ return $this->_created_at;}
	public function setCreated_at($d){	$this->_created_at	= $d; return $this;}

}//end class

