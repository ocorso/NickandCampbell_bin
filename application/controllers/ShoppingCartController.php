<?php

class ShoppingCartController extends Zend_Controller_Action
{
	protected $_cart; //this is the session var that we'll hopefully populate in init
    public function init()
    {
    	//get cart
    	$this->_cart = new Zend_Session_Namespace('cart');
    	
    	//disable layout
        $layout = $this->_helper->layout();
      	$layout->disableLayout();
    }

    protected function _formatCartContents($cart)
    {
		
		//calc cost of all items in the cart
        $subTotal 	= 0;
        foreach ($cart->items as $item){	$subTotal += (int) $item['quantity']* (float)$item['price'];}
        							
        //3. return json so JS can populate shopping cart
        $cartObj 			= new stdClass();
        $cartObj->subTotal 	= number_format($subTotal, 2);
        $cartObj->items		= $cart->items;
       	return $cartObj;
    }

    public function indexAction()
    {
    	$this->view->cartObj	= $this->_formatCartContents($this->_cart);
    }

    public function addAction()
    {

        
        //todo
        //1. create session, if doesn't exists
        $itemToAdd = $this->getRequest()->getParam('itemToAdd');
        				
        if (isset($this->_cart->items) && count($this->_cart->items) !=0) {
        	//loop through to see if this product is already in the cart
        	//if yes, update quantity
        	//if no, add it to the cart
        	$i = -1;//index we found id at
        	foreach ($this->_cart->items as $key=>$item){
        		if ($this->_cart->items[$key]['id'] == $itemToAdd['id']) $i = $key;
        	}//end for each
        	if($i != -1) $this->_cart->items[$i]['quantity'] += $itemToAdd['quantity'];
        	else{
        //2. put new product in there
        		$this->_cart->items[] = array(	'id'		=>$itemToAdd['id'],
        		   					'name'		=>$itemToAdd['name'],
        		   					'pretty'	=>$itemToAdd['pretty'],
        		   					'price'		=>$itemToAdd['price'],
        		    				'quantity'	=>$itemToAdd['quantity'],
        		    				'size'		=>$itemToAdd['size']
        		);		
        	}//endif 
            			
        } else {
        	$this->_cart->items = array(	array(	'id'		=>$itemToAdd['id'],
        		    						'name'		=>$itemToAdd['name'],
        		    						'pretty'	=>$itemToAdd['pretty'],
        		    						'price'		=>$itemToAdd['price'],
        		    						'quantity'	=>$itemToAdd['quantity'],
        		    						'size'		=>$itemToAdd['size'])
        	); // first time
       }//endif
        				 
        			
       $this->view->json	= json_encode($this->_formatCartContents($this->_cart));
       //4. grab a beer, you're almost there.
       //cheers!
    }

    public function removeAction()
    {

        $itemToRemove = $this->getRequest()->getParam('itemToRemove');
        foreach ($this->_cart->items as $key => $item){
        	
        	if ($item['id'] == $itemToRemove) {
        		unset($this->_cart->items[$key]);
				$this->_cart->items = array_values($this->_cart->items);        		
        	}
        }
        $this->view->json	= json_encode($this->_formatCartContents($this->_cart));
        
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

