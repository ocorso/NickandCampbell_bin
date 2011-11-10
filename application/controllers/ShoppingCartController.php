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
				if (isset($cart->items)) {
    				$cart->items[] = array('id'=>2);
    			
				} else {
				    $cart->items = array(array('id'=>1)); // first time
				}
				 
				//echo "items id in slot 1: ".	 $cart->items[1]['id'];
    			//2. put new product in there
               	//3. return xml so JS can populate shopping cart
               	//4. grab a beer, you're almost there.
    }

    public function removeAction()
    {
        // action body
    }


}





