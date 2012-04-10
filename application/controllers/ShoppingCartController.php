<?php

class ShoppingCartController extends Zend_Controller_Action
{

    public function init()
    {
  //	print_r('session id: '.Zend_Session::getId());
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
        //1. gather stuff we need, add item, calc subtotal, feed it to view.
        $itemToAdd 				= $this->getRequest()->getParam('itemToAdd');
        $cart4View				= new stdClass();
		$cart4View->items		= ORed_ShoppingCart_Utils::add($itemToAdd); 
        $cart4View->subTotal 	= ORed_ShoppingCart_Utils::calcSubTotal($cart4View->items);
       	$this->view->json		= json_encode($cart4View);
       //cheers!
    }

    public function removeAction()
    {

        $itemToRemove 			= $this->getRequest()->getParam('itemToRemove');
        $cart4View				= new stdClass();
        $cart4View->items		= ORed_ShoppingCart_Utils::remove($itemToRemove);
        $cart4View->subTotal 	= ORed_ShoppingCart_Utils::calcSubTotal($cart4View->items);
        $this->view->json		= json_encode($cart4View);
        
    }

    public function emptyAction()
    {
           $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
    $userAgent = $bootstrap->getResource('useragent');
    
    }

    public function dumpAction()
    {
		$cMapper 	= new Application_Model_CartMapper();
		$lineItems 	= $cMapper->fetchCartForANet();
		echo "LineItems: $lineItems";
    }

    public function calcCartWeightAction()
    {
    	$req	= $this->getRequest();
    	$type	=  $req->getParam("type") ? $req->getParam("type") : Application_Model_SiteModel::$CART_TYPE_REAL;
    	
       $this->view->weight = ORed_ShoppingCart_Utils::calcCartWeight($type);

    }


}



