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
			'ref_cid'	=> $shippingAddress->getRef_cid(),
			'address1'	=> $shippingAddress->getAddress1(),
			'address2'	=> $shippingAddress->getAddress2(),
			'city'		=> $shippingAddress->getCity(),
			'state'		=> $shippingAddress->getState(),
			'zip'		=> $shippingAddress->getZip(),
			'country'	=> $shippingAddress->getCountry(),
			'created_at'=> date('Y-m-d H:i:s')
		);
		
		if(null === ($shid = $shippingAddress->getShid())){
			echo "shipping address insert";
			$shid = $this->getDbTable()->insert($data);
		} else {
			echo "shipping address update";
			//$this->getDbTable()->update($data, array('shid = ?'=> $shid));
		}//endif
		
		return $shid;
	}//end function
	
	public function find($shid, Application_Model_ShippingAddress $shippingAddress){
		$result		= $this->getDbTable()->find($shid);
		if(0 == count($result)){
			return;
		}
		$row = $result->current();
		$shippingAddress->setOptions($row->toArray());
		
	}
	
	public function fetchAll(){
		$resultSet 	= $this->getDbTable()->fetchAll();
		$entries	= array();
		foreach($resultSet as $row){
			$entry	= new Application_Model_ShippingAddress();
			$shippingAddress->setOptions($row->toArray());
			$entries[]	= $entry;
		}
		return $entries;
	}
}

