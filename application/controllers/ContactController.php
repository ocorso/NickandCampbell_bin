<?php

class ContactController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_redirector = $this->_helper->getHelper('Redirector');	
    }

    public function indexAction()
    {
        $this->_redirector->gotoUrl('/#/contact/');
    }


}

