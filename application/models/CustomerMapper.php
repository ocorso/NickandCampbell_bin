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
		$exists	= $this->fetchAll(array('email'=>$customer->getEmail()));
		print_r($exists);
		
		$data 	= array(	'first_name'	=> $customer->getFname(),
							'last_name'		=> $customer->getLname(),
							'email'			=> $customer->getEmail(),
							'phone'			=> $customer->getPhone()

		);
		
		//need to improve this checking.
		if(null == $customer->getCid()){
			echo "insert";
			$cid = $this->getDbTable()->insert($data);
			return $cid;
		}else {
			echo "update";
			$cid = $this->getDbTable()->update($data, array('cid = ?'=> $customer->getCid()));
			return $cid;
		}//endif
		
	}//end function
	
	public function find($cid, Application_Model_Customer $customer){
		$result		= $this->getDbTable()->find($cid);
		if(0 == count($result)){
			return;
		}
		$row 		= $result->current();
		$customer->setOptions($row->toArray());
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

