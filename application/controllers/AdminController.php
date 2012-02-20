<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
    	$auth = Zend_Auth::getInstance();
    	
    	//
    	if ($auth->hasIdentity()) {
    		// Identity exists; get it
    		$identity = $auth->getIdentity();
    		print_r( $identity);
	    	$layout = $this->_helper->layout();
	    	$layout->setLayout('admin');
	    	$view = $this->view;
	    	$view->headLink()->appendStylesheet('/css/admin-theme/jquery-ui-1.8.16.custom.css');
		 	$view->headLink()->appendStylesheet('/css/admin-theme/dataTable.css');
		 	$view->headLink()->appendStylesheet('/css/admin-theme/dataTable_jui.css');
		 	$view->headScript()->appendFile("/js/libs/jquery-ui-1.8.16.custom.min.js");
			$view->headScript()->appendFile("/js/libs/jquery.dataTables.min.js");
			$view->headScript()->appendFile("/js/site/admin.js");
    	}else{
    		$this->_forward('index', 'auth', 'default', array('baz' => 'bogus'));
    	}
	 	
    }

    public function indexAction()
    {
    	echo "HELLO REGULAR CONTROLLER";
		
    }


}

