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
	
	/**
	 * This function (like all other first phase checkout
	 * methods will overwrite what is already there.
	 * 
	 * we can possibly put an AJAX db query on the checkout page
	 * when a user enters an email, we immediately look for
	 * shipping and billing addresses to display on the side.
	 *
	 * @param Application_Model_ShippingAddress $shippingAddress
	 * @return Ambigous <number, mixed, multitype:>
	 */
	public function save(Application_Model_ShippingAddress $shippingAddress){
		
		//oc: check by ref_cid
		$addresses	= $this->fetchAll(array('ref_cid'=>$shippingAddress->getRef_cid()));
		$exists = count($addresses) > 0 ? true : false;
		
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
		
		if(!$exists){
			//echo "shipping address insert";
			$shid = $this->getDbTable()->insert($data);
		} else {
			//echo "shipping address update";
			$shid = $addresses[0]['shid'];
			$this->getDbTable()->update($data, array('shid = ?'=> $shid));
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
	}
}

