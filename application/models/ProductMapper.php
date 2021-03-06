<?php

class Application_Model_ProductMapper
{
	protected $_productStylesTable;
	protected $_productsTable;

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
	
	public function setProductsTable($dbTable)
	{
		if (is_string($dbTable)){
			
			//$dbTable = new $dbTable();
			$dbTable = new Application_Model_DbTable_Product();
		}//end if
		
		if (!$dbTable instanceof Zend_Db_Table_Abstract){
			throw new Exception("Invalid table data gateway provided yo.");
		}
		$this->_productsTable = $dbTable;
		return $this;
	
	}//end function

	public function getProductsTable(){
		if (null === $this->_productsTable){
			$this->setProductsTable('Application_Model_DbTable_Product');
		}
		return $this->_productsTable;
	}//end function
	
	public function save(Application_Model_Product $product, Application_Model_ProductStyle $productStyle){
		
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
			'discount'		=> $product->getDiscount(),
			'sku'			=> $product->getSku()
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
		$product->setOptions($row->toArray());
				
	}//endfunction
	
	/*
	 * this is where we join 
	 * the product_styles table
	 * and 
	 * the product table
	 * 
	 */
	public function fetchAll(){
		
		$db			= Zend_Registry::get('db');
		$select		= $db->select();
		
		//oc: forget about db-table objects i guess;
		$select->from(array('p'=>'products'))
			->join(array('s'=>'product_styles'), 'p.ref_sid = s.sid');
		$result = $db->fetchAll($select);
		return($result);

	}//end function

	public function fetchAllWithOptions($opts, $inStock = true){
		
		//todo construct entries from 2 tables.

		$pSylesTable 		= $this->getProductStylesTable();
		$select				= $pSylesTable->select();
		foreach($opts as $column => $value){
			$n = $column.' = ?';
			$select->where($n, $value);
		}
//print_r($select->__toString());
		//cts we have in stock.
		//if($inStock)	$select->where('sku > ?', 0);
		
		//oc: to view the query string
		//echo $select->__toString();
		$resultSet	= $pSylesTable->fetchAll($select);
		
		$entries	= array();
		foreach($resultSet as $row){
			$entry 	= new Application_Model_ProductStyle();
			$entry->setOptions($row->toArray());
			$entries[]	= $entry; 
		}// endforeach
		
		return $entries;
		
	}//end function

	public function getProductsByStyleId($sid){
		$table 		= $this->getProductsTable();
		$select 	= $table->select();
		$select->where("ref_sid = ?", $sid);
		$resultSet	= $table->fetchAll($select);
		$entries	= array();
		foreach($resultSet as $row){
			$entry 	= new Application_Model_Product();
			$entry->setOptions($row->toArray());
			$entries[]	= $entry; 
		}// endforeach
		return $entries;
	}
}//end class

