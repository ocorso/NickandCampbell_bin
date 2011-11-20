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
			'country'	=> $shippingAddress->getCountry(),
			'created_at'=> date('Y-m-d H:i:s')
		);
		
		if(null === ($shid = $shippingAddress->getShid())){
			unset($data('shid'));
			$this->getDbTable()->insert($data);
		} else {
			$this->getDbTable()->update($data, array('shid = ?'=> $shid));
		}//endif
	}//end function
	
	public function find($shid, Application_Model_ShippingAddress $shippingAddress){
		$result		= $this->getDbTable()->find($shid);
		if(0 == count($result)){
			return;
		}
		$row = $result->current();
		$shippingAddress->setShid($row->shid)
			->setRefcid($row->ref_cid)
			->setAddress1($row->address1)
			->setAddress2($row->address2)
			->setCity($row->city)
			->setState($row->state)
			->setZip($row->zip)
			->setCountry($row->country)
			->setCreated_at($row->created_at);
		
	}
	
	public function fetchAll(){
		$resultSet 	= $this->getDbTable()->fetchAll();
		$entries	= array();
		foreach($resultSet as $row){
			$entry	= new Application_Model_ShippingAddress();
			$shippingAddress->setShid($row->shid)
				->setRefcid($row->ref_cid)
				->setAddress1($row->address1)
				->setAddress2($row->address2)
				->setCity($row->city)
				->setState($row->state)
				->setZip($row->zip)
				->setCountry($row->country)
				->setCreated_at($row->created_at);
			$entries[]	= $entry;
		}
		return $entries;
	}
}

