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
	
}