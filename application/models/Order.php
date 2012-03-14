<?php

class Application_Model_Order
{
	protected $_oid;
	protected $_anet_id;
	protected $_total_price;
	protected $_total_weight;
	protected $_total_tax;
	protected $_ref_cart_id;
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
					'ref_cart_id'		=> $this->_ref_cart_id,
					'ref_uid'			=> $this->_ref_uid,
				    'ref_shid'			=> $this->_ref_shid,
				    'ref_shipping_type'	=> $this->_ref_shipping_type,
				    'shipping_date'		=> $this->_shipping_date,
				    'shipping_price'	=> $this->_shipping_price,
				    'tracking_num'		=> $this->_tracking_num,
				    'created_at'		=> $this->_created_at,
				    'status'			=> $this->_status
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
	
	public function setCart_id($d){ $this->_ref_cart_id = $d; return $this; }
	public function getCart_id(){ return $this->_ref_cart_id; }
	
	public function setRef_uid($d){ $this->_ref_uid = $d; return $this; }
	public function getRef_uid(){ return $this->_ref_uid; }
	
	public function setRef_bid($d){ $this->_ref_bid = $d; return $this; }
	public function getRef_bid(){ return $this->_ref_uid; }
	
	public function setRef_shid($d){ $this->_ref_shid = $d; return $this; }
	public function getRef_shid(){ return $this; }

	public function setRef_shipping_type($d){ $this->_ref_shipping_type = $d; return $this; }
	public function getRef_shipping_type(){ return $this->_ref_shipping_type; }
	
	public function setShipping_date($d){ $this->_shipping_date = $d; return $this; }
	public function getShipping_date(){ return $this->_shipping_date; }

	public function setShipping_price($d){ $this->_shipping_price = $d; return $this; }
	public function getShipping_price(){ return $this->_shipping_price; }
	
	public function setTracking_num($d){ $this->_tracking_num = $d; return $this; }
	public function getTracking_num(){ return $this->_tracking_num; }
	
	public function setCreated_At($d){ $this->_created_at = $d; return $this; }
	public function getCreated_At(){ return $this->_created_at; }
	
	public function setStatus($d){ $this->_status = $d; return $this; }
	public function getStatus(){ return $this->_status; }

}

