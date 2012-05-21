<?php

class Application_Model_AbstractMapper{
	
	protected $_tbl;
	protected function _init(){}//oc: need to extend this
	public function __construct(){ $this->_init();}
	public function find($id, Application_Model_AbstractModel $vo){
		$result = $this->_tbl->find($id);
		if (0 == count($result)) return;
		
		$row = $result->current();
		$vo->setOptions($row->toArray());
	}
}