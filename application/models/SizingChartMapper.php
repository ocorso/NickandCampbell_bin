<?php

class Application_Model_SizingChartMapper
{
	protected $_dbTable;
	
	public function setDbTable($dbTable)
	{
		if (is_string($dbTable)){
			$dbTable = new $dbTable();
		}//end if
		
		if (!$dbTable instanceof Zend_Db_Table_Abstract){
			throw new Exception("Invalid table data gateway provided yo.");
		}
		$this->_dbTable = $dbTable;
		return $this;
	
	}//end function

	public function getDbTable(){
		if (null === $this->_dbTable){
			$this->setDbTable('Application_Model_DbTable_SizingChart');
		}
		return $this->_dbTable;
	}//end function

	public function fetchAll(){

		$resultSet 	= $this->getDbTable()->fetchAll();
		$entries	= array();
		foreach($resultSet as $row){
			$entries[$row->size_id]	= array('size_name'=> $row->size_name, 'description'=>$row->description);
		}// endforeach
		
		return $entries;
	}//end function

	public function fetchAllIndexByName(){

		$resultSet 	= $this->getDbTable()->fetchAll();
		$entries	= array();
		foreach($resultSet as $row){
			$entries[$row->size_name]	= array('id'=> $row->size_id, 'description'=>$row->description);
		}// endforeach
		
		return $entries;
		
	}//end function
}

