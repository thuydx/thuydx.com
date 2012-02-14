<?php

namespace AdminCP\Form;

use Zend\Form\Form,
	Zend\Form\Element;

class ContentStatusForm extends Form
{
	public function init()
	{
	    // set form name
		$this->setName('content_status');
		
		// create hidden field for input id
		$id = new Element\Hidden('content_status_id');
		$id->addFilter('Int');
		
		// create content type name field
		$statusTitle = new Element\Text('status_title');
		$statusTitle->setLabel('Status Name ')
			   	->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty');
		
		// create submit button
		$submit = new Element\Submit('content_status_submit');
		$submit->setAttrib('id', 'submitbutton');
		
		// add all element
		$this->addElements(array($id, $statusTitle, $submit));
	}
}