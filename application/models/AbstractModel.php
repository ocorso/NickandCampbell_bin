<?php

class Application_Model_AbstractModel
{
	// =================================================
	// ================ Workers
	// =================================================
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
		$methods 	= get_class_methods($this);
		$a			= array();
		
		foreach($methods as $key => $value){
			print_r(str_word_count($value,0,"get"));
			if (str_s($value,0,"get") > 1){
				$prop 	= str_replace('get','', $value);
				echo strtolower($prop)."\n";
				
			}
			//$a[$prop]	= $this->$value();	
		}// endforeach
		//print_r($a);
	}
}

