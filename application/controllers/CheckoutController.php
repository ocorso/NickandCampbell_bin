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
		$view 				= $this->view;
		$this->_form 		= new Application_Form_Checkout();
		$this->_devEmail	= 'owen@nickandcampbell.com';
		$view->headScript()->appendFile("/js/site/checkout.js");
		$this->_redirector 	= $this->_helper->getHelper('Redirector');
	}
	protected function _checkMessagesForValidCheckout(){
		$messages	= $this->_helper->flashMessenger->getMessages();
		if (count($messages)) {
			foreach ($messages as $message){ if ($message == $this->_chaChing) return true;}
		}//endif		
	}//end function

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
		$mail->send();
		//echo $body;
	}
	
	// =================================================
	// ================ Handlers
	// =================================================
	/**
	 * 
	 * This is the method where the checkout magic happens
	 * the formValues are used to 
	 * create a new user in db
	 * create a new shipping address in db
	 * create a new billing address in db
	 * create a new shipping ticket in db
	 * create a new order in db
	 * make an API call to authorize.net
	 * send a confirmation email
	 * 
	 * @param unknown_type $formValues
	 */
	protected function _handleCheckout($values){
		
		$orderId 			= 69;

		//Helpers
		$coUtils		= new ORed_Checkout_Utils();
		$anet			= new ORed_Checkout_ANet();
		$shMachine		= new ORed_Shipping_LabelFactory();
		
print_r($values);
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
		$origin_id		= 1;	//oc: the shippingAddress id of the N+C office
		$destination_id	= $coUtils->createShippingAddress($uid, $values['shipping1']);
		$shType			= $values['shipping2']['sh_type'];
		$shippingTicket	= $shMachine->createLabel($origin_id, $destination_id, $shType);
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++	BILLING		 +++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		$bid			= $coUtils->createBillingAddress($uid, $values['billing1']);
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++	CREATE ORDER	++++++++++++++++++++++++++++++
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		$o			= $coUtils->createOrder($uid,$bid,$shippingTicket->getShipping_id());
		
		$anet_trans_id = $anet->authAndCapture($values, $o, $shippingTicket);
		$o->setAnet_id($anet_trans_id);
		
		return array('orderId'=>$orderId, );
	}

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
				
				$checkoutResponse = $this->_handleCheckout($form->getValues());
				
				// 
				$this->_helper->redirector('transaction-results', 'checkout', 'default', $checkoutResponse);
			
			
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
		//disable layout
		$layout = $this->_helper->layout();
		$layout->disableLayout();
		
		$orderId =	$this->_handleCheckout(Application_Model_SiteModel::$TEMP_CHECKOUT);
		echo "Order id: $orderId";
	}


	public function transactionResultsAction()
	{	
		//
		$req					= $this->getRequest();
		$orderId				= $req->getParam('orderId');
		$this->view->isGet 		=  $this->getRequest()->isGet();
		$this->view->orderId	= $orderId;
	}
}