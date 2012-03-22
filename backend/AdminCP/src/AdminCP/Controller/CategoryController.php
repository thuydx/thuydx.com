<?php
namespace AdminCP\Controller;

use Zend\Mvc\Controller\ActionController,
	AdminCP\Form\CategoryForm,
	AdminCP\Model\Business\Category,
    Zend\View\Model\ViewModel;

class CategoryController extends ActionController
{
	protected $category;

	public function indexAction()
	{
		return new ViewModel(array(
	            'categories' => $this->category->fetchAll(),
	    ));
	}
	
	public function addAction()
	{
	    // initialize form for add category
	    $form = new CategoryForm();
	    $form->category_submit->setLabel('Add Category');
	    
	    $request = $this->getRequest();
	    
	    if ($request->isPost()) {
	    	$formData = $request->post()->toArray();
	    	if ($form->isValid($formData)) {
	    	    $data = array(
    	            'title' 			=> $formData['category_title'],
    	            'description' 		=> $formData['category_description'],
    	            'metaTitle'			=> $formData['category_meta_title'],
    	            'metaDiscription' 	=> $formData['category_meta_description'], 
    	            'metaKeyword' 		=> $formData['category_meta_keyword'],
    	            'icon' 				=> $formData['category_icon'],
    	            'password' 			=> $formData['category_password'], 
    	            'visit' 			=> $formData['category_visit'],
    	            'contentCount' 		=> $formData['content_count'], 
    	            'generalUrl' 		=> $formData['general_url'] ,
    	            'hideFromMenu' 		=> $formData['hide_form_menu'], 
    	            'sortOrder'			=> $formData['sort_order'],      
	    	    );
	    	    	    	    
	    
	    		$this->category->addCategory($data);
	    		// Redirect to list of category
	    		return $this->redirect()->toRoute('default', array(
	    				'controller' => 'admincp-category',
	    				'action' => 'index',
	    		));
	    	}
	    }
	    return array('form' => $form);	    
	}
	
	public function editAction()
	{
	    // initialize form for edit category
	    $form = new CategoryForm();
	    $form->category_submit->setLabel('Edit Category');
	    
	    $request = $this->getRequest();
	    
	    if ($request->isPost()) {
	    	$formData = $request->post()->toArray();
	    	if ($form->isValid($formData)) {
	    		$id = $form->getValue('category_id');
	    		$data = array(
	    				'title' 			=> $formData['category_title'],
	    				'description' 		=> $formData['category_description'],
	    				'metaTitle'			=> $formData['category_meta_title'],
	    				'metaDiscription' 	=> $formData['category_meta_description'],
	    				'metaKeyword' 		=> $formData['category_meta_keyword'],
	    				'icon' 				=> $formData['category_icon'],
	    				'password' 			=> $formData['category_password'],
	    				'visit' 			=> $formData['category_visit'],
	    				'contentCount' 		=> $formData['content_count'],
	    				'generalUrl' 		=> $formData['general_url'] ,
	    				'hideFromMenu' 		=> $formData['hide_form_menu'],
	    				'sortOrder'			=> $formData['sort_order'],
	    		);
	    		
	    		if ($this->category->getCategory($id)) {
	    			$this->category->updateCategory($id, $data);
	    		}
	    		// Redirect to list of category
	    		return $this->redirect()->toRoute('default', array(
	    				'controller' => 'admincp-category',
	    				'action' => 'index',
	    		));
	    	}
	    } else {
	    	$id = $request->query()->get('id', 0);
	    	if ($id > 0) {
	    	    $category = $this->category->getCategory($id);
	    	    if ($category) {
	    	        $form->populate($category->getArrayCopy());
	    	    }
	    	}
	    }
	    return new ViewModel(array('form' => $form));	    
	}
	
	public function deleteAction()
	{
	    $request = $this->getRequest();
	    if ($request->isPost()) {
	    	$del = $request->post()->get('del', 'No');
	    	if ($del == 'Yes') {
	    		$id = $request->post()->get('id');
	    		$this->category->deleteCategory($id);
	    	}
	    	// Redirect to list of category
	    	return $this->redirect()->toRoute('default', array(
	    			'controller' => 'admincp-category',
	    			'action' => 'index',
	    	));
	    }
	    $id = $request->query()->get('id', 0);
	    return new ViewModel(array('category' => $this->category->getCategory($id)));	    
	}
	
	public function setCategory(Category $category)
	{
		$this->category = $category;
		return $this;
	}	
}	