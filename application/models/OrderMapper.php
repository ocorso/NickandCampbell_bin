<?php

class Application_Model_OrderMapper{
	
	protected $_orderTbl;
	protected $_shMapper;
	protected $_cMapper;
	protected $_shAddyMapper;
	protected $_billingAddyMapper;
	
	public function __construct(){
		
		$this->_orderTbl 			= new Application_Model_DbTable_Order();
		$this->_shMapper			= new Application_Model_ShippingInfoMapper();
		$this->_cMapper				= new Application_Model_CartMapper();
		$this->_shAddyMapper		= new Application_Model_ShippingAddressMapper();
		$this->_billingAddyMapper	= new Application_Model_BillingAddressMapper();
		
	}
	
	public function getOrderInfoById($oid){
		
		$oInfo	= new stdClass();//oc: TODO create model to hold strongly typed vars
		
		//value objects instantiate
		$oInfo->order 		= new Application_Model_Order();
		$oInfo->shipping 	= new Application_Model_ShippingInfo();
		$oInfo->origin		= new Application_Model_ShippingAddress();
		$oInfo->destination	= new Application_Model_ShippingAddress();
		$oInfo->cart		= array();
		//value objects populate
		$this->findOrder($oid, $oInfo->order);
		$this->_shMapper->find($oInfo->order->getRef_shipping_id(), $oInfo->shipping);
		$this->_shAddyMapper->find($oInfo->shipping->getOrigin(), $oInfo->origin);
		$this->_shAddyMapper->find($oInfo->shipping->getDestination(), $oInfo->destination);
		$oInfo->cart		= $this->_cMapper->fetchCartForOrderInfo($oid);
		
		return $oInfo;
	}
	public function findOrder($oid, Application_Model_Order $o ){
		$result = $this->_orderTbl->find($oid);
		if (0 == count($result)){
			return;
		}
		
		$row = $result->current();
		$o->setOptions($row->toArray());
	}//end function
	public function fetchAll(){
		$oids	= $this->_orderTbl->fetchAll();
		$orders	= array();
		foreach ($oids as $o){
			$orders[] = $this->getOrderInfoById($o['oid']);
		}
		return $orders;
	}
}