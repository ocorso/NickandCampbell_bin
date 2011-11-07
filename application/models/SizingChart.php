<?php

class Application_Model_SizingChart
{
	protected $_size_id;
	protected $_name;
	protected $_description;

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
	//size_id
	public function setSizeid($id){
		$this->_size_id = (int) $id;
		return $this;
	}
	public function getSizeid(){ return $this->_size_id;	}
	
	//name
	public function setName($name){
		$this->_name = (string) $name;
		return $this;
	}
	public function getName(){ return $this->_name; }

	//description
	public function setDescription($d){
		$this->_description	= (string) $d;
		return $this;
	}
	public function getDescription(){ return $this->_description; }
// =================================================
// ================ Constructor
// =================================================
	
	public function __construct(array $options = null){
		
		if (is_array($options)){
			$this->setOptions($options);
		}//end if
	}//end constructor
}

