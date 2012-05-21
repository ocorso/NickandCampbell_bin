<?php

class OrderController extends Zend_Controller_Action
{

    public function init()
    {
	       //disable layout
    		$layout = $this->_helper->layout();
    		$layout->disableLayout();
    }

    public function indexAction()
    {
	    	//spit out fake data for now
    		$tempData  = file_get_contents('orders.txt', FILE_USE_INCLUDE_PATH);
			//echo $tempData;
    }

    public function infoAction()
    {
			$req		= $this->getRequest();
			$oid		= $req->getParam('oid');
			$oManager	= new Application_Model_OrderMapper();
			$oInfo		= $oManager->getOrderInfoById($oid);
			print_r($oInfo);
			
			//oc: vars for view
			$this->view->oid		= $oid;
			$this->view->order		= $oInfo->order;
			$this->view->shipping	= $oInfo->shipping;
			
    }


}



