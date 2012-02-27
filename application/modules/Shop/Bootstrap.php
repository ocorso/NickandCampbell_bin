<?php

//require_once ('library/Zend/Application/Module/Bootstrap.php');

class Shop_Bootstrap extends Zend_Application_Module_Bootstrap {
	
  protected function _initLibraryAutoloader()
	{
		return $this->getResourceLoader()
					->addResourceType('library',
							 	   'library',
								   'library');
	}
}

?>