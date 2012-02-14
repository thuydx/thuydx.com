<?php

namespace AdminCP\Form;

use Zend\Form\Form,
	Zend\Form\Element;

class CategoryForm extends Form
{
	public function init()
	{
	    // set form name
		$this->setName('category');
		
		// create hidden field for input id
		$id = new Element\Hidden('category_id');
		$id->addFilter('Int');
		
		// create category field
		$categoryTitle = new Element\Text('category_title');
		$categoryTitle->setLabel('Category Title ')
			   	->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty');
		
		// create category_description field
		$categoryDescription = new Element\Textarea('category_description');
		$categoryDescription->setLabel('Category Description ')
			   	->setRequired(false)
				->addFilter('StripTags')
				->addFilter('StringTrim');
				//->addValidator('NotEmpty');
		
		// create category field
		$categoryMetaTitle = new Element\Text('category_meta_title');
		$categoryMetaTitle->setLabel('Meta Title')
			   	->setRequired(false)
				->addFilter('StripTags')
				->addFilter('StringTrim');
				//->addValidator('NotEmpty');
		
		// create category field
		$categoryMetaDescription = new Element\Textarea('category_meta_description');
		$categoryMetaDescription->setLabel('Meta Description')
			   	->setRequired(false)
				->addFilter('StripTags')
				->addFilter('StringTrim');
				//->addValidator('NotEmpty');
		
		// create category field
		$categoryMetaKeyword = new Element\Textarea('category_meta_keyword');
		$categoryMetaKeyword->setLabel('Category Keyword ')
			   	->setRequired(false)
				->addFilter('StripTags')
				->addFilter('StringTrim');
				//->addValidator('NotEmpty');
		
		// create category field
		$categoryIcon = new Element\File('category_icon');
		$categoryIcon->setLabel('Category Icon ')
			   	->setRequired(false)
				->addFilter('StripTags')
				->addFilter('StringTrim');
				//->addValidator('NotEmpty');
				
		// create category field
		$categoryPassword = new Element\Password('category_password');
		$categoryPassword->setLabel('Password ')
			   	->setRequired(false)
				->addFilter('StripTags')
				->addFilter('StringTrim');
				//->addValidator('NotEmpty');
				
		// create category field
		$categoryUrl = new Element\Text('general_url');
		$categoryUrl->setLabel('General Url')
			   	->setRequired(false)
				->addFilter('StripTags')
				->addFilter('StringTrim');
				//->addValidator('NotEmpty');
				
		// create category field
		$categoryHideMenu = new Element\Checkbox('hide_form_menu');
		$categoryHideMenu->setLabel('Hide from menu ')
			   	->setRequired(false)
				->addFilter('StripTags')
				->addFilter('StringTrim');
				//->addValidator('NotEmpty');
				
		// create category field
		$categoryOrder = new Element\Text('sort_order');
		$categoryOrder->setLabel('Order ')
			   	->setRequired(false)
				->addFilter('StripTags')
				->addFilter('StringTrim');
				//->addValidator('NotEmpty');
		
		// create submit button
		$submit = new Element\Submit('category_submit');
		$submit->setAttrib('id', 'submitbutton');
		
		// add all element
		$this->addElements(array(
		        	$id, 
		        	$categoryTitle, 
		        	$categoryDescription, 
		        	$categoryMetaTitle,
		        	$categoryMetaDescription,
		        	$categoryMetaKeyword,
		        	$categoryIcon,
		        	$categoryPassword,
		        	$categoryUrl,
		        	$categoryHideMenu,
		        	$categoryOrder, 
		        	$submit));
	}
}
