<?php

class AccountController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
		$layout = $this->_helper->layout();
	    $layout->setLayout('admin');
    }


}

