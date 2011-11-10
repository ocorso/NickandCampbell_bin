<?php

class ProductController extends Zend_Controller_Action
{
    		/*****************************************************
			* oc: EXPECTED CATEGORIES FOR PRODUCT QUERIES:
			*
			*	MENS
			*	MENS UNDERWEAR
			*
			*
			//*****************************************************/ 
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
//    	$opts	= array ('gender'=>"mens", 'category'=>'underwear');
//    	$opts	= array ('name'=> 'The Brazil Boxer Brief');

    	
     	//set req
     	$req		= $this->getRequest();
    		
	        
     	//create opts
    	$opts		= array('gender'=>'mens', 'pretty'=>'original-boxer-brief');
		$opts  		= $req->getParam('category') ? 	array_merge($opts, array('category'=>$req->getParam('category'))) : $opts;
		$opts  		= $req->getParam('product') ? 	array_merge($opts, array('pretty'=>$req->getParam('product'))) : $opts;
			
		//get product info since we're ajaxing it in
    	$products = new Application_Model_ProductMapper();
    	$allSizesOfProduct 	= $products->fetchAllWithOptions($opts);
    		
    	//we just need one for most of the info
    	$this->view->product = $allSizesOfProduct[0];

    	//oc: create array of sizes
	    
    	//first get sizing chart
	    $sizes 		= new Application_Model_SizingChartMapper();
	    $sizeArr	= $sizes->fetchAll();
        $sOpts	= array();
       	//loop through what's already in the array of sizes
        foreach ($allSizesOfProduct as $p){
        	if (!array_key_exists($sizeArr[$p->getSize()]['name'], $sOpts)) {
        		//if its not there add it
        		$sOpts[] = $sizeArr[$p->getSize()]['name'];
        	} 
        }

   		//disable layout
    	$layout = $this->_helper->layout();
    	$layout->disableLayout();

        //add to cart test
        $form				= new Application_Form_AddToCart(array('sizes'=>$sOpts));
        
        $this->view->form 	= $form;
    }
	

}

