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
			'id'			=> $product->getId(),
			'sid'			=> $product->getSid(),
			'name'			=> $product->getName(),
			'pretty'		=> $product->getPretty(),
			'description1'	=> $product->getDescription1(),
			'description2'	=> $product->getDescription2(),
			'campaign'		=> $product->getCampaign(),
			'label'			=> $product->getLabel(),
			'size'			=> $product->getSize(),
			'color'			=> $product->getColor(),
			'category'		=> $product->getCategory(),
			'gender'		=> $product->getGender(),
			'weight'		=> $product->getWeight(),
			'price'			=> $product->getPrice()
		);
		if (null === ($id = $product->getId())){
			unset($data['id']);
			$this->getDbTable()->insert($data);
		} else{
			$this->getDbTable()->update($data, array('id = ?'=> $id));
		}//endif
		
	}//end function 
	
	public function find($id, Application_Model_Product $product){
		$result 	= $this->getDbTable()->find($id);
		if (0 == count($result)){
			return;
		}//endif
		$row 		= $result->current();
		$product->setId($row->id)
				->setSid($row->sid)
				->setName($row->name)
				->setPretty($row->pretty)
				->setDescription1($row->description1)
				->setDescription2($row->description2)
				->setCampaign($row-campaign)
				->setLabel($row->label)
				->setSize($row->size)
				->setColor($row-color)
				->setCategory($row->category)
				->setGender($row->gender)
				->setWeight($row->weight)
				->setPrice($row->price);
				
	}//endfunction
	
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

