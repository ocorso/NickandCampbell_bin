<?php

class Application_Model_CustomerMapper
{
	protected $_dbTable;
	
	public function setDbTable($dbTable){
		if (is_string($dbTable)){
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract){
			throw new Exception('Invalid table data gateway provided for customer');
		}
		$this->_dbTable = $dbTable;
		return $this;
	}
	
	public function getDbTable(){ 
		if (null === $this->_dbTable){
			$this->setDbTable('Application_Model_DbTable_Customer');
		}
		return $this->_dbTable;
	}//end function
		
	public function save(Application_Model_Customer $customer){
		$data 	= array(	'first_name'	=> $customer->getLname(),
							'last_name'		=> $customer->getLname(),
							'email'			=> $customer->getEmail(),
							'phone'			=> $customer->getPhone(),
							'ref_shid'		=> $customer->getShid(),
							'ref_bid'		=> $customer->getBid()
		);
		
		if(null === ($cid = $customer->getCid())){
			unset($data('cid'));
			$this->getDbTable()->insert($data);
		}else {
			$this->getDbTable()->update($data, array('cid = ?'=> $cid));
			
		}//endif
	}//end function
	
	public function find($cid, Application_Model_Customer $customer){
		$result		= $this->getDbTable()->find($cid);
		if(0 == count($result)){
			return;
		}
		$row 		= $result->current();
		$customer->setCid($row->cid)
			->setFname($row->first_name)//oc: how will the data come back from the db?
			->setLname($row->last_name)
			->setEmail($row->email)
			->setPhone($row->phone)
			->setShid($row->ref_shid)//oc: this is peculier on my part
			->setBid($row->ref_bid)
			->setCreated_at($row->created_at);
	}
}

