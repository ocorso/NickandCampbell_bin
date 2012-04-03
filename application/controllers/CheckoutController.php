<?php

class CheckoutController extends Zend_Controller_Action
{
	protected $_form;
	protected $_chaChing = "cha-ching";
	protected $_devEmail;
	
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
	protected function _checkMessagesForValidForm(){
		$messages	= $this->_helper->flashMessenger->getMessages();
		if (count($messages)) {
			foreach ($messages as $message){ if ($message == $this->_chaChing) return true;}
		}//endif		
	}//end function
	// =================================================
	// ================ Handlers
	// =================================================
	protected function _callAuthorizeDotNet($data, Application_Model_Order $order)
	{
		//todo: action body
		//print_r($order);
		$transaction_id = 69;
	
		/*
		 * x_type
		 * 
		 * AUTH_CAPTURE (default), 
		 * AUTH_ONLY, 
		 * CAPTURE_ONLY, 
		 * CREDIT, 
		 * PRIOR_AUTH_CAPTURE, 
		 * VOID 
		 */
		require_once 'ANet/AuthorizeNet.php';
		$fields				= array( 
									'version'=>3.1,
									'first_name'=> $data['shipping1']['cust_first_name'],
									'last_name'=> $data['shipping1']['cust_last_name'],
									'phone'=> $data['shipping1']['cust_phone'],
									'email'=> $data['shipping1']['cust_email'],
									'amount'=> $data['subtotal'],
									'card_num'=> $data['billing2']['card_num'],
									'exp_date'=> $data['billing2']['exp_date'],
									'card_code'=>$data['billing2']['ccv'],
									'invoice_num'=> $order->getOid(),
									
								);
		$sale = new AuthorizeNetAIM();
		$sale->setFields($fields);
		$response 			= $sale->authorizeAndCapture();
	
		if ($response->approved) {
			$transaction_id = $response->transaction_id;
			echo "trans id: ".$transaction_id;
		}//end if
		else {
			echo "fail<br/>";
			print_r($response);
		}
		//todo: dump more meaningful stuff about the fail.
	
		return $transaction_id;
	}
	protected function _sendEmail($order){
		
		//oc: todo: config Zend_Mail in bootstrap.
		
		$mail = new Zend_Mail();
		$body = 'Hi,
		
		An order has been submitted.
		
		Kind regards,
		Nick + Campbell';  
		$mail->setFrom('info@nickandcampbell.com', 'Nick + Campbell');
		$mail->addTo($this->_devEmail, 'Owen Admin');
		$mail->setSubject("Order Submitted");
		$mail->setBodyText($body);
		//$mail->send();
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
				$this->_helper->flashMessenger->addMessage($this->_chaChing);
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
		$this->_checkMessagesForValidForm();
		//disable layout
		$layout = $this->_helper->layout();
		$layout->disableLayout();
		
		//
		$orderId 			= 69;
		$this->view->isGet 	=  $this->getRequest()->isGet();

		// we don't have results go to checkout page
		if (!$this->_checkMessagesForValidForm()) {
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
									'card_num'=>'6011000000000012',
									'ccv'=>123,
									'exp_date'=>'04/15'
					)
			
			);
			$values = $tempValues;
		}//endif
		else {
			echo "real values";
	
			$form 		= $this->_getForm();
			$formValues = $form->getValues();
			$values 	= $formValues;
		}

		//Helpers
		$coUtils		= new ORed_Checkout_Utils();
		$shMachine		= new ORed_Shipping_LabelFactory();

		//$oModel		= new Application_Model_OrderMapper();
		
		//print_r($values);
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++	EMAIL	  ++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//1. send email with order info
		//$this->_sendEmail($values);
		
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++	SAVE USER	 +++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//2. save cust data
		//oc: todo: put password from identity into $values
		$auth 		= Zend_Auth::getInstance();
		$whoAmI 	= $auth->getIdentity();
		//oc: todo: use $whoAmiI as uid;
		$uid 		= $coUtils->createUser($values['shipping1']);

		
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++ CREATE SHIPPING TICKET	 +++++++++++++++++++++++++
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//3. save shipping address
		$origin_id		= 1;//oc: the shippingAddress id of the N+C office
		$destination_id	= $coUtils->createShippingAddress($uid, $values['shipping1']);
		$shType			= $values['shipping2']['sh_type'];
		$shipId			= $shMachine->createLabel($origin_id, $destination_id, $shType);
		
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++	BILLING		 +++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//4. save billing address
		$bid			= $coUtils->createBillingAddress($uid, $values['billing1']);
		
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
		
		$o			= $coUtils->createOrder($uid,$bid,$shipId);
		//oc: todo: check internet connection before making call.
		
		$orderId = $this->_callAuthorizeDotNet($values, $o);
		
		$this->view->orderId	= $orderId;
		$this->view->form 		= $this->_getForm();
	}


}





