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
	}//end function 
	
	public function getShippingOpts(){
		$pricesById = ORed_Checkout_Utils::calcShipping();
		return array(2=>	"Express Mail 5-7 Business Days $4.95",	
								4=>"Priority Mail 3-4 Business Days $6.95",
								9=>"First Class 1-2 Business Days $10.95"
		);
	}
}