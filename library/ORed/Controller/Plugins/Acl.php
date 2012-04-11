<?php
class ORed_Controller_Plugins_Acl extends Zend_Controller_Plugin_Abstract
{
	public function preDispatch(Zend_Controller_Request_Abstract $req){
		
		$acl 		= Zend_Registry::get('acl');
		$usersNs 	= new Zend_Session_NameSpace('members');

		if( $usersNs->userType =="")	$roleName = 'customer';
		else 					 		$roleName = $userType;
		
		$privilageName 	= $req->getActionName();
		
		if(!$acl->isAllowed($roleName,null,$privilageName)){
			
			//$req->setControllerName('Error');
			//$req->setActionName('Error');
		
		}
	}
}