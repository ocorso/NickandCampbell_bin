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
        	//default: men's underwear, 
        		//accordion of gender/categories on sidebar
        		//main nav pulldown of gender/categories also, 
        		//onClick, replaces sidebar display and grid contents
        		
        //initially, we're just hard coding 'Mens Underwear'
        $pMapper 					= new Application_Model_ProductMapper();	
        $options					= array('gender'=>'mens', 'category'=>'underwear');
        $productStyles				= $pMapper->fetchAllWithOptions($options);
        $this->view->products		= array();
        
        //print_r($productStyles);
		//filter out various sizes of same product
        foreach ($productStyles as $p){
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

    public function sitemapAction()
    {
          $this->_redirector->gotoUrl("/#/sitemap/");	
    }

    public function privacyAction()
    {
          $this->_redirector->gotoUrl("/#/privacy/");	
    }

    public function shippingAction()
    {
          $this->_redirector->gotoUrl("/#/shipping/");	
    }

    public function returnsAction()
    {
          $this->_redirector->gotoUrl("/#/returns/");	
    }

}















