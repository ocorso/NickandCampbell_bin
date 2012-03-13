<?php
/**
 * This class contains utility functions related to the shopping cart ...
 * @author Owen Corso
 *
 */
class ORed_ShoppingCart_Utils{
	
	/**
	* Get Cart: function that returns the shopping cart from where ever it is
	* get cart basically just adds up the price of the products 
	* and adds it to the subtotal.
	* @return $cartObj			- the standard php Cart object
	* */
	public function getCart()
	{

		//oc: fetch cart for display
		$cMapper				= new Application_Model_CartMapper();
		$cart4View				= new stdClass();
		$cart4View->items		= $cMapper->fetchCartForDisplay();
		$cart4View->subTotal 	= ORed_ShoppingCart_Utils::calcSubTotal($cart4View->items);
		return	$cart4View;
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
		$cMapper->savePre($c);
//		$items = $cMapper->fetchAllWithOptions($item['cart_type'], array('sesh_id'=>Zend_Session::getId()));
		$items = $cMapper->fetchCartForDisplay();
		return $items;
	}
	
	public function remove($pid){
		$cMapper	= new Application_Model_CartMapper();
		$cMapper->deleteCartByPid($pid);
		$items		= $cMapper->fetchCartForDisplay();
		return $items;
	}
	
	
	public function calcSubTotal($items, $shippingCost = 1.00){
		
		$subTotal = 0;
		
		foreach ($items as $i){
			$i['price'] 	= $i['price'] * (1 - $i['discount']);//oc: yeah calc that discount!
			$subTotal 	   += (float) $i['price'] * $i['quantity'];
		}//endforeach
		
		//oc: todo: check to see if shipping is there.
		$subTotal += $shippingCost;
		
		return $subTotal.".00";
	}
	
	public function renewSession(){
		
		$auth 		= Zend_Auth::getInstance();
		$identity 	= $auth->getIdentity();
		$uid		= $identity->uid; 
		
		$cMapper	= new Application_Model_CartMapper();
		$cMapper->updateCartWithNewSession($uid, Zend_Session::getId());
	}
	
}