<?php

class Application_Model_ProductStyle
{
	protected $_sid;		//style id
	protected $_name;
	protected $_pretty;		//pretty url
	protected $_description1;
	protected $_description2;
	protected $_campaign;
	protected $_label; 		//black, regular
	protected $_category;
	protected $_gender;
	protected $_price;
	protected $_discount;

	// =================================================
	// ================ Workers
	// =================================================
	public function __set($name, $value){

		$method = 'set'.$name;

		if(('mapper' == $name)|| !method_exists($this, $method)){
			throw new Exeception('invalid product style property');
		}//end if

		$this->$method($value);

	}//end function

	public function __get($name){

		$method = 'get'.$name;

		if(('mapper' == $name)|| !method_exists($this, $method)){
			throw new Exeception('invalid product style property');
		}//end if
			
		return $this->$method();

	}//end function

	public function setOptions(array $options){
		$methods = get_class_methods($this);
		foreach($options as $key => $value){
			$method = 'set' . ucfirst($key);
			if (in_array($method, $methods)){
				$this->$method($value);
			}//endif
		}// endforeach

	}//end function

	// =================================================
	// ================ Getters / Setters
	// =================================================

	//href
	public function getHref(){
		return 'shop/'.$this->_gender.'/'.$this->_category.'/'.$this->_pretty;
	}

	//style id
	public function setSid($sid){
		$this->_sid				= (int) $sid;
		return $this;
	}
	public function getSid(){
		return $this->_sid;
	}

	//name
	public function setName($name){
		$this->_name = (string) $name;
		return $this;
	}
	public function getName(){
		return $this->_name;
	}

	//pretty name for url
	public function setPretty($prettyName){
		$this->_pretty		= (string) $prettyName;
		return $this;
	}
	public function getPretty(){
		return $this->_pretty;
	}

	//description1
	public function setDescription1($d){
		$this->_description1	= (string) $d;
		return $this;
	}
	public function getDescription1(){
		return $this->_description1;
	}

	//description2
	public function setDescription2($d){
		$this->_description2	= (string) $d;
		return $this;
	}
	public function getDescription2(){
		return $this->_description2;
	}

	//campaign
	public function setCampaign($c){
		$this->_campaign		= (string) $c;
		return $this;
	}
	public function getCampaign(){
		return $this->_campaign;
	}

	//label
	public function setLabel($label){
		$this->_label			= (string) $label;
		return $this;
	}
	public function getLabel(){
		return $this->_label;
	}
	//category
	public function setCategory($cat){
		$this->_category		= (string) $cat;
		return $this;
	}
	public function getCategory(){
		return $this->_category;
	}

	//gender
	public function setGender($gender){
		$this->_gender			= (string) $gender;
		return $this;
	}
	public function getGender(){
		return $this->_gender;
	}

	//price
	public function setPrice($price){
		$this->_price			= (float) $price;
		return $this;
	}
	public function getPrice(){
		return $this->_price;
	}
	
	public function getDiscount(){
		return $this->_discount;
	}
	public function setDiscount($d){
		$this->_discount = $d; return $this;
	}
	
}//end class

