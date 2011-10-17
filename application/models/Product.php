<?php

class Application_Model_Product
{
	protected $_id;
	protected $_name;
	protected $_description;
	protected $_style_num;
	protected $_variation;
	protected $_size;
	protected $_color;
	protected $_category;
	protected $_gender;
	protected $_weight;
	protected $_price;
	
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
			
		return $this->$method($value);
	}//end function
	
	public function __construct(array $options = null){
		
		if (is_array($options)){
			$this->setOptions($options);
		}//end if
	}//end constructor
}//end class

	