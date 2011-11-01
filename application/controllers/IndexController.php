<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
		//shop
        $products 					= new Application_Model_ProductMapper();	
        $options					= array('gender'=>'mens', 'category'=>'underwear');
        $this->view->products		= $products->fetchAllWithOptions($options);
        
        //lookbook stuff
		$this->view->lookbookPgs 	= 10;
		$this->view->campaignWidth	= $this->view->totalLookbookPages*1024;

		//contact stuff
        $contactForm				= new Application_Form_Contact();
        $contactForm->setAction("/contact");
        $this->view->contactForm	= $contactForm;

    }
}



