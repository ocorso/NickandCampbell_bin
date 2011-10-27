<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	//contact stuff
        $contactForm				= new Application_Form_Contact();
        $contactForm->setAction("/contact");
        $this->view->contactForm	= $contactForm;
		
        //lookbook stuff
		$this->view->totalLookbookPages = 10;
		$this->view->campaignDivWidth	= $this->view->totalLookbookPages*1024;
    }

    public function shopAction()
    {
        // action body
    }


}



