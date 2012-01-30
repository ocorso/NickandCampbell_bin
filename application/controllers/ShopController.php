<?php
class ShopController extends Zend_Controller_Action
{
	//reference to product mapper in true O Red fashion
	protected $_m;
	protected $_sizes;
	
    protected $_redirector 		= null;
	protected $_deeplinkBase	= "/#/shop/";
	
    public function init()
    {
    	
		$this->_m 			= new Application_Model_ProductMapper();
		$this->_sizes 		= new Application_Model_SizingChartMapper();
		$this->_redirector 	= $this->_helper->getHelper('Redirector');	
    }

    private function _getSizeOpts($products){
    	 
    	//first get sizing chart
    	$sizes 		= new Application_Model_SizingChartMapper();
    	$sizeArr	= $sizes->fetchAll();
    	$sOpts		= array();
    	//loop through what's already in the array of sizes
    	foreach ($products as $p){
    		if (!array_key_exists($sizeArr[$p->getRef_size()]['name'], $sOpts)) {
    			//if its not there add it
    			$sOpts[] 	= $sizeArr[$p->getRef_size()]['name'];
    			$productIdBySize[$sizeArr[$p->getRef_size()]['name']] = $p->getPid();
    		}
    	}
    	return $sOpts;
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
    		$opts		= array('gender'=>'mens'); //todo: get gender from post vars so that its dynamic
			$opts  		= $req->getParam('category') ? 	array_merge($opts, array('category'=>$req->getParam('category'))) : $opts;
			$opts  		= $req->getParam('pretty') ? 	array_merge($opts, array('pretty'=>$req->getParam('pretty'))) : $opts;
			
			//todo: grab product info from ProductSyles Table
			//		grab size and color info from Product Table
			
			//get product info since we're ajaxing it in
    		$productStyle			= $this->_m->fetchAllWithOptions($opts);
    		print_r($productStyle);
    		$products				= $this->_m->getProductsByStyleId($productStyle[0]->getSid());
    		$productIdBySize		= array();
    		

    		//add to cart form
    		$form		= new Application_Form_AddToCart(array('sizes'=>$sOpts));

    		//load up view
    		$this->view->form 				= $form;
    		$this->view->product 			= $allSizesOfProduct[0];
    		$this->view->productIdBySize	= $productIdBySize;
    		$this->view->href				= 'shop/'.$allSizesOfProduct[0]->gender.'/'.$allSizesOfProduct[0]->category.'/'.$allSizesOfProduct[0]->pretty;
    		$this->view->lrgImgSrc			= 'img/shop/'.$allSizesOfProduct[0]->gender.'/'.$allSizesOfProduct[0]->category.'/large/style-'.$allSizesOfProduct[0]->sid.'.jpg';

    	} else {
    		//figure out where to redirect to
			$deeplink 	= $this->_deeplinkBase." mens/";
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





