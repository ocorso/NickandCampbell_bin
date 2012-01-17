<?php

class CheckoutController extends Zend_Controller_Action
{
	protected $_form;
	
	// =================================================
	// ================ Callable
	// =================================================
	
	// =================================================
	// ================ Workers
	// =================================================
	
    public function init()
    {
    	$view = $this->view;
    	$this->_form = new Application_Form_Checkout();
    	$view->headScript()->appendFile("/js/site/checkout.js");
        $this->_redirector = $this->_helper->getHelper('Redirector');
    }
	
	// =================================================
	// ================ Handlers
	// =================================================
	
	// =================================================
	// ================ Animation
	// =================================================
	
	// =================================================
	// ================ Getters / Setters
	// =================================================
	private function _getForm(){
		
		return $this->_form;
	}
	// =================================================
	// ================ Interfaced
	// =================================================
	
	// =================================================
	// ================ Core Handler
	// =================================================
	
	// =================================================
	// ================ Overrides
	// =================================================
	
	// =================================================
	// ================ Constructor
	// =================================================

    public function indexAction()
    {
    	   		//disable layout
    		$layout = $this->_helper->layout();
    		//$layout->disableLayout();
    		
    		
    	//todo redirect to https if we're on production
    	if (!isset ($_ENV["HTTPS"]) && $_SERVER["HTTP_HOST"] != 'nc.dev' && APPLICATION_ENV != "mamp")    	$this->_redirector->gotoUrl("https://".$_SERVER["SERVER_NAME"]."/checkout/");
    	

        $request	= $this->getRequest();
        $form		= $this->_getForm();
      
        
        if($this->getRequest()->isPost()){
        	
        	if($form->isValid($request->getPost())){
        		//todo: make authorize.net call
        		$form->populate($form->getUnfilteredValues());
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

    public function transactionResultsAction()
    {
    	// we don't have results go to checkout page
    	if (!$this->getRequest()->isPost()) {
    		
            return $this->_forward('index');
        }//endif
        
        $form = $this->_getForm();
        if(!$form->isValid($_POST)){
        	
        	//failed validation; redisplay form
        	$this->view->form	= $form;
        	echo  $form;
        	return;
        }//endif
		        
        $this->view->isValid = true;
        $values = $form->getValues();
        print_r($values);
        
    }


}





