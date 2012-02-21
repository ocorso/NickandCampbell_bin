<?php

class ShoppingCartController extends Zend_Controller_Action
{
    public function init()
    {
    //	print_r($_SESSION);
    	//disable layout
        $layout = $this->_helper->layout();
      	$layout->disableLayout();
    }

    public function indexAction()
    {
    	$this->view->cartObj	= 	ORed_ShoppingCart_Utils::getCart();
    }

    public function addAction()
    {
        //oc
        //1. gather stuff we need
        $cart 		= new Zend_Session_Namespace('cart');
        $itemToAdd 	= $this->getRequest()->getParam('itemToAdd');
        
        
        	//loop through to see if this product is already in the cart
        	//if yes, update quantity
        	//if no, add it to the cart
        if (isset($cart->items) && count($cart->items) !=0) {
        	$i = -1;//index we found id at
        	foreach ($cart->items as $key=>$item){
        		if ($cart->items[$key]['id'] == $itemToAdd['id']) $i = $key;
        	}//end for each
        	if($i != -1) $cart->items[$i]['quantity'] += $itemToAdd['quantity'];
        	else{
        //2. put new product in there
        		$cart->items[] = array(	'id'		=>$itemToAdd['id'],
        		   					'name'		=>$itemToAdd['name'],
        		   					'pretty'	=>$itemToAdd['pretty'],
        		   					'price'		=>$itemToAdd['price'],
        		    				'quantity'	=>$itemToAdd['quantity'],
        		    				'size'		=>$itemToAdd['size']
        		);		
        	}//endif 
            			
        } else {
        	$cart->items = array(	array(	'id'		=>$itemToAdd['id'],
        		    						'name'		=>$itemToAdd['name'],
        		    						'pretty'	=>$itemToAdd['pretty'],
        		    						'price'		=>$itemToAdd['price'],
        		    						'quantity'	=>$itemToAdd['quantity'],
        		    						'size'		=>$itemToAdd['size'])
        	); // first time
       }//endif
        				 
        			
       $this->view->json	= json_encode(ORed_ShoppingCart_Utils::getCart());
       //4. grab a beer, you're almost there.
       //cheers!
    }

    public function removeAction()
    {

        $itemToRemove = $this->getRequest()->getParam('itemToRemove');
        $cart 		= new Zend_Session_Namespace('cart');
        foreach ($cart->items as $key => $item){
        	
        	if ($item['id'] == $itemToRemove) {
        		unset($cart->items[$key]);
				$cart->items = array_values($cart->items);        		
        	}
        }
        $this->view->json	= json_encode(ORed_ShoppingCart_Utils::getCart());
        
    }

    public function emptyAction()
    {
       $this->_cart->items = array();
    }

    public function dumpAction()
    {
		print_r($this->_cart->items);
    }


}

