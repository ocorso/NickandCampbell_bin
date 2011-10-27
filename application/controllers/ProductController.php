<?php

class ProductController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $products = new Application_Model_ProductMapper();
    	$this->view->products = $products->fetchAll();
    
    }


}

