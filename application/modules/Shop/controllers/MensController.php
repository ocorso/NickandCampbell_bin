<?php

class Shop_MensController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_redirector = $this->_helper->getHelper('Redirector');	
    }

    public function indexAction()
    {
        // action body
    }

    public function underwearAction($p1)
    {
echo $p1;
    }


}



