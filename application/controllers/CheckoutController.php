<?php

class CheckoutController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $request	= $this->getRequest();
        $form		= new Application_Form_Checkout();
        
        if($this->getRequest()->isPost()){
        	
        	if($form->isValid($request->getPost())){
        		//todo: make authorize.net call
        		
        		print_r($form->getValues());
        	}//end if form is valid
        }//end if there's post data present
        
        $this->view->form = $form;
    }//end function

}//end class

