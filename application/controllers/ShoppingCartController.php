<?php

class ShoppingCartController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
    {
        //disable layout
            	$layout = $this->_helper->layout();
            	$layout->disableLayout();
        
        //todo
        //1. create session, if doesn't exists
        				$cart = new Zend_Session_Namespace('cart');
        				$itemToAdd = $this->getRequest()->getParam('itemToAdd');
        				
        				if (isset($cart->items) && count($cart->items) !=0) {
        					//todo: loop through to see if this product is already in the cart
        					//if yes, update quantity
        					//if no, add it to the cart
        					foreach ($cart->items as $item){
        						if ($item['id'] == $itemToAdd['id']) $item['quantity'] = $itemToAdd['quantity'];
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
        					}//endforeach
            			
        				} else {
        				    $cart->items = array(	array(	'id'		=>$itemToAdd['id'],
        		    										'name'		=>$itemToAdd['name'],
        		    										'pretty'	=>$itemToAdd['pretty'],
        		    										'price'		=>$itemToAdd['price'],
        		    										'quantity'	=>$itemToAdd['quantity'],
        		    										'size'		=>$itemToAdd['size'])); // first time
        				}
        				 
        				//calc cost of all items in the cart
        				$subTotal 	= 0;
        				foreach ($cart->items as $item){	$subTotal .= $item['price']*$item['price'];}
        								
                       	//3. return json so JS can populate shopping cart
                       	$cartObj 			= new stdClass();
                       	$cartObj->subTotal 	= $subTotal;
                       	$cartObj->items		= $cart->items;
                       	$this->view->json	= json_encode($cartObj);
                       	//4. grab a beer, you're almost there.
                       	//cheers!
    }

    public function removeAction()
    {
        // action body
    }

    public function emptyAction()
    {
       $cart 		= new Zend_Session_Namespace('cart');
       $cart->items = array();
    }


}







