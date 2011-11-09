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
    		
    		//create opts
    		$opts		= array('gender'=>'mens');
			$opts  		= $req->getParam('category') ? 	array_merge($opts, array('category'=>$req->getParam('category'))) : $opts;
			$opts  		= $req->getParam('product') ? 	array_merge($opts, array('pretty'=>$req->getParam('product'))) : $opts;
			
			//get product info since we're ajaxing it in
    		$pModel	 	= new Application_Model_ProductMapper();
    		$products	= $pModel->fetchAllWithOptions($opts);
    		$this->view->product = $products[0];

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





