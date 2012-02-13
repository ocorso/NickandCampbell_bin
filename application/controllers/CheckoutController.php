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
		
		//disable layout
		$layout = $this->_helper->layout();
		$layout->disableLayout();
		 $orderId = 69;
		 
		// we don't have results go to checkout page
		if (!$this->getRequest()->isPost() || !$this->_getForm()->isValid($_POST)) {

		//	return $this->_forward('index');
			$tempValues = array(
				'subtotal'=> 35.00,
				'shipping1'=>array(	'cust_first_name'=>'Owen',
									'cust_last_name'=>'Corso',
									'cust_email'=>'owen@ored.net',
									'cust_phone'=>'2016020069',
									'addr1'=>'410 E13th Street',
									'addr2'=>'Apt 1E',
									'city'=>'New York',
									'state'=>'NY',
									'zip'=>10003,
									'country'=>"United States"
					),
				'shipping2'=>array('sh_type1'=>1	),
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
		}//endif

		$form 		= $this->_getForm();
		$formValues = $form->getValues();

		//MODELS
		$cModel		= new Application_Model_CustomerMapper();
		$shModel	= new Application_Model_ShippingAddressMapper();
		$bModel		= new Application_Model_BillingAddressMapper();
		//$oModel		= new Application_Model_OrderMapper();
		
		
		//omg we have a valid form and it looks like this:
		$values 	= $formValues['debug'] ==1 ? $formValues : $tempValues;
//print_r($values);
		//oc: todo: check internet connection before making call.
		//$orderId = $this->_callAuthorizeDotNet($values);
		//$this->view->orderId = $orderId;

		
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++	EMAIL	  ++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//1. send email with order info
		//$this->_sendEmail($values);
		
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++	CUSTOMER	 +++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//2. save cust data
		$cust 		= ORed_Checkout_Utils::createCustomer($values['shipping1']);
		$cid		= $cModel->save($cust);
		echo "cid: ".$cid."\n";
		$allCusts	= $cModel->fetchAll(array('email'=>$cust->getEmail()));
		//print_r($allCusts);
		
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++	SHIPPING	 +++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//3. save shipping address
		$sh			= ORed_Checkout_Utils::createShippingAddress($cid, $values['shipping1']);
		print_r($sh);
		$shid		= $shModel->save($sh);
		echo "shid: ".$shid."\n";
		
		//3.5 add shipping cost to 
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++	BILLING		 +++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//4. save billing address
		//5. save order
		//
		
		$this->view->isValid = $orderId == 69 ? false : true;
		
		
	}


}





