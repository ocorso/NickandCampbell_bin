<?php

class CheckoutController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_redirector = $this->_helper->getHelper('Redirector');
    }

    public function indexAction()
    {
    	//todo redirect to https if we're on production
    	if (!isset ($_ENV["HTTPS"]))    	$this->_redirector->gotoUrl("https://".$_SERVER["SERVER_NAME"]."/checkout/");
    	
        $request	= $this->getRequest();
        $form		= new Application_Form_Checkout();
        
        if($this->getRequest()->isPost()){
        	
        	if($form->isValid($request->getPost())){
        		//todo: make authorize.net call
        		
        		print_r($form->getValues());
        	}//end if form is valid
        }//end if there's post data present
        
        $this->view->form = $form;
    }

    public function testAction()
    {
        // action body
    	print_r("hey there");
    	require_once 'anet_php_sdk/AuthorizeNet.php'; 
    	define("AUTHORIZENET_API_LOGIN_ID", "94EtqH8y");
    	define("AUTHORIZENET_TRANSACTION_KEY", "64UyF8TFt7cUA22U");
    	define("AUTHORIZENET_SANDBOX", true);
    	$sale = new AuthorizeNetAIM;
   		$sale->amount 		= "25.99";
    	$sale->card_num 	= '6011000000000012';
    	$sale->exp_date 	= '04/15';
    	$response 			= $sale->authorizeAndCapture();
    	if ($response->approved) {
        	$transaction_id = $response->transaction_id;
        	echo "trans id: ".$transaction_id;
    	}//end if
	    else echo "fail";
    }


}



