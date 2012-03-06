<?php
class ORed_ShoppingCart_Utils{
	
	/**
	* Get Cart: function that returns the shopping cart from where ever it is
	* get cart basically just adds up the price of the products 
	* and adds it to the subtotal.
	* @return $cartObj			- the standard php Cart object
	* */
	public function getCart()
	{
		//get cart
		$cart = new Zend_Session_Namespace('cart');
		 
		//calc cost of all items in the cart
		$subTotal 	= 0;
		foreach ($cart->items as $item){
			$subTotal += (int) $item['quantity']* (float)$item['price'];
		}
			
		//3. return json so JS can populate shopping cart
		$cartObj 			= new stdClass();
		$cartObj->subTotal 	= number_format($subTotal, 2);
		$cartObj->items		= $cart->items;
		return $cartObj;
	}
	
	public function add($item){
		
		$cMapper	= new Application_Model_CartMapper();
		
		
		$auth 		= Zend_Auth::getInstance();
		$uid 		= $auth->hasIdentity()? $auth->getIdentity()->uid: -1; 

		//oc: todo: discount and promo
		$itemArr =	array(								
			'sesh_id'	=> Zend_Session::getId(),
	 		'type'		=>$item['cart_type'],
			'ref_pid'	=>$item['id'],
			'ref_uid'	=>$uid,
			'discount'	=>0,//todo: determine discount from join
			'promo'		=>0,//todo: uhhhh..??
		    'quantity'	=>$item['quantity']
		);
		$c = new Application_Model_PreOrderCart($itemArr);
		print_r($c);
		$cMapper->savePre($c);
//		$cMapper->fetchAllWithOptions($item['cartType'], array('sesh_id'=>))
	}
	
	public function renewSession(){
		
		$auth 		= Zend_Auth::getInstance();
		$identity 	= $auth->getIdentity();
		$uid		= $identity->uid; 
		
		$cMapper	= new Application_Model_CartMapper();
		$cMapper->updateCartWithNewSession($uid, Zend_Session::getId());
	}
	
}