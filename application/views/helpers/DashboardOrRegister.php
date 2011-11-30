<?php
class Zend_View_Helper_DashboardOrRegister extends Zend_View_Helper_Abstract {
	
    public function dashboardOrRegister(){
    	
    	 $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
	        $dashboardUrl 	= $this->view->url(array('controller'=>'admin', 'action'=>'index'));
        	return '<a href="'.$dashboardUrl.'" title="Dashboard">Dashboard</a>';
        } else {
			$registerUrl	= $this->view->url(array('controller'=>'auth', 'action'=>'register'));     	
        	return '<a href="'.$registerUrl.'" title="Register">Register</a>';
        }
    }
}