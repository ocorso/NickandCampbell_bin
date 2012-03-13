<?php
class ShopController extends Zend_Controller_Action
{

    protected $_m = null;

    protected $_sizes = null;

    protected $_redirector = null;

    protected $_deeplinkBase = '/#/shop/';

    public function init()
    {
    	
		$this->_m 			= new Application_Model_ProductMapper();
		$sizeMapper			= new Application_Model_SizingChartMapper();
       	$this->_sizes 		= $sizeMapper->fetchAll();
       	$this->_redirector 	= $this->_helper->getHelper('Redirector');	
    }

    public function indexAction()
    {
		$this->_redirector->gotoUrl($this->_deeplinkBase);
    }

    public function mensAction()
    {
		$req		= $this->getRequest();
		print_r($req);
    	if($req->isXmlHttpRequest()){
    		
    		//disable layout
    		$layout = $this->_helper->layout();
    		$layout->disableLayout();
    		
    		$opts['pretty']		= $req->getParam('pretty');
	    	$pStyle 			= $this->_m->fetchAllWithOptions($opts);
			$sid				= $pStyle[0]->getSid();
			$products			= $this->_m->getProductsByStyleId($sid);
			
			//add to cart form
			$sizes				= $this->_sizes;
			$sObj				= ORed_Form_Utils::getSizeOpts($products, $sizes);
			$addToCartForm		= new Application_Form_AddToCart(array('sizes'=>$sObj->sOpts));
			
			//load up view
			$this->view->addToCartForm		= $addToCartForm;
			$this->view->product 			= $pStyle[0];
			$this->view->href				= 'shop/'.$pStyle[0]->gender.'/'.$pStyle[0]->category.'/'.$pStyle[0]->pretty;
			$this->view->lrgImgSrc			= 'img/shop/'.$pStyle[0]->gender.'/'.$pStyle[0]->category.'/large/style-'.$pStyle[0]->sid.'.jpg';
			$this->view->sizeNameToPid		=  $sObj->sizeNameToPid;
			
    	} else {
    		//figure out where to redirect to
			$deeplink 	= $this->_deeplinkBase."mens/";
			$deeplink  .= $req->getParam('category') ? $req->getParam('category')."/" : "";
			$deeplink  .= $req->getParam('pretty') ? $req->getParam('pretty')."/" : "";
			
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







