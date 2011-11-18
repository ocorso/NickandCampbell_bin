<?php

class Application_Model_BillingAddressMapper
{
	protected $_dbTable;
	
	public function setDbTable($dbTable){
		if (is_string($dbTable)){
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract){
			throw new Exception('Invalid table data gateway provided for billing address');
		}
		$this->_dbTable = $dbTable;
		return $this;
	}
	
	public function getDbTable(){ 
		if (null === $this->_dbTable){
			$this->setDbTable('Application_Model_DbTable_BillingAddresses');
		}
		return $this->_dbTable;
	}
	
	public function save(Application_Model_BillingAddress $billingAddress){
		
		$data 	= array(
			'ref_cid'	=> $billingAddress->getRefcid(),
			'address1'	=> $billingAddress->getAddress1(),
			'address2'	=> $billingAddress->getAddress2(),
			'city'		=> $billingAddress->getCity(),
			'state'		=> $billingAddress->getState(),
			'zip'		=> $billingAddress->getZip(),
			'country'	=> $billingAddress->getCountry(),
			'created_at'=> date('Y-m-d H:i:s')
		);
		
		if(null === ($bid = $billingAddress->getBid())){
			unset($data('bid'));
			$this->getDbTable()->insert($data);
		} else {
			$this->getDbTable()->update($data, array('bid = ?'=> $bid));
		}//endif
	}//end function
	
	public function find($bid, Application_Model_BillingAddress $billingAddress){
		$result		= $this->getDbTable()->find($bid);
		if(0 == count($result)){
			return;
		}
		$row - $result->current();
		$billingAddress->setBid($row->bid)
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
			$entry	= new Application_Model_BillingAddress();
			$billingAddress->setBid($row->bid)
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

