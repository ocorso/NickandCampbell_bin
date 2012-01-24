<?php

class Application_Model_ProductMapper
{
	protected $_productStylesTable;
	protected $_productsTable;
	// Build this query:
	//   SELECT p."product_id", p."product_name", l.*
	//   FROM "products" AS p JOIN "line_items" AS l
	//     ON p.product_id = l.product_id
	
// 	$select = $db->select()
// 	->from(array('p' => 'products'),
// 	array('product_id', 'product_name'))
// 	->join(array('l' => 'line_items'),
// 	                    'p.product_id = l.product_id');

	public function setProductSylesTable($dbTable)
	{
		if (is_string($dbTable)){
			
			//$dbTable = new $dbTable();
			$dbTable = new Application_Model_DbTable_ProductStyles();
		}//end if
		
		if (!$dbTable instanceof Zend_Db_Table_Abstract){
			throw new Exception("Invalid table data gateway provided yo.");
		}
		$this->_productStylesTable = $dbTable;
		return $this;
	
	}//end function

	public function getProductStylesTable(){
		if (null === $this->_productStylesTable){
			$this->setProductSylesTable('Application_Model_DbTable_ProductSyles');
		}
		return $this->_productStylesTable;
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
			'price'			=> $product->getPrice(),
			'sku'		=> $product->getSku()
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
		$row 	= $result->current();
		$product->setId($row->id)
				->setSid($row->sid)
				->setName($row->name)
				->setPretty($row->pretty)
				->setDescription1($row->description1)
				->setDescription2($row->description2)
				->setCampaign($row->campaign)
				->setLabel($row->label)
				->setSize($row->size)
				->setColor($row->color)
				->setCategory($row->category)
				->setGender($row->gender)
				->setWeight($row->weight)
				->setPrice($row->price)
				->setSku($row->sku);
				
	}//endfunction
	
	public function fetchAll(){

		$resultSet 	= $this->getDbTable()->fetchAll();
		$entries	= array();
		foreach($resultSet as $row){
			$entry 	= new Application_Model_Product();
			$entry->setId($row->id)
				->setSid($row->sid)
				->setName($row->name)
				->setPretty($row->pretty)
				->setDescription1($row->description1)
				->setDescription2($row->description2)
				->setCampaign($row->campaign)
				->setLabel($row->label)
				->setSize($row->size)
				->setColor($row->color)
				->setCategory($row->category)
				->setGender($row->gender)
				->setWeight($row->weight)
				->setPrice($row->price)
				->setSku($row->sku);
			$entries[]	= $entry; 
		}// endforeach
		
		return $entries;
		
	}//end function
	public function fetchAllWithOptions($opts, $inStock = true){
		
		//todo construct entries from 2 tables.
		$registry = Zend_Registry::getInstance();
		$db			= $registry->get('db');
		
		$pSylesTable 		= $this->getProductStylesTable();
		$select		= $pSylesTable->select();
		foreach(array_keys($opts) as $column){
			$n = $column.' = ?';
			$select->where($n, $opts[$column]);
		}
		//only return products we have in stock.
		if($inStock)	$select->where('sku > ?', 0);
		
		//oc: to view the query string
		//echo $select->__toString();
		
		$resultSet	= $pSylesTable->fetchAll($select);
		
		$entries	= array();
		foreach($resultSet as $row){
			$entry 	= new Application_Model_Product();
			$entry->setId($row->id)
				->setName($row->name)
				->setSid($row->sid)
				->setPretty($row->pretty)
				->setDescription1($row->description1)
				->setDescription2($row->description2)
				->setCampaign($row->campaign)
				->setLabel($row->label)
				->setSize($row->size)
				->setColor($row->color)
				->setCategory($row->category)
				->setGender($row->gender)
				->setWeight($row->weight)
				->setPrice($row->price)
				->setSku($row->sku);
			$entries[]	= $entry; 
		}// endforeach
		
		return $entries;
		
	}//end function

}//end class

