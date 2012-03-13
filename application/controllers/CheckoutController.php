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
		// $mail->send();
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
				//oc: todo: redirect
				$this->_helper->redirector('transaction-results', 'checkout');
			}else{
				$form->populate($form->getUnfilteredValues());
				$this->view->isValid = false;
			}
			
		}//end if there's post data present
		
		$this->view->isGet = $request->isGet();
		$this->view->form = $form;
	}

	public function testAction()
	{
		// action body
		print_r("hey there");
		require_once 'ANet/AuthorizeNet.php';
		define("AUTHORIZENET_API_LOGIN_ID", "94EtqH8y");
		define("AUTHORIZENET_TRANSACTION_KEY", "64UyF8TFt7cUA22U");
		define("AUTHORIZENET_SANDBOX", true);
		$sale = new AuthorizeNetAIM();
		$sale->amount 		= "25.99";
		$sale->card_num 	= '6011000000000012';
		$sale->exp_date 	= '04/15';
		$response 			= $sale->authorizeAndCapture();
	print_r($response);
		if ($response->approved) {
			$transaction_id = $response->transaction_id;
			echo "trans id: ".$transaction_id;
		}//end if
		else echo "fail";
	}


	public function transactionResultsAction()
	{
		
		echo "<h1>Good Day Sir, lets see what happened.</h1>\n<br />";
		
		//disable layout
		$layout = $this->_helper->layout();
		$layout->disableLayout();
		
		//
		$orderId 			= 69;
		$this->view->isGet 	=  $this->getRequest()->isGet();

		// we don't have results go to checkout page
		if ($this->getRequest()->isGet()) {
			echo "temp results\n<br />";
			$tempValues = array(
				'subtotal'=> 35.00,
				'shipping1'=>array(	'cust_first_name'=>'Owen',
									'cust_last_name'=>'Corso',
									'cust_email'=>'owen@ored.net',
									'password'=>'studionc',
									'cust_phone'=>'2016020069',
									'addr1'=>'410 E13th Street',
									'addr2'=>'Apt 1E',
									'city'=>'New York',
									'state'=>'NY',
									'zip'=>10003,
									'country'=>"United States"
					),
				'shipping2'=>array('sh_type'=>1	),
				'billing1'=>array(	'addr1'=>'410 E13th Street',
									'addr2'=>'Apt 1E',
									'city'=>'New York',
									'state'=>'NY',
									'zip'=>10003,
									'country'=>"United States"
					),
				'billing2'=>array(	'name_on_card'=>"Owen M Corso",
									'card_type'=>'visa',
									'card_num'=>12341234122341234,
									'ccv'=>123,
									'exp_date'=>122012
					)
			
			);
			$values = $tempValues;
		}//endif
		else {
			echo "real values";
	
			$form 		= $this->_getForm();
			$formValues = $form->getValues();
			$values = $formValues;
		}

		//MODELS
		$uModel		= new Application_Model_UserMapper();
		$shModel	= new Application_Model_ShippingAddressMapper();
		$bModel		= new Application_Model_BillingAddressMapper();
		//$oModel		= new Application_Model_OrderMapper();
		
		
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++	EMAIL	  ++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//1. send email with order info
		//$this->_sendEmail($values);
		
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++	CUSTOMER	 +++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//2. save cust data
		//oc: todo: put password from identity into $values
		$auth 		= Zend_Auth::getInstance();
		$whoAmI 	= $auth->getIdentity();
		
		$user 		= ORed_Checkout_Utils::createUser($values['shipping1']);
		$uid		= $uModel->save($user);
		echo "uid: ".$uid."\n<br />";
		$allCusts	= $uModel->fetchAll(array('email'=>$user->getEmail()));
		//print_r($allCusts);
		
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++	SHIPPING	 +++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//3. save shipping address
		$sh			= ORed_Checkout_Utils::createShippingAddress($uid, $values['shipping1']);
		$shid		= $shModel->save($sh);
		echo "shid: ".$shid."\n<br />";
		
		//3.5 add shipping cost to 
		$shType		= $values['shipping2']['sh_type'];
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++	BILLING		 +++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//4. save billing address
		$b			= ORed_Checkout_Utils::createBillingAddress($uid, $values['billing1']);
		$bid		= $bModel->save($b);
		echo "bid: ".$bid."\n<br />";
		
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++	AUTHORIZE	 +++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//5. save order
		//	- upon successful auth, 
		//		- save cart items into postorder table
		//		- construct order, save new record in orders table
		
		//	- upon unsuccessful auth,
		//		- reload checkout page, 
		//		- provide meaningful error
		//		- populate form with everything EXCEPT credit card info
		//		- auto scroll over to the credit card info segment
		//
		
		$o			= ORed_Checkout_Utils::createOrder($uid,$shid,$bid,$shType);
		//oc: todo: check internet connection before making call.
		//$orderId = $this->_callAuthorizeDotNet($values);
		$this->view->orderId	= $orderId;
		$this->view->form 		= $this->_getForm();
	}


}





