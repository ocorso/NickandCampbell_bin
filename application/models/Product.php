<?php

class Application_Model_Product
{
	protected $_pid; 		//product id
	protected $_size;		//
	protected $_color;
	protected $_sku;
	protected $_weight;
	
	
        
// =================================================
// ================ Callable
// =================================================
        
// =================================================
// ================ Workers
// =================================================
	public function __set($name, $value){
		
		$method = 'set'.$name;
		
		if(('mapper' == $name)|| !method_exists($this, $method)){
			throw new Exeception('invalid product property');
		}//end if

		$this->$method($value);
		
	}//end function
	
	public function __get($name){

		$method = 'get'.$name;
		
		if(('mapper' == $name)|| !method_exists($this, $method)){
			throw new Exeception('invalid product property');
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
	//product id
	public function setPid($id){
		$this->_pid = (int) $id;
		return $this;
	}
	public function getPid(){
		return $this->_pid;
	}
	
	//size
	public function setSize($s){
		$this->_size			= (int) $s;
		return $this;
	}
	public function getSize(){ return $this->_size; }
	
	//color
	public function setColor($color){
		$this->_color			= (string) $color;
		return $this;
	}
	public function getColor(){ return $this->_color; }
	

	//price
	public function setPrice($price){
		$this->_price			= (float) $price;
		return $this;
	}
	public function getPrice(){ return $this->_price; }
	
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
	
// =================================================
// ================ Constructor
// =================================================
	
	public function __construct(array $options = null){
		
		if (is_array($options)){
			$this->setOptions($options);
		}//end if
	}//end constructor
}//end class

	