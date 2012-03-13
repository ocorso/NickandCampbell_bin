<?php

class Application_Model_Order
{
	protected $_oid;
	protected $_anet_id;
	protected $_total_price;
	protected $_total_weight;
	protected $_total_tax;
	protected $_ref_uid;
	protected $_ref_bid;
	protected $_ref_shid;
	protected $_ref_shipping_type;
	protected $_shipping_date;
	protected $_shipping_price;
	protected $_tracking_num;
	protected $_created_at;
	protected $_status;

// =================================================
// ================ Workers
// =================================================
	public function __set($name, $value){
		
		$method = 'set'.$name;
		
		if(('mapper' == $name)|| !method_exists($this, $method)){
			throw new Exception('invalid setter on Order property');
		}//end if

		$this->$method($value);
		
	}//end function
	
	public function __get($name){

		$method = 'get'.$name;
		
		if(('mapper' == $name)|| !method_exists($this, $method)){
			throw new Exception('invalid getter on Order property');
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
		$a = array( 'oid'				=> $this->_oid,
					'anet_id'			=> $this->_anet_id,
			 		'total_price'		=> $this->_total_price,
					'total_weight'		=> $this->_total_weight,
					'total_tax'			=> $this->_ref_pid,
					'ref_uid'			=> $this->_ref_uid,
				    'ref_shid'			=> $this->_ref_shid,
				    'created_at'		=> $this->_created_at
				   );
		return $a;
	}
// =================================================
// ================ Getters / Setters
// =================================================
	
	public function setOid($d){ $this->_oid = $d; return $this;}
	public function getOid(){ return $this->_oid;}
	
	public function setAnet_id($d){ $this->_anet_id = $d; return $this; }
	public function getAnet_id(){ return $this->_anet_id; }
	
	public function setTotal_price($d){ $this->_total_price = $d; return $this; }
	public function getTotal_price(){ $this->_total_price; }
	
	public function setTotal_weight($d){ $this->_total_weight = $d; return $this; }
	public function getTotal_weight(){ return $this->_total_weight; }
	
	public function setTotal_tax($d){ $this->_total_tax = $d; return $this; }
	public function getTotal_tax(){ return $this->_total_tax; }
}

