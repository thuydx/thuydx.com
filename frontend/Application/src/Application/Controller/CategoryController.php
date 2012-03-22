<?php

namespace Application\Controller;

use AdminCP\Model\Business\Content;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel,
	AdminCP\Model\Business\Content as CContent,
	AdminCP\Model\Business\Category as CCategory;

class CategoryController extends ActionController
{
    protected $content;
    protected $category;
    
    public function indexAction()
    {
    	$categoryId = $this->getRequest()->query()->get('id');
    	$listCategoryId = $this->category->getCategoryById($categoryId);
    	foreach ($listCategoryId as $catId)
    	{
    	    $data[] = $this->content->getContentDetail((int) $catId['content_id']);
    	}
    	return new ViewModel(array('data' => $data));
    }
    
    public function setContent(CContent $content)
    {
        $this->content = $content;
        return $this;
    }

    public function setCategory(CCategory $category)
    {
        $this->category = $category;
        return $this;
    }
}