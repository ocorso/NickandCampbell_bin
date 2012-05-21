<?php
/**
 *
 * @author Owen Corso
 * @version 1.0
 */

/**
 * Access Control List Helper 
 * 
 */
class ORed_Controller_Helpers_Acl{
    
    /**
     * @var Zend_Acl()
     */
    public $acl;
    
    /**
     * Constructor: initialize Zend_Acl
     * 
     * @return void
     */
    public function __construct ()
    {
    	$this->acl			= new Zend_Acl();
    }
	
    public function setRoles(){
    	$this->acl->addRole(new Zend_Acl_Role('customer'));
    	$this->acl->addRole(new Zend_Acl_Role('staff'));
    	$this->acl->addRole(new Zend_Acl_Role('admin'));
    }
    				
    public function setResources(){
    	$this->acl->add(new Zend_Acl_Resource('home'));
    	$this->acl->add(new Zend_Acl_Resource('view'));
    	$this->acl->add(new Zend_Acl_Resource('edit'));
    	$this->acl->add(new Zend_Acl_Resource('delete'));
    }
	public function setPrivilages()
	{
		$this->acl->allow('customer',null,array('view', 'home'));
		$this->acl->allow('staff',array('view','edit', 'home'));
		
		$this->acl->allow('admin');
	}
	public function setAcl(){
		Zend_Registry::set('acl',$this->acl);
	}
	
    /**
     * Strategy pattern: call helper as broker method
     */
    public function direct ()
    {
        // TODO Auto-generated 'direct' method
    }
}
