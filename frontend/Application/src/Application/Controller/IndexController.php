<?php

namespace Application\Controller;

use AdminCP\Model\Business\Content;

use Zend\Mvc\Controller\ActionController,
	AdminCP\Model\Business\Content as FContent;

class IndexController extends ActionController
{	
    public $content;
	public function indexAction()
    {
        $contentId = $this->content->fetchAll();
        foreach ($contentId as $content)
        {
            $data[] = $this->content->getContentDetail($content['content_id']);
        }
        return array(
        	'data' => $data,
        );
    }
    
    public function articleAction()
    {
        $contentId = $this->getRequest()->query()->get('id');
        $data = $this->content->getContentDetail($contentId);
        
        return array(
                	'data' => $data
                );
    }
    
    public function setContent(FContent $content)
    {
        $this->content = $content;
        return $this;
    }
}
