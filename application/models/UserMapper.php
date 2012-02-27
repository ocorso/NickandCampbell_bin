<?php

class Application_Model_UserMapper
{
	protected $_dbTable;
	
	public function setDbTable($dbTable){
		if (is_string($dbTable)){
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract){
			throw new Exception('Invalid table data gateway provided for user');
		}
		$this->_dbTable = $dbTable;
		return $this;
	}
	
	public function getDbTable(){ 
		if (null === $this->_dbTable){
			$this->setDbTable('Application_Model_DbTable_User');
		}
		return $this->_dbTable;
	}//end function
		
	public function save(Application_Model_User $user){
		
		//oc: check by email
		$custWithMatchingEmail	= $this->fetchAll(array('email'=>$user->getEmail()));
		$exists = count($custWithMatchingEmail) > 0 ? true : false;
		
		//oc: get new info from form data
		$data 	= array(	'first_name'	=> $user->getFname(),
							'last_name'		=> $user->getLname(),
							'email'			=> $user->getEmail(),
							'phone'			=> $user->getPhone()

		);
		
		//oc: this checking seems to work.
		if(!$exists){
			echo "insert user\n";
			$uid = $this->getDbTable()->insert($data);
		}else {
			echo "update user\n";
			$uid = $custWithMatchingEmail[0]['uid'];
			$updateResults = $this->getDbTable()->update($data, array('uid = ?'=> $uid));
		}//endif
		return $uid;
		
	}//end function

	public function find($cid, Application_Model_User $user){
		$result		= $this->getDbTable()->find($uid);
		if(0 == count($result)){
			return;
		}
		$row 		= $result->current();
		$user->setOptions($row->toArray());
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

