<?php

class Application_Model_PreOrderCart
{
	protected $_id;
	protected $_sesh_id;
	protected $_type;
	protected $_promo;
	protected $_ref_pid;
	protected $_ref_uid;
	protected $_quantity;
	protected $_created_at;

	// =================================================
	// ================ Workers
	// =================================================
	public function __set($name, $value){
	
		$method = 'set'.$name;
	
		if(('mapper' == $name)|| !method_exists($this, $method)){
			throw new Exception($name.' is an invalid preorder_cart property');
		}//end if
	
		$this->$method($value);
	
	}//end function
	
	public function __get($name){
	
		$method = 'get'.$name;
	
		if(('mapper' == $name)|| !method_exists($this, $method)){
			throw new Exception($name.' is an invalid preorder_cart property');
		}//end if
			
		return $this->$method();
	
	}//end function
	
	public function setOptions(array $options){
		
		$methods = get_class_methods($this);
		
		foreach($options as $key => $value){
			$method = 'set' . ucfirst($key);
			if (in_array($method, $methods))	$this->$method($value);
		}// endforeach
	
	}//end function
	
	public function toArray(){
		$a = array( 'id'		=> $this->_id,
					'sesh_id'	=> $this->_sesh_id,
			 		'type'		=> $this->_type,
					'promo'		=> $this->_promo,
					'ref_pid'	=> $this->_ref_pid,
					'ref_uid'	=> $this->_ref_uid,
				    'quantity'	=> $this->_quantity,
				    'created_at'=> $this->_created_at
				   );
		return $a;
	}
	
	// =================================================
	// ================ Getters / Setters
	// =================================================
	public function getId(){ return $this->_id; }
	public function setId($id){ $this->_id = $id; return $this; }
	
	public function getSesh_id(){ return $this->_sesh_id;}
	public function setSesh_id($d){ $this->_sesh_id = $d; return $this;}
	
	public function getType(){ return $this->_type; }
	public function setType($d){ $this->_type = $d; return $this;}
	
	public function getPromo(){ return $this->_promo;}
	public function setPromo($d){ $this->_promo = $d; return $this;}
	
	public function getRef_pid(){ return $this->_ref_pid;}
	public function setRef_pid($d){ $this->_ref_pid = $d; return $this;}
	
	public function getRef_uid(){ return $this->_ref_uid;}
	public function setRef_uid($d){ $this->_ref_uid = $d; return $this;}
	
	public function getQuantity(){ return $this->_quantity;}
	public function setQuantity($d){ $this->_quantity = $d; return $this;}
	
	public function getCreated_at(){ return $this->_created_at;}
	public function setCreated_at($d){	$this->_created_at	= $d; return $this;}
	
	// =================================================
	// ================ Constructor
	// =================================================
	
	public function __construct(array $options = null){
	
		if (is_array($options)){
			$this->setOptions($options);
		}//end if
	}//end constructor
	
}//end class

