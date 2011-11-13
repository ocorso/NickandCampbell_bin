<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_redirector = $this->_helper->getHelper('Redirector');
    }

    public function indexAction()
    {
    	
		//shop
        //todo: figure out how to handle different gender/category combinations
        //initially, we're just hard coding 'Mens Underwear'
        $products 					= new Application_Model_ProductMapper();	
        $options					= array('gender'=>'mens', 'category'=>'underwear');
        $productsAllSizes			= $products->fetchAllWithOptions($options);
        $this->view->products		= array();
        
		//filter out various sizes of same product
        foreach ($productsAllSizes as $p){
        	//todo loop through what's already in the products
        	if (!array_key_exists($p->getPretty(), $this->view->products)) {
        		//add it
        		$this->view->products[$p->getPretty()] = $p;
        	} 
        }
        
        //lookbook stuff
		$this->view->lookbookPgs 	= 10;
		$this->view->campaignWidth	= $this->view->lookbookPgs*1024;

		//contact stuff
        $contactForm				= new Application_Form_Contact();
        $contactForm->setAction("/contact");
        $this->view->contactForm	= $contactForm;

    }
}



