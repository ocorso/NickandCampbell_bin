<?php

class Application_Model_Product extends Application_Model_AbstractModel
{
	public function getClassName(){
		return 'Application_Model_Product';
	}
	protected $_pid; 		//product id
	protected $_ref_sid;
	protected $_ref_size;		//
	protected $_color;
	protected $_sku;
	protected $_weight;
	
// =================================================
// ================ Getters / Setters
// =================================================
	//product id
	public function setPid($id){
		$this->_pid = (int) $id;
		return $this;
	}
	public function getPid(){
		return $this->_pid;
	}
	
	//style id reference
	public function setRef_sid($id){
		$this->_ref_sid = (int) $id;
		return $this;
	}
	public function getRef_sid(){
		return $this->_ref_sid;
	}
	
	//size
	public function setRef_size($s){
		$this->_ref_size			= (int) $s;
		return $this;
	}
	public function getRef_size(){ return $this->_ref_size; }
	
	//color
	public function setColor($color){
		$this->_color			= (string) $color;
		return $this;
	}
	public function getColor(){ return $this->_color; }
	
	//stock keeping unit
	public function setSku($q){
		$this->_sku		= (int) $q;
		return $this;
	}
	public function getSku(){ return $this->_sku; }

	
	//weight
	public function setWeight($weight){
	$this->_weight			= (float) $weight;
	return $this;
	}
	public function getWeight(){
	return $this->_weight;
	}
	

}//end class

	