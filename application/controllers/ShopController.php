<?php
class ShopController extends Zend_Controller_Action
{

    protected $_redirector 		= null;
	protected $_deeplinkBase	= "/#/shop/";
	
    public function init()
    {
    	
		$this->_redirector = $this->_helper->getHelper('Redirector');	
		
//		$route = new Zend_Controller_Router_Route('section/:cat1/:cat2/:product',
	//	array(	'controller'=>'index','controller'=>'mens'))
    }

    public function indexAction()
    {
		$this->_redirector->gotoUrl($this->_deeplinkBase);
    }

    public function mensAction()
    {
		$req		= $this->getRequest();
    	if($req->isXmlHttpRequest()){
    		
    		//disable layout
    		$layout = $this->_helper->layout();
    		$layout->disableLayout();
    		
    		//get product info since we're ajaxing it in
    		$products = new Application_Model_ProductMapper();
    		$this->view->products = $products->find();
    		
    		echo "this is xml request";
    	} else {
			$deeplink 	= $this->_deeplinkBase;
			$deeplink  .= $req->getParam('category') ? $req->getParam('category')."/" : "";
			$deeplink  .= $req->getParam('product') ? $req->getParam('product')."/" : "";
			
			$this->_redirector->gotoUrl($deeplink);						
    		
    	}
			
    }

    public function womensAction()
    {
		$req		= $this->getRequest();
		$deeplink 	= $this->_deeplinkBase;
		
		$deeplink  .= $req->getParam('category') ? $req->getParam('category')."/" : "";
		$deeplink  .= $req->getParam('product') ? $req->getParam('product')."/" : "";
		
		$this->_redirector->gotoUrl($deeplink);						
        // action body
    }
}





