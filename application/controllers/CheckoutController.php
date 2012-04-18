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
		$cartUtils		= new ORed_ShoppingCart_Utils();
		$coUtils		= new ORed_Checkout_Utils();
		$anet			= new ORed_Checkout_ANet();
		$shMachine		= new ORed_Shipping_LabelFactory();
		
//print_r($values);
		
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
		$taxable		= Application_Model_SiteModel::$ORIGIN_STATE == $values['shipping1']['state'] ? 1 : 0;
		$shippingTicket	= $shMachine->createLabel($origin_id, $destination_id, $shType, $taxable);
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++	BILLING		 +++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		$bid			= $coUtils->createBillingAddress($uid, $values['billing1']);
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++	CREATE ORDER	++++++++++++++++++++++++++++++
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		$o				= $coUtils->createOrder($uid,$bid,$shippingTicket);
		$anet_response 	= $anet->authAndCapture($values, $o, $shippingTicket);

		//oc TODO gracefully handle all types of responses.
		switch ($anet_response->response_code){
			case 1 : //approved, great!
				echo "trans id: ".$anet_response->transaction_id;
				
				//save post order cart
				$cartUtils->movePreToPost($o->getOid(), $o->getRef_uid());
				
				//prepare the order for updating
				$o->setAnet_id($anet_response->transaction_id);
				$o->setStatus(Application_Model_SiteModel::$ORDER_STATUS[2]);
				$o->setDetails($anet_response->response_reason_text);
				break;
				
			case 2 : //declined, uh oh!
				echo "\ndeclined<br/>";
				
				//prepare the order for updating
				$o->setStatus(Application_Model_SiteModel::$ORDER_STATUS[5]);
				$o->setDetails($anet_response->response_reason_text);
				break;
			
			case 3 : //error, wtf!
				echo "\nerror<br/>";
				
				//prepare the order for updating
				$o->setStatus(Application_Model_SiteModel::$ORDER_STATUS[5]);
				$o->setDetails($anet_response->response_reason_text);
				break;
				
			case 4 : //held for review, hmmmmmm!
				echo "\nheld for review<br/>";
				
				//prepare the order for updating
				$o->setStatus(Application_Model_SiteModel::$ORDER_STATUS[5]);
				$o->setDetails($anet_response->response_reason_text);
				break;
				
			default : echo "unknown response code.";
				$o->setStatus(Application_Model_SiteModel::$ORDER_STATUS[5]);
				$o->setDetails($anet_response->response_reason_text);
					
		}//endswitch
		
		$tbl			= new Application_Model_DbTable_Order();
		$where 			= $tbl->getAdapter()->quoteInto('oid = ?', $o->getOid());
		$tbl->update($o->toArray(), $where);
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//++++++++++++++++++++++	CONFIRMATION EMAIL	  ++++++++++++++++++++++++
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//$this->_sendEmail($values);
		
		return array('orderId'=>$o->getOid());
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
		//todo redirect to https if we're on production
		//if (!isset ($_ENV["HTTPS"]) && $_SERVER["HTTP_HOST"] != 'nc.dev')    	$this->_redirector->gotoUrl("https://".$_SERVER["SERVER_NAME"]."/checkout/");
		 
		$req		= $this->getRequest();
		$form		= $this->_getForm();

		if($this->getRequest()->isPost()){
			
			if($form->isValid($req->getPost())){
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
		$shMachine 				= new ORed_Shipping_LabelFactory();
		$this->view->shipping	= $shMachine->getShippingArr();
		$this->view->isGet 		= $req->isGet();
		$this->view->form 		= $form;
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
		$layout = $this->_helper->layout();
	    $layout->setLayout('admin');
		$req					= $this->getRequest();
		$orderId				= $req->getParam('orderId');
		$this->view->isGet 		= $this->getRequest()->isGet();
		$this->view->orderId	= $orderId;
	}
}