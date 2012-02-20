<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        	$view = $this->view;
    	$view->headLink()->appendStylesheet('/css/admin-theme/jquery-ui-1.8.16.custom.css');
	 	$view->headLink()->appendStylesheet('/css/admin-theme/dataTable.css');
	 	$view->headLink()->appendStylesheet('/css/admin-theme/dataTable_jui.css');
	 	$view->headScript()->appendFile("/js/libs/jquery-ui-1.8.16.custom.min.js");
		$view->headScript()->appendFile("/js/libs/jquery.dataTables.min.js");
		$view->headScript()->appendFile("/js/site/admin.js");
	 	
    }

    public function indexAction()
    {
       echo "HELLO MODULE";
    }


}

