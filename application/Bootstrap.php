<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initConfig(){
		
		Zend_Registry::set('config', new Zend_Config($this->getOptions()));
	}
	
	protected function _initDocType(){
		$this->bootstrap('View');
		$view = $this->getResource('View');
		$view->doctype('HTML5');
	}
	protected function _initDatabase()
    {
		$config	= $this->getOptions();
		$db		= Zend_Db::factory(	$config['resources']['db']['adapter'], 
									$config['resources']['db']['params']);
									
		//set default adapter
		Zend_Db_Table::setDefaultAdapter($db);
		Zend_Registry::set("db",$db);
    	
    }//end function
	protected function _initRouter()
    {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();

        // Add some routes
        $mensRoute	= new Zend_Controller_Router_Route(	'shop/mens/:category/:product',
        														array(	'controller'	=> 'shop',
        																'action'		=> 'mens')
        					);
        $womensRoute	= new Zend_Controller_Router_Route(	'shop/womens/:category/:product',
        														array(	'controller'	=> 'shop',
        																'action'		=> 'womens')
        					);
        $router->addRoute(	'mensroute', $mensRoute);
        $router->addRoute(	'womensroute', $womensRoute);

        // Returns the router resource to bootstrap resource registry
        return $router;
    }
    protected function _initSession(){
    	Zend_Session::start();
    }
    
}//end bootstrap

	