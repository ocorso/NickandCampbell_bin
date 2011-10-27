<?php

class Application_Model_ProductMapper
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
			$this->setDbTable('Application_Model_DbTable_Product');
		}
		return $this->_dbTable;
	}//end function
	
	public function save(Application_Model_Product $product){
		$data = array(
			'id'	=> $product->getId(),
			'name'	=> $product->getName()
		);
		if (null === ($id = $product->getId())){
			unset($data['id']);
			$this->getDbTable()->insert($data);
		} else{
			$this->getDbTable()->update($data, array('id = ?'=> $id));
		}//endif
		
	}//end function 
	
	public function fetchAll(){

		$resultSet 	= $this->getDbTable()->fetchAll();
		$entries	= array();
		foreach($resultSet as $row){
			$entry 	= new Application_Model_Product();
			$entry->setId($row->id)
					->setName($row->name);
			$entries[]	= $entry; 
		}// endforeach
		
		return $entries;
		
	}//end function

}//end class

