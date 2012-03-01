<?php

namespace AdminCP\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel;

class IndexController extends ActionController
{
    public function indexAction()
    {
        $layoutViewModel = $this->layout();
        $layoutViewModel->setTemplate('layout/adminLayout');
        return new ViewModel();
    }
}
