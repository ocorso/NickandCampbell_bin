<?php

class Application_Model_Customer
{
	protected $_cid; //customer id
	protected $_fname;	// first name
	protected $_lname;	//last name
	protected $_email;
	protected $_phone;
	protected $_shid;	//shipping id
	protected $_bid; 	//billing id
	protected $_create_at;

	   
// =================================================
// ================ Workers
// =================================================
	public function __set($name, $value){
		
		$method = 'set'.$name;
		
		if(('mapper' == $name)|| !method_exists($this, $method)){
			throw new Exeception('invalid customer property');
		}//end if

		$this->$method($value);
		
	}//end function
	
	public function __get($name){

		$method = 'get'.$name;
		
		if(('mapper' == $name)|| !method_exists($this, $method)){
			throw new Exeception('invalid customer property');
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
	public function setCid($cid){
		$this->_cid 	= (int) $cid;
		return $this;
		
	}	
	public function getCid(){return $this->_cid; }
	
	public function setFname($fname){
		$this->_fname	= (string) $fname;
		return $this;
	}
	public function setLname($lname){
		$this->_lname	= (string) $lname;
		return $this;
	}
	public function getLname(){ return $this->_lname; }

	public function setEmail($email){
		$this->_email	= (string) $email;
		return $this;
	}
	public function getEmail(){ return $this->_email; }

	public function setPhone($phone){
		$this->_phone	= (float) $phone;
		return $this;
	}
	public function getPhone(){ return $this->_phone; }

	public function setShid($shid){
		$this->_shid	= (int) $shid;
		return $this;
	}
	public function getShid(){$this->_shid; }

	public function setBid($bid){
		$this->_bid		= (int) $bid;
		return $this;
	}
	public function getBid(){ $this->_bid; }
	
	//created at
	public function setCreated_at($d){
		$this->_created_at	= $d;
		return $this;
	}
	public function getCreated_at(){ return $this->_created_at; }
	
}//end class

