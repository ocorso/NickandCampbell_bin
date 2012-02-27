<?php
class Admin_Bootstrap extends Zend_Application_Module_Bootstrap
{
	protected function _initLayouts(){
		Zend_Layout::startMvc();
	}
	protected function _initLibraryAutoloader()
	{
		
		return $this->getResourceLoader()
		->addResourceType('library',
								 	   'library',
									   'library');
	}
// 	protected function _initAutoLoader(){

// 		$this->_resourceLoader = new Zend_Application_Module_Autoloader(array(
// 		                'namespace' => 'Admin',
// 		                'basePath'  => APPLICATION_PATH . '/modules/admin',
// 			));
			
// 			$front = Zend_Controller_Front::getInstance();
// 			$front->addControllerDirectory(APPLICATION_PATH.'/modules/admin/controllers', 'admin');
// 	}
}
