<?php
class Application_Model_ShippingInfoMapper extends Application_Model_AbstractMapper{
	
	
	public function _init(){
		$this->_tbl = new Application_Model_DbTable_ShippingInfo();
	}

}