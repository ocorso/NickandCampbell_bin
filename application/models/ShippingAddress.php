<?php

class Application_Model_ShippingAddress extends Application_Model_AbstractModel
{
	public function getClassName(){ return 'Application_Model_ShippingAddress'; }
	
	protected $_shid;		//shipping id
	protected $_ref_cid;	//customer id
	protected $_address1;
	protected $_address2;
	protected $_city;
	protected $_state;
	protected $_zip;
	protected $_country;
	protected $_created_at;

	    
// =================================================
// ================ Getters / Setters
// =================================================

	//shid
	public function setShid($shid){
		$this->_shid 	= (int) $shid;
		return $this;
	}
	
	public function getShid(){ return $this->_shid; }

	//ref cid
	public function setRef_cid($cid){
		$this->_ref_cid	= (int) $cid;
		return $this;
	}
	public function getRef_cid(){ return $this->_ref_cid;}
	
	//address1
	public function setAddress1($addr1){
		$this->_address1	= (string) $addr1;
		return $this;
	
	}
	public function getAddress1(){ return $this->_address1;}
	
	//address2
	public function setAddress2($addr2){
		$this->_address2	= (string) $addr2;
		return $this;
	
	}
	public function getAddress2(){ return $this->_address2;}
	
	//city
	public function setCity($c){
		$this->_city	= (string) $c;
		return $this;
	
	}
	public function getCity(){ return $this->_city;}
	
	//state 
	public function setState($s){
		$this->_state	= (string) $s;
		return $this;
	}
	public function getState(){ return $this->_state; }
	
	//country
	public function setCountry($c){
		$this->_country	= (string) $c;
		return $this;
	
	}
	public function getCountry(){ return $this->_country;}

	//zip
	public function setZip($z){
		$this->_zip		= (int) $z;
		return $this;
	}
	public function getZip(){ return $this->_zip; }

	//created at
	public function setCreated_at($d){
		$this->_created_at	= $d;
		return $this;
	}
	public function getCreated_at(){ return $this->_created_at; }


}

