<?php
namespace AdminCP\Controller;

use Zend\Mvc\Controller\ActionController,
	AdminCP\Form\ContentTypeForm,
	AdminCP\Model\Business\ContentType,
    Zend\View\Model\ViewModel;

class TypeController extends ActionController
{
	protected $contentType;

	public function indexAction()
	{
	     return new ViewModel(array(
	            'contentType' => $this->contentType->fetchAll(),
	    ));
	}

	public function addAction()
	{
	    // initialize form for add content type
		$form = new ContentTypeForm();
		$form->content_type_submit->setLabel('Add Content Type');
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$formData = $request->post()->toArray();
			if ($form->isValid($formData)) {
				$typeName = $form->getValue('content_type_name');
				$typeDiscription = $form->getValue('content_type_description');
				
				$this->contentType->addContentType($typeName, $typeDiscription);
				// Redirect to list of albums
				return $this->redirect()->toRoute('default', array(
						'controller' => 'admincp-content-type',
						'action' => 'index',
				));
			}
		}
		return array('form' => $form);
	}

	public function editAction()
	{
	    // initialize form for edit content type
		$form = new ContentTypeForm();
		$form->content_type_submit->setLabel('Edit Content Type');
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$formData = $request->post()->toArray();
			if ($form->isValid($formData)) {
				$id = $form->getValue('content_type_id');
				$typeName = $form->getValue('content_type_name');
				$typeDiscription = $form->getValue('content_type_description');
				if ($this->contentType->getContentType($id)) {
					$this->contentType->updateContentType($id, $typeName, $typeDiscription);
				}
				// Redirect to list of content type
				return $this->redirect()->toRoute('default', array(
				'controller' => 'admincp-content-type',
				'action' => 'index',
				));
			}
		} else {
			$id = $request->query()->get('id', 0);
			if ($id > 0) {
			    $content = $this->contentType->getContentType($id);
			    if ($content) {
			        $form->populate($content->getArrayCopy());
			    }
			}
		}
		return array('form' => $form);
	}

	public function deleteAction()
	{
		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->post()->get('del', 'No');
			if ($del == 'Yes') {
				$id = $request->post()->get('id');
				$this->contentType->deleteContentType($id);
			}
			// Redirect to list of content type
			return $this->redirect()->toRoute('default', array(
					'controller' => 'admincp-content-type',
					'action' => 'index',
			));
		}
		$id = $request->query()->get('id', 0);
		return array('contentType' => $this->contentType->getContentType($id));
	}
	
	public function setContentType(ContentType $contentType)
	{
		$this->contentType = $contentType;
		return $this;
	}
}