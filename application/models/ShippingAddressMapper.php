<?php

class Application_Model_ShippingAddressMapper
{
	protected $_dbTable;
	
	public function setDbTable($dbTable){
		if (is_string($dbTable)){
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract){
			throw new Exception('Invalid table data gateway provided for shipping address');
		}
		$this->_dbTable = $dbTable;
		return $this;
	}
	
	public function getDbTable(){ 
		if (null === $this->_dbTable){
			$this->setDbTable('Application_Model_DbTable_ShippingAddresses');
		}
		return $this->_dbTable;
	}
	
	public function save(Application_Model_ShippingAddress $shippingAddress){
		
		$data 	= array(
			'ref_cid'	=> $shippingAddress->getRefcid(),
			'address1'	=> $shippingAddress->getAddress1(),
			'address2'	=> $shippingAddress->getAddress2(),
			'city'		=> $shippingAddress->getCity(),
			'state'		=> $shippingAddress->getState(),
			'zip'		=> $shippingAddress->getZip(),
			'country'	=> $shippingAddress->getCountry()
			
		);
	}
}

