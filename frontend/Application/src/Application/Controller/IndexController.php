<?php

namespace Application\Controller;

use Zend\Mvc\Controller\ActionController,
	AdminCP\Model\Business\Content as FContent,
    Zend\View\Model\ViewModel;

class IndexController extends ActionController
{	
    public $content;
	public function indexAction()
    {
//         $em = $this->getLocator()->get('doctrine_em');
//         echo "<pre>"; var_dump($em); die();
        $contentId = $this->content->fetchAll();
        foreach ($contentId as $content)
        {
            $data[] = $this->content->getContentDetail($content['content_id']);
        }
        return new ViewModel(array('data' => $data));
    }
    
    public function articleAction()
    {
        $contentId = $this->getRequest()->query()->get('id');
        $data = $this->content->getContentDetail($contentId);
        
        return new ViewModel(array('data' => $data));
    }
    
    public function setContent(FContent $content)
    {
        $this->content = $content;
        return $this;
    }
}
