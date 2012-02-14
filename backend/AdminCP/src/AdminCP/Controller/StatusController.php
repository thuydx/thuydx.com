<?php
namespace AdminCP\Controller;

use Zend\Mvc\Controller\ActionController,
	AdminCP\Form\ContentStatusForm,
	AdminCP\Model\Business\ContentStatus;

class StatusController extends ActionController
{
    protected $contentStatus;
    
    public function indexAction() 
    {
        return array(
        		'contentStatus' => $this->contentStatus->fetchAll(),
        );
    }
    
    public function addAction()
    {
        // initialize form for add status
        $form = new ContentStatusForm();
        $form->content_status_submit->setLabel('Add Status');
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
        	$formData = $request->post()->toArray();
        	if ($form->isValid($formData)) {
        		$statusName = $form->getValue('status_title');
        
        		$this->contentStatus->addContentStatus($statusName);
        		// Redirect to list of status
        		return $this->redirect()->toRoute('default', array(
        				'controller' => 'admincp-content-status',
        				'action' => 'index',
        		));
        	}
        }
        return array('form' => $form);        
    }
    
    public function editAction()
    {
	    // initialize form for edit status
		$form = new ContentStatusForm();
		$form->content_status_submit->setLabel('Edit Status');
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$formData = $request->post()->toArray();
			if ($form->isValid($formData)) {
				$id = $form->getValue('content_status_id');
				$statusName = $form->getValue('status_title');
				if ($this->contentStatus->getContentStatus($id)) {
					$this->contentStatus->updateContentStatus($id, $statusName);
				}
				// Redirect to list of status
				return $this->redirect()->toRoute('default', array(
				'controller' => 'admincp-content-status',
				'action' => 'index',
				));
			}
		} else {
			$id = $request->query()->get('id', 0);
			if ($id > 0) {
				$form->populate($this->contentStatus->getContentStatus($id));
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
				$this->contentStatus->deleteContentStatus($id);
			}
			// Redirect to list of status
			return $this->redirect()->toRoute('default', array(
					'controller' => 'admincp-content-status',
					'action' => 'index',
			));
		}
		$id = $request->query()->get('id', 0);
		return array('contentStatus' => $this->contentStatus->getContentStatus($id));
    }
    
    public function setContentStatus(ContentStatus $contentStatus)
    {
    	$this->contentStatus = $contentStatus;
    	return $this;
    }    
}