<?php
class ORed_Form_Utils{
	
	/**
	* Add Hidden Element
	* @param $field
	* @param value
	* @return nothing - adds hidden element
	* */
	public function addHid($field, $value){
		$hiddenIdField = new Zend_Form_Element_Hidden($field);
		$hiddenIdField->setValue($value)
		->removeDecorator('label')
		->removeDecorator('HtmlTag');
		return $hiddenIdField;
	}
	
	public function getSizeOpts($products, $sizes){
	
		//first get sizing chart
		$sOpts			= array();
		$sizeNameToPid	= array();
		
		//loop through what's already in the array of sizes
		foreach ($products as $p){
			if (!array_key_exists($sizes[$p->getRef_size()]['name'], $sOpts) && $p->getSku() > 0) {
				//if its not there add it
				$sOpts[] 	= $sizes[$p->getRef_size()]['name'];
				$sizeNameToPid[$sizes[$p->getRef_size()]['name']] = $p->getPid();
			}
		}
		$returnObj 					= new stdClass();
		$returnObj->sOpts 			= $sOpts;
		$returnObj->sizeNameToPid 	= $sizeNameToPid;
		
		return $returnObj;
	}
}