<?php

class ProductController extends Zend_Controller_Action
{
    		/*****************************************************
			* oc: EXPECTED CATEGORIES FOR PRODUCT QUERIES:
			*
			*	MENS
			*	MENS UNDERWEAR
			*
			*
			//*****************************************************/ 
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
//    	$opts	= array ('gender'=>"mens", 'category'=>'underwear');
//    	$opts	= array ('name'=> 'The Brazil Boxer Brief');

    	
     		//set req
     		$req		= $this->getRequest();
    		//create opts
    		$opts		= array('gender'=>'mens');
			$opts  		= $req->getParam('category') ? 	array_merge($opts, array('category'=>$req->getParam('category'))) : $opts;
			$opts  		= $req->getParam('product') ? 	array_merge($opts, array('pretty'=>$req->getParam('product'))) : $opts;
			
			//get product info since we're ajaxing it in
    		$products = new Application_Model_ProductMapper();
    		$this->view->products = $products->fetchAllWithOptions($opts);

    		
   		//disable layout
    	$layout = $this->_helper->layout();
    	$layout->disableLayout();
        $products = new Application_Model_ProductMapper();
        $sizes = new Application_Model_SizingChartMapper();
        $this->view->sizeArr	= $sizes->fetchAll();
    	//$this->view->products 	= $products->fetchAllWithOptions($opts);
    	
    }
	

}

