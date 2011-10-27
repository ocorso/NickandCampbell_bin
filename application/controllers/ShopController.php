<?php
class ShopController extends Zend_Controller_Action
{
	protected $_redirector = null;
	
    public function init()
    {
		$this->_redirector = $this->_helper->getHelper('Redirector');	
		
//		$route = new Zend_Controller_Router_Route('section/:cat1/:cat2/:product',
	//	array(	'controller'=>'index',''=>''))
    }

    public function indexAction($p1, $p2)
    {
		$this->_redirector->gotoUrl('/#/shop/'.$p1);
        // action body
    }


}

