<?php

class Application_Form_AddToCart extends Zend_Form
{
	protected $_sizes;

	public function setSizes(array $sizes){
		$this->_sizes = $sizes;
		return $this;
	}
   
    public function init()
    {
    	
    	$this->setMethod("post")
    		->setAttrib('id', 'add_to_cart_form');
		
    	//size select
    	$size		= new Zend_Form_Element_Select('size');
       	$size->setLabel("Size:")
       		->setRequired(true)
    		->setMultiOptions($this->_sizes);
    	
    	//quantity text input
       $quantity 	= new Zend_Form_Element_Text("quantity");
       $quantity->setLabel('Quantity:')
       		->setValue(1)
       		->addFilter('Digits')
       		->addValidator('Digits')
       		->setRequired(true);

       	$submit 	= new Zend_Form_Element_Submit('add_to_cart_btn');
       	$submit->setLabel('Add to Cart')
       		->setAttrib('class', 'btn');
       	
       	$cartType 	= ORed_Form_Utils::addHid('cart_type','real');
       	$this->addElements(array($size, $quantity, $cartType,$submit));
    }


}

