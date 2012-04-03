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
	
	/**
	 * As for now, we overwrite whatever exists in billing_addresses
	 * under ref_cid, with new data
	 * 
	 * @param Application_Model_BillingAddress $billingAddress
	 */
	public function save(Application_Model_BillingAddress $billingAddress){
		
		//oc: check by ref_cid
		$addresses	= $this->fetchAll(array('ref_cid'=>$billingAddress->getRef_cid()));
		$exists = count($addresses) > 0 ? true : false;
		
		$data 	= array(
			'ref_cid'	=> $billingAddress->getRef_cid(),
			'address1'	=> $billingAddress->getAddress1(),
			'address2'	=> $billingAddress->getAddress2(),
			'city'		=> $billingAddress->getCity(),
			'state'		=> $billingAddress->getState(),
			'zip'		=> $billingAddress->getZip(),
			'country'	=> $billingAddress->getCountry(),
			'created_at'=> date('Y-m-d H:i:s')
		);
		
		if(!$exists){
		//	echo "billing address insert";
			$bid = $this->getDbTable()->insert($data);
		} else {
		//	echo "billing address update";
			$bid = $addresses[0]['bid'];
			$this->getDbTable()->update($data, array('bid = ?'=> $bid));
		}//endif
		
		return $bid;
		
	}//end function
	
	public function find($bid, Application_Model_BillingAddress $billingAddress){
		$result		= $this->getDbTable()->find($bid);
		if(0 == count($result)){
			return;
		}
		$row - $result->current();
		$billingAddress->setOptions($row->toArray());
		
	}
	
	public function fetchAll(array $options = null){
		$db 	= $this->getDbTable();
		$select = $db->select();
		
		if($options){
			foreach($options as $column => $value){
				$select->where($column."= ?",$value);
			}//endforeach
		}//endif
		$result = $db->fetchAll($select);
		//print_r($select); 
		return $result->toArray();
	}//end function
	
}//end class

