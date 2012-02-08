<?php

class ProductController extends Zend_Controller_Action
{

    protected $_m = null;

    protected $_sizes = null;

    public function init()
    {
   		//disable layout
    	$layout = $this->_helper->layout();
    	$layout->disableLayout();
       	$this->_m 		= new Application_Model_ProductMapper();
       	$sizeMapper		= new Application_Model_SizingChartMapper();
       	$this->_sizes 	= $sizeMapper->fetchAll();
    }

    public function indexAction()
    {

     	//set req
     	$req		= $this->getRequest();
	        
     	//create opts
     	$opts		= array();
     	//if we have a pretty, emulate the product ajax call
		if ($req->getParam('pretty')){
			
			
			$opts['pretty']		= $req->getParam('pretty');
	    	$pStyle 			= $this->_m->fetchAllWithOptions($opts);
			$sid				= $pStyle[0]->getSid();
			$products			= $this->_m->getProductsByStyleId($sid);
			
			//add to cart form
			$sizes				= $this->_sizes;
			$sObj				= ORed_Form_Utils::getSizeOpts($products, $sizes);
			$form				= new Application_Form_AddToCart(array('sizes'=>$sObj->sOpts));
			
			//load up view
			$this->view->form 				= $form;
			$this->view->product 			= $pStyle[0];
			$this->view->href				= 'shop/'.$pStyle[0]->gender.'/'.$pStyle[0]->category.'/'.$pStyle[0]->pretty;
			$this->view->lrgImgSrc			= 'img/shop/'.$pStyle[0]->gender.'/'.$pStyle[0]->category.'/large/style-'.$pStyle[0]->sid.'.jpg';
			$this->view->sizeNameToPid		=  $sObj->sizeNameToPid;
		}else{
	    	if ($req->getParam('gender')) 	$opts['gender']		= $req->getParam('gender');
			if ($req->getParam('category')) $opts['category']	= $req->getParam('category');
			if ($req->getParam('nc_label'))	$opts['label']		= $req->getParam('nc_label');
			if (count($opts) > 0) print_r($opts);
			//get product info since we're ajaxing it in
	    	$everything = $this->_m->fetchAll();
	    	//$products	= $this->_m->fetchAll();
    		print_r($everything);
 

		}//endif	

    }

    public function addAction()
    {
    	
    	//disable layout
    	$layout = $this->_helper->layout();
    	$layout->disableLayout();
    	
    	//todo gather existing products to know what categories to make a select boxes from
    	
		//sizes select box
    	//first get sizing chart
    	
    	//$sizeArr	= $this->_sizes->fetchAll();
		$sOpts		= array();
		foreach($this->_sizes as $size){
			$sOpts[] = $size['name'];
		}
    	$opts 		= array(
    		'sizes'=>$sOpts,
    		'categories'=>array('underwear', 'jackets', 'ready to wear'),
    		'gender'=>array('male','female')
    	);
		//gender select box
		//categories select box
		//
	//	print_r($opts);
        $form				= new Application_Form_AddProduct($opts);
        $this->view->form 	= $form;
		$this->view->data 	= $this->_m->fetchAll();
        //take post 
    }

    public function listProductsAction()
    {
        $obj				= new stdClass();
        $obj->products 		= $this->_m->fetchAll();
        $this->view->json	= json_encode($obj);
    }


}





