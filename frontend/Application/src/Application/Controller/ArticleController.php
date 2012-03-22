<?php

namespace Application\Controller;

use AdminCP\Model\Business\Content;

use Zend\Mvc\Controller\ActionController,
	AdminCP\Model\Business\Content as AContent;

class ArticleController extends ActionController
{	
    public $content;
	public function indexAction()
    {
		$contentId = $this->getRequest()->query()->get('id');
		$data['content'] = $this->content->fetchAll('content_id = ' . $contentId)->toArray();
        $data['detail'] = $this->content->getContentDetail($contentId);
        return array('data' => $data);
    }
    
    public function articleAction()
    {
        
    }
    
    public function setContent(AContent $content)
    {
        $this->content = $content;
        return $this;
    }
}
