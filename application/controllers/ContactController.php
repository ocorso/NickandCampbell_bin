<?php

class ContactController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_redirector = $this->_helper->getHelper('Redirector');	
    }

    public function indexAction()
    {
    	$req	= $this->getRequest();
    	if ($req->isPost()){
    		//oc: send email with the form data.
    		$form	= $req->getParams();
    		
    		print_r($form);
    	} else
	        $this->_redirector->gotoUrl('/#/contact/');
    }


}

