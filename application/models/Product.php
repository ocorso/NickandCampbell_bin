<?php

class Application_Model_Product
{
	protected $_id;
	protected $_name;
	protected $_description;
	protected $_style_num;
	protected $_variation;
	protected $_label; 	//black, regular
	protected $_size;	//
	protected $_color;
	protected $_category;
	protected $_subcategory;
	protected $_gender;
	protected $_weight;
	protected $_price;
	
	
        
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
	public function setId($id){
		$this->_id = (int) $id;
		return $this;
	}
	public function getId(){ return $this->_id;	}
	
	public function setName($name){
		$this->_name = (string) $name;
		return $this;
	}
	public function getName(){ return $this->_name; }
	
// =================================================
// ================ Constructor
// =================================================
	
	public function __construct(array $options = null){
		
		if (is_array($options)){
			$this->setOptions($options);
		}//end if
	}//end constructor
}//end class

	