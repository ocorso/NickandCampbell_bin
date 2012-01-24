<?php

class Application_Form_AddProduct extends Zend_Form
{
	protected $_sizes;
	protected $_categories;
	protected $_gender;
	protected $_ncLabel = array('black', 'select');
	
	public function setSizes(array $sizes){
		$this->_sizes = $sizes;
		return $this;
	}
	public function setCategories(array $sizes){
		$this->_categories = $sizes;
		return $this;
	}
	public function setGender(array $sizes){
		$this->_gender = $sizes;
		return $this;
	}
	
    public function init()
    {
    	$filters 	= array('StringTrim', 'StringToLower');
    	
    	//sub forms:
    		//one for product_styles table
    		//one for products table 
    	
    	$productSylesTable		= new Zend_Form_SubForm();
    	$productsTable			= new Zend_Form_SubForm();
		
    	//Product Name
		$productName			= new Zend_Form_Element_Text("product_name");
		$productName->setLabel('Product Name')
			->setRequired(true)
			->setFilters($filters);
    	
		//Style Id
// 		$sid			= new Zend_Form_Element_Text("sid");
// 		$sid->setLabel('Style Id')
// 			->setRequired(true)
// 			->setFilters($filters);
		
			//pretty
				//computed from productName.
				
		//description1
		$description1			= new Zend_Form_Element_Text("description1");
		$description1->setLabel('Description 1')
		//	->setRequired(true)
		//	->addValidator('')
			->setFilters($filters);
		//description2
		$description2			= new Zend_Form_Element_Text("description2");
		$description2->setLabel('Description 2')
		//	->setRequired(true)
		//	->addValidator('')
			->setFilters($filters);
		
		//campaign
		$campaign			= new Zend_Form_Element_Text("campaign");
		$campaign->setLabel('campaign')
		//	->setRequired(true)
		//	->addValidator('')
			->setFilters($filters);
		//label
		$label			= new Zend_Form_Element_Select("nclabel");
		$label->setLabel('label')
			->setMultiOptions($this->_ncLabel)
		//	->setRequired(true)
		//	->addValidator('')
			->setFilters($filters);
		
		//weight
		
		//price
		//pid
		//ref_size
		//color
		//sku
		
		//size select
		$size		= new Zend_Form_Element_Select('size');
		$size->setLabel("Size:")
		->setRequired(true)
		->setMultiOptions($this->_sizes);
		//gender select
		$gender		= new Zend_Form_Element_Select('gender');
		$gender->setLabel("Gender:")
		->setRequired(true)
		->setMultiOptions($this->_gender);
    	//category
		$category			= new Zend_Form_Element_Select("category");
		$category->setLabel('Category')
			->setRequired(true)
			->setFilters($filters)
			->setMultiOptions($this->_categories);
			
		$productSylesTable->addElements(array(
			$productName, 
			$description1,
			$description2,
			$campaign,
			$label,
			$gender,
			$category
		));
		$productsTable->addElements(array($size));
		$this->addSubForms(array($productSylesTable, $productsTable));
    }


}

