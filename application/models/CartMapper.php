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
	protected function _getTableByType($type){
			//oc: determine cart type
		switch($type){
			case Application_Model_SiteModel::$CART_TYPE_REAL:
			case Application_Model_SiteModel::$CART_TYPE_WISHLIST:
				 $db = $this->getPreOTable();
				 break;
			case Application_Model_SiteModel::$CART_TYPE_POST:
				$db = $this->getPostOTable();
				break;
			default : throw new Exception("Which cart are you talkin' bout Willis?");
			
		}//end switch
		return $db;
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
	//	print_r($records);
		if (count($records)>0){
			
			foreach($records as $possibleMatch){
	//			print_r($possibleMatch);
				if ($possibleMatch->ref_pid == $c->getRef_pid()){
					$exists = true;
//		2. update quantity on existing cart item
					$c->setId($possibleMatch->id);
					$c->setQuantity($c->getQuantity() + $possibleMatch->quantity);
				}//endif
			}//endforeach
		}//endif

//		3. OR insert new cart item into PreOrderCart Table using $c
		$db	= $this->getPreOTable();
		if($exists){ 
			$db->update($c->toArray(), array('id = ?'=> $c->getId()));
		}else{
			$db->insert($c->toArray());
		}
	}//end function 

	public function fetchCartWeight($cartType){
		$db 		= $this->_getTableByType($cartType)->getDefaultAdapter();
		$select 	= $db->select();
		
		$select->from(array('c'=>'preorder_cart'))
			->where("sesh_id =?", Zend_Session::getId())
			->join(array('p'=>'products'), 'p.pid = ref_pid')
			->join(array('s'=>'product_styles'),'p.ref_sid = s.sid');
			
		$results	= $db->fetchAll($select);
		(float)$total 		= 0;
		foreach ($results as $i){
			$total += $i['quantity'] * $i['weight'];			
		}
		return $total;
	}
	public function fetchAllWithOptions($cartType, array $opts = null){
		
		$db	= $this->_getTableByType($cartType);
	
		//begin setting up query
		$select = $db->select();
		
		if (isset($opts['sesh_id'])){
			$select->where('sesh_id = ?', $opts['sesh_id']);
		}
		
		
		$records = $db->fetchAll($select);
		return $records;
		
	}//end function 
	
	public function fetchCartForDisplay(){

		$db			= Zend_Registry::get("db");
		$select		= $db->select();

		//'preorder_cart', 
		/* The third argument to join() is an array of column names, like that used in the from() method. 
		 * It de- faults to "*", supports correlation names, expressions, 
		 * and Zend_Db_Expr in the same way as the array of column names in the from() method.
		 */
		//oc: todo: filter results down to only the fields we need.
		$fromProducts = array('');
		
		$select->from(array('c'=>'preorder_cart'))
			->join(array('p'=>'products'), 'p.pid = c.ref_pid')
			->join(array('s'=>'product_styles'),'p.ref_sid = s.sid')
			->join(array('z'=>'sizing_chart'), 'p.ref_size = z.size_id')
			->where('c.sesh_id = ?', Zend_Session::getId());
		
		$cart = $db->fetchAll($select);
		return $cart;
		//print_r($cart);
	}
	
	public function deleteCartByPid($pid){
		$db			= Zend_Registry::get("db");
		$db->delete('preorder_cart', "ref_pid = $pid");
	}
	public function updateCartWithNewSession($uid, $sesh_id){
		
		echo 'update with new sesh: '.$sesh_id;
		
		$cMappper = new Application_Model_CartMapper();
		
		// grab any shopping cart items under existing session
		$recordsToUpdate 	= $this->fetchAllWithOptions('real', array('sesh_id'=>$sesh_id));
		foreach($recordsToUpdate as $r){
			$d = new Application_Model_PreOrderCart($r->toArray());
			$d->setRef_uid($uid);
			$cMappper->savePre($d);	
		}
		
		//put this uid in there
		// grab any shopping cart items under this user
		//put this session id in there
		// merge them intelligently
		
		//oc: todo: select * FROM preorder_cart WHERE uid=$uid
		// 1. update created_at with current time
		// 2. update sesh_id with current session_id
		
	}//end function
	
}//end class

