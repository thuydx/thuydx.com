<?php

namespace AdminCP\Form;

use Zend\Form\Form,
	Zend\Form\Element;
class ContentTypeForm extends Form
{
	public function init()
	{
	    // set form name
		$this->setName('content_type');
		
		// create hidden field for input id
		$id = new Element\Hidden('content_type_id');
		$id->addFilter('Int');
		
		// create content type name field
		$typeName = new Element\Text('content_type_name');
		$typeName->setLabel('Type Name')
			   	->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty');
		
		// create content type description
		$typeDescription = new Element\Text('content_type_description');
		$typeDescription->setLabel('Description')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim');
				//->addValidator('NotEmpty');
		
		// create submit button
		$submit = new Element\Submit('content_type_submit');
		$submit->setAttrib('id', 'submitbutton');
		
		// add all element
		$this->addElements(array($id, $typeName, $typeDescription, $submit));
	}
}