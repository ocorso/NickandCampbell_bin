<?php
class Zend_View_Helper_DashboardOrRegister extends Zend_View_Helper_Abstract {
	
    public function dashboardOrRegister(){
    	
    	 $auth = Zend_Auth::getInstance();
    	 
    	 //oc: 	1. customer is logged in -> Dashboard goes to shop/account page
    	 //		2. unknown visitor -> register is a link
    	 //		3. unknown visitor at auth/register -> register is just text
    	 //		4. administrator is logged in -> Dashboard link takes user to admin screen.
    	 
        if ($auth->hasIdentity()) {
	        $dashboardUrl 	= $this->view->url(array('controller'=>'admin', 'action'=>'index'));
        	return '<a href="'.$dashboardUrl.'" title="Dashboard">Dashboard</a>';
        } else {
			$registerUrl	= $this->view->url(array('controller'=>'auth', 'action'=>'register'));     	
        	return '<a href="'.$registerUrl.'" title="Register">Register</a>';
        }
    }
}