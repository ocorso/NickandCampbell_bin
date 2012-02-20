<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initConfig(){
		
		Zend_Registry::set('config', new Zend_Config($this->getOptions()));
		
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
    
    protected function _initLayouts(){
    	Zend_Layout::startMvc();
    }

	protected function _initRouter()
    {
    	
        $front = Zend_Controller_Front::getInstance();
		
        $baseUrl 	= isset ($_ENV["HTTPS"]) ? 'https://'.$_SERVER["HTTP_HOST"] : 'http://'.$_SERVER["HTTP_HOST"];
        $front->setBaseUrl($baseUrl);
    	
        $router = $front->getRouter();
        $config = Zend_Registry::get('config', 'production');
        $router->addConfig($config, 'routes');
        
        // Add some routes
        $sitemapRoute	= new Zend_Controller_Router_Route(	'sitemap',
        														array(	'controller'	=> 'index',
        																'action'		=> 'sitemap')
        					);
   		//oc: um i guess we don't have this yet.
        $privacyRoute	= new Zend_Controller_Router_Route(	'privacy',
        														array(	'controller'	=> 'index',
        																'action'		=> 'privacy')
        					);
        $returnsRoute	= new Zend_Controller_Router_Route(	'returns',
        														array(	'controller'	=> 'index',
        																'action'		=> 'returns')
        					);
        $shippingRoute	= new Zend_Controller_Router_Route(	'shipping',
        														array(	'controller'	=> 'index',
        																'action'		=> 'shipping')
        					);
        $mensRoute	= new Zend_Controller_Router_Route(	'shop/mens/:category/:pretty',
        														array(	'controller'	=> 'shop',
        																'action'		=> 'mens')
        					);
        $womensRoute	= new Zend_Controller_Router_Route(	'shop/womens/:category/:pretty',
        														array(	'controller'	=> 'shop',
        																'action'		=> 'womens')
        					);
        					
        
        $router->addRoute(	'returnsroute', $returnsRoute);
        $router->addRoute(	'privacyroute', $privacyRoute);
        $router->addRoute(	'sitemaproute', $sitemapRoute);
        $router->addRoute(	'shippingroute', $shippingRoute);
        $router->addRoute(	'mensroute', $mensRoute);
        $router->addRoute(	'womensroute', $womensRoute);
		
        // Returns the router resource to bootstrap resource registry
        return $router;
    }
    protected function _initSession(){
    	Zend_Session::start();
    }
    
    protected function _initPlaceholders()
    {
        $this->bootstrap('View');
        $view = $this->getResource('View');
        $view->doctype('HTML5');
 
        // Set the initial title and separator:
        $view->headTitle('Nick + Campbell | Mens Underwear | NYC')
             ->setSeparator(' :: ')
             ->append(APPLICATION_ENV);
 
        // Set the initial stylesheet:
        $view->headLink()->prependStylesheet('/css/style.css');

    	// Set the initial JS to load:
    	$view->headScript()->appendFile("/js/libs/jquery.hoverIntent.minified.js");
    	$view->headScript()->appendFile("/js/libs/jquery.easing.1.3.js");
    	$view->headScript()->appendFile("/js/libs/swfobject.js");
		$view->headScript()->appendFile("/js/libs/plugins.js");
		$view->headScript()->appendFile("/js/site/mainController.js");
		$view->headScript()->appendFile("/js/site/shopController.js");
		$view->headScript()->appendFile("/js/site/campaignController.js");
		
    }
}//end bootstrap

	