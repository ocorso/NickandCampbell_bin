<?php

class OrderController extends Zend_Controller_Action
{

    public function init()
    {
	      
    		$contextSwitch = $this->_helper->getHelper('contextSwitch');
    		$contextSwitch->addActionContext('info', 'json')
    			->initContext();
    }

    public function indexAction()
    {
	    	//spit out fake data for now
    		$tempData  = file_get_contents('orders.txt', FILE_USE_INCLUDE_PATH);
			//echo $tempData;
    }

    public function infoAction()
    {
			$oManager	= new Application_Model_OrderMapper();
			$uManager	= new Application_Model_UserMapper();
			$req		= $this->getRequest();
			$oid		= $req->getParam('oid');
			if ($oid){
				$oInfo		= $oManager->getOrderInfoById($oid);
				$this->view->order		= $oInfo;
			}else {
				$ordersRecords = $oManager->fetchAll();
				$orders	= array();
				
				foreach($ordersRecords as $o){
					/*
					 *    { "mDataProp": "oid" },
    	              { "mDataProp": "total_price" },
    	              { "mDataProp": "customer.name" },
    	              { "mDataProp": "customer.email" },
    	              { "mDataProp": "customer.phone" },
    	              { "mDataProp": "status"}
    	              ]
					 */
					$usr				= new Application_Model_User();
					$uManager->find($o->order->getRef_uid(), $usr);
					
					$tmp 				= new stdClass();
					$tmp->oid			= $o->order->getOid();
					$tmp->total_price 	= $o->order->getAmount();
					$tmp->customer 		= $usr->toArray();
					$tmp->status		= $o->order->getStatus();
					$orders[]			= $tmp;
				}
				//oc: vars for view
				$this->view->orders		= $orders;
				//print_r($orders);
			}
			
			
    }


}



