<?php

namespace AdminCP\Model\Business;

use Zend\Db\TableGateway\TableGateway,
    Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\Sql\Select;

class Category extends TableGateway
{
    public function __construct(Adapter $adapter = null, $databaseSchema = null,
            ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('categories', $adapter, $databaseSchema,
                $selectResultPrototype);
    }    

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }
	public function getCategory($id)
	{
		$id = (int) $id;
		$rowset = $this->select(array('category_id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
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
		$this->update($data, array('category_id' => (int) $id));
	}
	
	public function deleteCategory($id)
	{
		$this->delete(array('category_id' => (int) $id));
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
	    $rowset = $this->select(function (Select $select) {
	        $select->from('categories');
	        $select->where('category_id', 'NOT IN (' . $categoriesId . ')');
	    });
	    $row = $rowset->current();
		//$rs = $this->getAdapter()->fetchAll("SELECT * FROM categories WHERE category_id NOT IN (" . $categoriesId .")");
		return $row;
	}
	
	public function getCategoryById($categoryId)
	{
	    $categoryId = (int) $categoryId;
	    $select = new Select;
	    $select->from('category_associations')
	    ->where->equalTo('category_id', $categoryId);  
	    $statement = $this->adapter->createStatement();
	     
	    $select->prepareStatement($this->adapter, $statement);
	     
	    $resultSet = new ResultSet();
	    $resultSet->setDataSource($statement->execute());
	    
	    return $resultSet->toArray();
	}
}