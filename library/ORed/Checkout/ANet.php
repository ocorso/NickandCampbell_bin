<?php
/**
 * 
 * This class acts as a proxy to the Authorize.net sdk and the main web app
 * It takes all the info surrounding the checkout form, the newly created order, and shipping ticket
 * and carefully feeds it into a value object to post to authorize.net
 * 
 * additionally, it handles the response
 * @author Owen Corso
 *
 */
class ORed_Checkout_ANet{
	
	public function authAndCapture($data, Application_Model_Order $order, Application_Model_ShippingInfo $shipping){
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
		*
		* x_line_item
		*
		* x_line_item=item1<|>golf balls<|><|>2<|>18.95<|>Y&x_line_item=item2<|>golf bag<|>Wilson golf carry bag, red<|>1<|>39.99<|>Y&x_line_item=item3<|>book<|>Golf for Dummies<|>1<|>21.99<|>Y&
		*/
		//	require_once 'ANet/AuthorizeNet.php';
		$billingAddress 	= $data['billing1']['addr1'].($data['billing1']['addr2'] != "" ? " ".$data['billing1']['addr2'] : "");
		$shippingAddress 	= $data['shipping1']['addr1'].($data['shipping1']['addr2'] != "" ? " ".$data['shipping1']['addr2'] : "");
		
		$fields				= array(
											'version'		=> 3.1,
										'ship_to_first_name'=> $data['shipping1']['cust_first_name'],
										'ship_to_last_name'	=> $data['shipping1']['cust_last_name'],
										'ship_to_address'	=> $shippingAddress,
										'ship_to_city'		=> $data['shipping1']['city'],
										'ship_to_state'		=> $data['shipping1']['state'],
										'ship_to_zip'		=> $data['shipping1']['zip'],
										'ship_to_country'	=> $data['shipping1']['country'],
											'first_name'	=> $data['shipping1']['cust_first_name'],
											'last_name'		=> $data['shipping1']['cust_last_name'],
											'phone'			=> $data['shipping1']['cust_phone'],
											'email'			=> $data['shipping1']['cust_email'],
											'amount'		=> $data['subtotal'],
											'card_num'		=> $data['billing2']['card_num'],
											'exp_date'		=> $data['billing2']['exp_date'],
											'card_code'		=> $data['billing2']['ccv'],
											'invoice_num'	=> $order->getOid(),
											'description'	=> $order->getDetails(),
											'address'		=> $billingAddress,
											'city'			=> $data['billing1']['city'],
											'state'			=> $data['billing1']['state'],
											'zip'			=> $data['billing1']['zip'],
											'country'		=> $data['billing1']['country'],
											'cust_id'		=> $order->getRef_uid(),
											'tax'			=> $order->getTotal_tax(),
											'freight'		=> $shipping->getShipping_cost()
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
}