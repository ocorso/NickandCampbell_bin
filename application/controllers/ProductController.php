<?php

class ProductController extends Zend_Controller_Action
{
	//reference to product mapper in true O Red fashion
	protected $_m;
	protected $_sizes;

	// =================================================
	// ================ Workers
	// =================================================
    public function init()
    {
   		//disable layout
    	$layout = $this->_helper->layout();
    	$layout->disableLayout();
       	$this->_m 		= new Application_Model_ProductMapper();
       	$this->_sizes 	= new Application_Model_SizingChartMapper();
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
    
    // =================================================
    // ================ Actions
    // =================================================
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
			$sOpts				= $this->_getSizeOpts($products);
			$form				= new Application_Form_AddToCart(array('sizes'=>$sOpts));
			
			
			//load up view
			$this->view->form 				= $form;
			$this->view->product 			= $pStyle[0];
			$this->view->href				= 'shop/'.$pStyle[0]->gender.'/'.$pStyle[0]->category.'/'.$pStyle[0]->pretty;
			$this->view->lrgImgSrc			= 'img/shop/'.$pStyle[0]->gender.'/'.$pStyle[0]->category.'/large/style-'.$pStyle[0]->sid.'.jpg';
				
		}else{
	    	if ($req->getParam('gender')) 	$opts['gender']		= $req->getParam('gender');
			if ($req->getParam('category')) $opts['category']	= $req->getParam('category');
			if ($req->getParam('nc_label'))	$opts['label']		= $req->getParam('nc_label');
			if (count($opts) > 0) print_r($opts);
			//get product info since we're ajaxing it in
	    	//$everything = $this->_m->fetchAll();
	    	//$products	= $pMapper->fetchAll
    		print_r($everything);
    		
    	//we just need one for most of the info
    	//$this->view->product = $pStyles[0];
		
    	//oc: create array of sizes
	    
    	//first get sizing chart
	    $sizeArr	= $this->_sizes->fetchAll();
	    
	    //temp
        $sOpts		= array("small", "medium");
       	//loop through what's already in the array of sizes
//         foreach ($pStyles as $p){
//         	if (!array_key_exists($sizeArr[$p->getSize()]['name'], $sOpts)) {
//         		//if its not there add it
//         		$sOpts[] = $sizeArr[$p->getSize()]['name'];
//         	} 
//         }

		}//endif	

    }

    /*
     * This method takes post data and inserts a new product to the catalogue.
     * new record on products table and/or product_styles
     * choice to use existing category or create new category (one to many)
     */
    public function addAction(){
    	
    	//disable layout
    	$layout = $this->_helper->layout();
    	$layout->disableLayout();
    	
    	//todo gather existing products to know what categories to make a select boxes from
    	
		//sizes select box
    	//first get sizing chart
    	
    	$sizeArr	= $this->_sizes->fetchAll();
		$sOpts		= array();
		foreach($sizeArr as $size){
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


}



