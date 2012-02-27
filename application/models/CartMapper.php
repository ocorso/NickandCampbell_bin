<?php

class Application_Model_CartMapper
{
	protected $_preOTable;
	protected $_postOTable;

	public function getPreOTable(){
		if (null === $this->_preOTable) $this->setTable('Application_Model_DbTable_PreOTable');
		return $this->_preOTable;
	}
	public function getPostOTable(){
		if (null === $this->_postOTable) $this->setTable('Application_Model_DbTable_PostOTable');
		return $this->_postOTable;
	}
	
	public function setTable($t){
		
		switch ($t){
			case 'Application_Model_DbTable_PreOTable' : $this->_preOTable = new Application_Model_DbTable_PreOTable(); break;
			case 'Application_Model_DbTable_PostOTable' : $this->_postOTable = new Application_Model_DbTable_PostOTable(); break;
			default : throw new Exception("Invalid table data gateway provided yo.");
		}//end switch

	}//endfunction
		
	public function savePre(Application_Model_PreOrderCart $c){
		
//		$exists?
	}//end function 
	
	public function fetchAllWithOptions($cartType, array $opts){
		
		//oc: determine cart type
		switch($cartType){
			case Application_Model_SiteModel::$CART_TYPE_REAL:
			case Application_Model_SiteModel::$CART_TYPE_WISHLIST:
				 $db = $this->getPreOTable();
				 break;
			case Application_Model_SiteModel::$CART_TYPE_POST:
				$db = $this->getPostOTable();
				break;
			default : throw new Exception("Which cart are you talkin' bout Willis?");
			
		}//end switch
	
		//begin setting up query
		$select = $db->select();
		
		if (isset($opts['sesh_id'])){
			$select->where('sesh_id = ?', $opts['sesh_id']);
		}
	}//end function 
	
}//end class

