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
    	    		//disable layout
    		$layout = $this->_helper->layout();
    		$layout->disableLayout();
        $products = new Application_Model_ProductMapper();
        $sizes = new Application_Model_SizingChartMapper();
        $this->view->sizeArr	= $sizes->fetchAll();
    	$this->view->products 	= $products->fetchAll();
    	
    }
	

}

