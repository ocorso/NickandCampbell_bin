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
	protected function _callAuthorizeDotNet($order)
	{
		// action body
		print_r("hey there");
		print_r($order);
		$transaction_id = 69;
	
		require_once 'anet_php_sdk/AuthorizeNet.php';
		define("AUTHORIZENET_API_LOGIN_ID", "94EtqH8y");
		define("AUTHORIZENET_TRANSACTION_KEY", "64UyF8TFt7cUA22U");
		define("AUTHORIZENET_SANDBOX", true);
		$sale = new AuthorizeNetAIM;
	
		$sale->amount 		= $order['subtotal'];
		$sale->card_num 	= $order['billing2']['card_num'];
		$sale->exp_date 	= $order['billing2']['exp_date'];
		$response 			= $sale->authorizeAndCapture();
	
		if ($response->approved) {
			$transaction_id = $response->transaction_id;
			echo "trans id: ".$transaction_id;
		}//end if
		else echo "fail";
	
		//todo: dump more meaningful stuff about the fail.
	
		return $transaction_id;
	}
	protected function _sendEmail($order){
		$mail = new Zend_Mail();
		$body = 'Hi,
		
		An order has been submitted.
		
		
		Kind regards,
		Nick + Campbell';  
		$mail->setFrom('info@nickandcampbell.com', 'Nick + Campbell');
		$mail->addTo('owen.corso@yahoo.com', 'Owen Admin');
		$mail->setSubject("Order Submitted");
		$mail->setBodyText($body);
		$mail->send();
		//echo $body;
	}
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
	// ================ Actions
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
		$print_r($response);
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
			return $this->_forward('index');
		}//endif

		//omg we have a valid form and it looks like this:
		$values = $form->getValues();
		$orderId = $this->_callAuthorizeDotNet($values);
		$this->view->orderId = $orderId;
			
		//1. send email with order info
		$this->_sendEmail($values);
		//2. save cust data
		//3. save shipping address
		//4. save billing address
		//5. save order
		//
		
		$this->view->isValid = $orderId == 69 ? false : true;
		
		
	}


}





