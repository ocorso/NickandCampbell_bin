<?php

class OrderController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
       //disable layout
    		$layout = $this->_helper->layout();
    		$layout->disableLayout();
    	//spit out fake data for now
    		$tempData  = file_get_contents('orders.txt', FILE_USE_INCLUDE_PATH);
			//echo $tempData;
			$o = new Application_Model_Order();
			$o->toArray();
    }


}

