<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        $layout = $this->_helper->layout();
    	$layout->setLayout('admin');
    }
    // =================================================
    // ================ Workers
    // =================================================
    protected function _handleAuth(){
    	
    	// We're authenticated!
    		
    	
    	ORed_ShoppingCart_Utils::renewSession();
    	
    	
    	// Redirect to the appropriate place
    	$auth 		= Zend_Auth::getInstance();
    	$whoAmI 	= $auth->getIdentity();
    		
    	$db			= Zend_Registry::get("db");
    	$whoCouldIBe= $db->fetchAll($db->select()->from("roles_chart"));
    	print_r($whoCouldIBe);
    	//oc: todo: determine where to redirect based on role (ref_rid)
    	switch($whoAmI->ref_rid){
    		case $whoCouldIBe[0]['rid'] :
    			$this->_helper->redirector('index', 'admin');
    			break;
    		default : $this->_helper->redirector('account', 'shop');
    	}//endswitch
    }
  

    protected function _processAuth($values)
    {
        // Get our authentication adapter and check credentials
        $adapter = $this->_getAuthAdapter();
        $adapter->setIdentity($values['cust_email']); 
        $adapter->setCredential($values['password']);

        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);
        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);
            return true;
        }
        return false;
    }

    protected function _getAuthAdapter()
    {
        
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        
        $authAdapter->setTableName('users')
            ->setIdentityColumn('email')
     //       ->setCredentialTreatment('SHA1(CONCAT(?,salt))')
            ->setCredentialColumn('password');
            
        
        return $authAdapter;
    }
    
    // =================================================
    // ================ Actions
    // =================================================
    public function indexAction()
    {
    	$this->view->isIncorrect = false;
    	 
    	$form = new Application_Form_Login();
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		if ($form->isValid($request->getPost())) {
    			if ($this->_processAuth($form->getValues())) {
    				$this->_handleAuth();
					//oc: fix way we handle auth
    				$this->view->isIncorrect = false;
    			}else
    			$this->view->isIncorrect = true;
    		}//todo: make else
    	}
    	$this->view->form = $form;
    }
    
    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index'); // back to login page
    }

    public function registerAction()
    {
        $form = new Application_Form_Register();
        $request = $this->getRequest();
        if ($request->isPost()) {
	        if ($form->isValid($request->getPost())) {
    	    	echo "isValid";
    	    	//oc: createUser
    	    	$formValues 	= $form->getValues();
    	    	$u 				= ORed_Checkout_Utils::createUser($formValues[0]);
    	    	$uModel			= new Application_Model_UserMapper();
    	    	$uModel->save($u);
    	    	$authOpts 		= array();
    	    	
    	    	//oc: todo: send email confirmation of account creation.
    	    	if ($this->_processAuth($formValues[0])) {
    				$this->_handleAuth();
    	    	}//endif
        	}//endif
        }//endif 
        	 $this->view->form = $form;
    }


}





