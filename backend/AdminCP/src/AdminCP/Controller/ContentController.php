<?php
namespace AdminCP\Controller;

use Zend\Mvc\Controller\ActionController,
	AdminCP\Form\ContentForm,
	AdminCP\Model\Business\Content,
	AdminCP\Model\Business\ContentType,
	AdminCP\Model\Business\ContentStatus,
	AdminCP\Model\Business\Category,
    Zend\View\Helper\ViewModel;

class ContentController extends ActionController
{
    protected $content;
    protected $contentType;
    protected $contentStatus;
    protected $categories;
            
    public function indexAction() 
    {
        $contents = $this->content->fetchAll();
        //$contentDetail = $this->content->getContentDetail($contentId);
        foreach ($contents as $key => $content)
        {
            $type = $this->contentType->getContentType($content['content_type_id']);
            $status = $this->contentStatus->getContentStatus($content['content_status_id']);
            // Select all category
            
            $category = $this->content->getAllCategory($content['content_id']);
            
            
            $data[$key]['content_id'] = $content['content_id'];
            $data[$key]['start_date'] = $content['start_date'];
            $data[$key]['expiry_date'] = $content['expiry_date'];
            $data[$key]['hide_from_menu'] = $content['hide_from_menu'];
            $data[$key]['type'] = $type['content_type_name'];
            $data[$key]['status'] = $status['status_title'];
        }   
        return array('contents' => $data);
    }
    
    public function addAction() 
    {
        $request = $this->getRequest();
         
        if ($request->isPost()) {
        	$formData = $request->post()->toArray();
        	if (!empty($formData)) {
        		$data = array(
        				'contentTitle' 			=> $formData['title'],
        				'contentAlias' 		=> $formData['alias'],
        				'contentSummary'			=> $formData['summary'],
        				'contentText' 	=> $formData['content'],
        				'metaTitle' 		=> $formData['metaTitle'],
        				'metaKeyword' 				=> $formData['metaKeyword'],
        				'metaDescription' 			=> $formData['metaDescription'],
        				'startDate' 			=> $formData['startDate'],
        				'expDate' 		=> $formData['expDate'],
        				'hideFromMenu' 		=>  ($formData['hideFromMenu'] == 'on')? '1':'0',
        				'contentStatusId' 		=> $formData['contentStatusIds'],
        				'contentTypeId'			=> $formData['contentTypeIds'],
        				'categoryIds'			=> $formData['toCategories'],
        		);
        

        		$this->content->addContent($data);
        		// Redirect to list of category
        		return $this->redirect()->toRoute('default', array(
        				'controller' => 'admincp-content',
        				'action' => 'index',
        		));
        	}
        }
        $contentType = $this->contentType->fetchAll();
        $contentStatus = $this->contentStatus->fetchAll();
        $categories = $this->categories->fetchAll();
        return array(
        		'contentType' => $contentType,
        		'contentStatus' => $contentStatus,
                'categories' => $categories
        );
    }
    
    public function editAction() 
    {
        $request = $this->getRequest();
        $contentId = (int) $request->query()->get('id');
        if ($request->isPost()) {
        	$formData = $request->post()->toArray();
        	if (!empty($formData)) {
        	    
        		$data = array(
        				'contentTitle' 		=> $formData['title'],
        				'contentAlias' 		=> $formData['alias'],
        				'contentSummary'	=> $formData['summary'],
        				'contentText' 		=> $formData['content'],
        				'metaTitle' 		=> $formData['metaTitle'],
        				'metaKeyword' 		=> $formData['metaKeyword'],
        				'metaDescription' 	=> $formData['metaDescription'],
        				'startDate' 		=> $formData['startDate'],
        				'expDate' 			=> $formData['expDate'],
        				'contentStatusId' 	=> $formData['contentStatusIds'],
        				'contentTypeId'		=> $formData['contentTypeIds'],
        				'content_detail_id'	=> $formData['contentDetailId'],
        				'categoryIds'		=> $formData['toCategories'],
        		);
        		if (isset($formData['hideFromMenu'])) {
        		    $data['hideFromMenu'] = ($formData['hideFromMenu'] == 'on')? '1':'0';
        		} else {
        		    $data['hideFromMenu'] = '0';
        		}   
        		$this->content->editContent($formData['id'], $data);
        		// Redirect to list of category
        		return $this->redirect()->toRoute('default', array(
        				'controller' => 'admincp-content',
        				'action' => 'index',
        		));
        	}
        }

        $contents = $this->content->getContent($contentId);
        $contentDetail = $this->content->getContentDetail($contentId);
        //$category_id = $this->content->get
        $type = $this->contentType->getContentType($contents['content_type_id']);
        $status = $this->contentStatus->getContentStatus($contents['content_status_id']);
        $categoriesSelected = $this->content->getCategoryAssociation($contentId);
        $categoriesNotSelected = $this->categories->getCategoryNotSelected($categoriesSelected);
        $data['content_id'] 		= $contents['content_id'];
        $data['start_date'] 		= $contents['start_date'];
        $data['expiry_date'] 		= $contents['expiry_date'];
        $data['hide_from_menu'] 	= (int) $contents['hide_from_menu'];
        $data['content_id'] 		= $contents['content_id'];
        $data['type_checked'] 		= $contents['content_type_id'];
        $data['status_checked']		= $contents['content_status_id'];
        $data['type'] 				= $type['content_type_name'];
        $data['status'] 			= $status['status_title'];

        $data['content_detail_id'] 	= $contentDetail[0]['content_detail_id'];
        $data['title'] 				= $contentDetail[0]['title'];
        $data['alias'] 				= $contentDetail[0]['alias'];
        $data['summary'] 			= $contentDetail[0]['summary'];
        $data['content'] 			= $contentDetail[0]['content'];
        $data['meta_title'] 		= $contentDetail[0]['meta_title'];
        $data['meta_keyword'] 		= $contentDetail[0]['meta_keyword'];
        $data['meta_description'] 	= $contentDetail[0]['meta_description'];
        
        $contentType = $this->contentType->fetchAll();
        $contentStatus = $this->contentStatus->fetchAll();
        return array(
                'contents' => $data,
        		'contentType' => $contentType,
        		'contentStatus' => $contentStatus,
                'categories'	=> $categoriesNotSelected,
                'categoriesSelected' => $categoriesSelected
        );        
        
    }
    
    public function deleteAction() 
    {
        $request = $this->getRequest();
        $contentId = (int) $request->query()->get('id',0);
        if ($request->isPost()) {
        	$del = $request->post()->get('del', 'No');
        	if ($del == 'Yes') {
        		$id = (int) $request->post()->get('id');
        		$detailId = (int) $request->post()->get('detailId');
        		$this->content->deleteContent($id,$detailId);
        	}
        	// Redirect to list of category
        	return $this->redirect()->toRoute('default', array(
        			'controller' => 'admincp-content',
        			'action' => 'index',
        	));
        }
        
		$contents = $this->content->getContent($contentId);
        $contentDetail = $this->content->getContentDetail($contentId);
        return array('content' => $contents, 'contentDetail' => $contentDetail[0]);        
    }
    
    public function setContent(Content $content) 
    {
        $this->content = $content;
        return $this;
    }
    
    public function setContentStatus(ContentStatus $contentStatus)
    {
        $this->contentStatus = $contentStatus;
        return $this;
    }
    
    public function setContentType(ContentType $contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }
    
    public function setCategory(Category $categories)
    {
        $this->categories = $categories;
        return $this;
    }
}