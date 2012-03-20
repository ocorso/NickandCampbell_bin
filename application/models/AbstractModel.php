<?php

class Application_Model_AbstractModel
{
	// =================================================
	// ================ Workers
	// =================================================
	public function getClassName(){ return 'Application_Model_AbstractModel'; }//override this
	public function __set($name, $value){
	
		$method = 'set'.$name;
	
		if(('mapper' == $name)|| !method_exists($this, $method)){
			throw new Exception('invalid setter on property');
		}//end if
	
		$this->$method($value);
	
	}//end function
	
	public function __get($name){
	
		$method = 'get'.$name;
	
		if(('mapper' == $name)|| !method_exists($this, $method)){
			throw new Exception('invalid getter on property');
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
	
	public function toArray(){
		$properties 	= get_class_vars($this->getClassName());
		$a				= array();
		foreach($properties as $key=>$value){
			$prop 		= trim($key,"_");
			$method		= "get".ucfirst($prop);
			$a[$prop]	= $this->$method();
		}// endforeach

		return $a;
	}//end function 
	

	// =================================================
	// ================ Constructor
	// =================================================
	
	public function __construct(array $options = null){
	
		if (is_array($options)){
			$this->setOptions($options);
		}//end if
	}//end constructor
	
}

