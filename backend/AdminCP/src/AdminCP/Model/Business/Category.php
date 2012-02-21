<?php

namespace AdminCP\Model\Business;

use Zend\Db\Table\AbstractTable;

class Category extends AbstractTable
{
	protected $_name = 'categories';
	
	public function getCategory($id)
	{
		$id = (int) $id;
		$row = $this->fetchRow('category_id = ' . $id);
		if (!$row) {
			throw new Exception("Could not find row $id");
		}
		return $row->toArray();
	}
	
	public function addCategory($info = array())
	{
	    if (!empty($info)) {
	        $data = array(
	        		'category_title' => $info['title'],
	        		'category_description' => $info['description'],
	        		'category_meta_title' => $info['metaTitle'],
	        		'category_meta_description' => $info['metaDiscription'],
	        		'category_meta_keyword' => $info['metaKeyword'],
	        		'category_icon' => $info['icon'],
	        		'category_password' => $info['password'],
	        		'category_visit' => $info['visit'],
	        		'content_count' => $info['contentCount'],
	        		'general_url' => $info['generalUrl'],
	        		'hide_form_menu' => $info['hideFromMenu'],
	        		'sort_order' => $info['sortOrder'],
	        );
	    }
	    
		$this->insert($data);
	}
	
	public function updateCategory($id, $info = array())
	{
		if (!empty($info)) {
	        $data = array(
	        		'category_title' => $info['title'],
	        		'category_description' => $info['description'],
	        		'category_meta_title' => $info['metaTitle'],
	        		'category_meta_description' => $info['metaDiscription'],
	        		'category_meta_keyword' => $info['metaKeyword'],
	        		'category_icon' => $info['icon'],
	        		'category_password' => $info['password'],
	        		'category_visit' => $info['visit'],
	        		'content_count' => $info['contentCount'],
	        		'general_url' => $info['generalUrl'],
	        		'hide_form_menu' => $info['hideFromMenu'],
	        		'sort_order' => $info['sortOrder'],
	        );
	    }
		$this->update($data, 'category_id = ' . (int) $id);
	}
	public function deleteCategory($id)
	{
		$this->delete('category_id =' . (int) $id);
	}
	public function getCategoryNotSelected($categoriesSelected = array())
	{
	    foreach ($categoriesSelected as $key => $category) {
	        $categoriesId[$key] = $category['category_id']; 
	    }
        $categoriesId = implode(', ', $categoriesId);
	    if (count($categoriesId) > 1) {
    	    $categoriesId = substr($categoriesId, 0, -2);
	    }    
		$rs = $this->getAdapter()->fetchAll("SELECT * FROM categories WHERE category_id NOT IN (" . $categoriesId .")");
		return $rs;
	}
	
	public function getCategoryById($categoryId)
	{
	    $rs = $this->getAdapter()->fetchAll('SELECT * FROM category_associations WHERE category_id = ' .$categoryId);
	    return $rs;
	}
}