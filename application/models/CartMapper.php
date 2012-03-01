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
			case 'Application_Model_DbTable_PreOTable' : $this->_preOTable = new Application_Model_DbTable_PreorderCart(); break;
			case 'Application_Model_DbTable_PostOTable' : $this->_postOTable = new Application_Model_DbTable_PostorderCart(); break;
			default : throw new Exception("Invalid table data gateway provided yo.");
		}//end switch

	}//endfunction
		
	public function savePre(Application_Model_PreOrderCart $c){
		
//		oc: 1. check if ref_pid exists in any of the records that match the session_id
		$records 	= $this->fetchAllWithOptions($c->getType(), array('sesh_id'=>$c->getSesh_id()));
		$exists		= false;
		if (count($records)>0){
			foreach($records as $possibleMatch){
				print_r($possibleMatch);
				if ($possibleMatch->ref_pid == $c->getRef_pid()){
					$exists = true;
//		2. update quantity on existing cart item
					$c->setQuantity($c->getQuantity() + $possibleMatch->quantity);
				}//endif
			}//endforeach
		}//endif

//		3. OR insert new cart item into PreOrderCart Table using $c
		$db	= $this->getPreOTable();
		if($exists){
			$db->update($c->toArray());
		}else{
			$db->insert($c->toArray());
		}
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
	
	public function updateCartWithNewSession($uid, $sesh_id){
		echo 'update with new sesh: '.$sesh_id;
		
		// grab any shopping cart items under existing session
		//put this uid in there
		// grab any shopping cart items under this user
		//put this session id in there
		// merge them intelligently
		
		//oc: todo: select * FROM preorder_cart WHERE uid=$uid
		// 1. update created_at with current time
		// 2. update sesh_id with current session_id
		
	}
}//end class

