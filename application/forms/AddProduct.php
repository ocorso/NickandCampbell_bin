<?php

class Application_Form_AddProduct extends Zend_Form
{
	protected $_sizes;
	protected $_categories;
	protected $_gender;
	protected $_ncLabel = array('black', 'select');
	protected $_colors = array('black', 'white', 'gray','red');
	
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
    	$this->setMethod('post')
    		->setAction('/product/add');
    	
    	$filters 	= array('StringTrim', 'StringToLower');
    	
    	//sub forms:
    		//one for product_styles table
    		//one for products table 
    	
    	$productSylesTable		= new Zend_Form_SubForm();
    	$productsTable			= new Zend_Form_SubForm();
    	$productImages			= new Zend_Form_SubForm();

    	// =================================================
    	// ================ Product Styles
    	// =================================================
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
			->setRequired(true)
		//	->addValidator('')
			->setFilters($filters);
		//label
		$label			= new Zend_Form_Element_Select("nclabel");
		$label->setLabel('label')
			->setMultiOptions($this->_ncLabel)
			->setRequired(true)
		//	->addValidator('')
			->setFilters($filters);
		
		//price
		$price			= new Zend_Form_Element_Text("price");
		$price->setLabel('price')
			->setRequired(true)
		//	->addValidator('')
			->setFilters($filters);
		//weight
		$weight			= new Zend_Form_Element_Text("weight");
		$weight->setLabel('weight')
			->setRequired(true)
		//	->addValidator('')
			->setFilters($filters);
		
		
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
    	// =================================================
    	// ================ Products
    	// =================================================
		//color
		$color			= new Zend_Form_Element_Select("color");
		$color->setLabel('color')
			->setMultiOptions($this->_colors)
			->setRequired(true)
		//	->addValidator('')
			->setFilters($filters);
		//sku
		
		//size select
		$size		= new Zend_Form_Element_Select('size');
		$size->setLabel("Size:")
		->setRequired(true)
		->setMultiOptions($this->_sizes);
	
		$productsTable->addElements(array(
			$size,
			$weight,
			$color
		));
    	// =================================================
    	// ================ Product Images
    	// =================================================
    	$thumbImg	= new Zend_Form_Element_File('thumb_img');
    	$thumbImg->setLabel("Thumbnail Image (183x137)");
    	$largeImg	= new Zend_Form_Element_File('large_img');
    	$largeImg->setLabel("Product Detail Image (457x304)");
		
    	$productImages->addElements(array($thumbImg,$largeImg));
		
		
		$this->addSubForms(array($productSylesTable, $productsTable, $productImages));
		
		$submit 	= new Zend_Form_Element_Submit('submit_btn');
		$submit->setLabel('Submit')
		->setAttrib('class', 'btn');
		$this->addElement($submit);
    }


}

