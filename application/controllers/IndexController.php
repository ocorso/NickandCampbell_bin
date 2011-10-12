<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $contactForm				= new Application_Form_Contact();
        $contactForm->setAction("/contact");
        $this->view->contactForm	= $contactForm;
    }
    public function shopAction()
    {
 		echo "hey dog";
    }


}

