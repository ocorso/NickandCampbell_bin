<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initConfig(){
		
		Zend_Registry::set('config', new Zend_Config($this->getOptions()));
	}

	protected function _initDatabase()
    {
		$config	= $this->getOptions();
		$db		= Zend_Db::factory(	$config['resources']['db']['adapter'], 
									$config['resources']['db']['params']);
									
		//set default adapter
		Zend_Db_Table::setDefaultAdapter($db);
		Zend_Registry::set("db",$db);
    	
    }//end function
	
}//end bootstrap

