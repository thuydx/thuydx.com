<?php
namespace AdminCP\Model\Business;

use Zend\Db\Table\AbstractTable;

class Content extends AbstractTable
{
	protected $_name = 'content';
	protected $_dependentTables = array('content_type','content_status');
	protected $_referenceMap    = array(
        'CategoryAssociation' => array(
            'columns'           => array('content_id'),
            'refTableClass'     => 'CategoryAssociation',
            'refColumns'        => array('content_id')
        ),
	    'ContentDetail'		=> array(
            'columns'           => array('content_detail_id'),
            'refTableClass'     => 'ContentDetail',
            'refColumns'        => array('content_detail_id')
	    ),
    );
	
	public function getContent($id)
	{
		$id = (int) $id;
		$row = $this->fetchRow('content_id = ' . $id);
		if (!$row) {
			throw new Exception("Could not find row $id");
		}
		return $row->toArray();
	}
	
	public function addContent($data)
	{
	    if (!empty($data)) {
	        $contentData = array(
	        		'start_date' => $data['startDate'],      
	        		'expiry_date' => $data['expDate'],      
	        		'hide_from_menu' => $data['hideFromMenu'],      
	        		'content_status_id' => $data['contentStatusId'],      
	        		'content_type_id' => $data['contentTypeId'],         
	        );
	        $this->insert($contentData);
	        $contentId = $this->getAdapter()->lastInsertId();
	        $detailData = array(
	                'content_id' => $contentId,
	                'title' => $data['contentTitle'],
	                'alias' => $data['contentAlias'],
	                'summary' => $data['contentSummary'],
	                'content' => $data['contentText'],
	                'meta_title' => $data['metaTitle'],
	                'meta_keyword' => $data['metaKeyword'],
	                'meta_description' => $data['metaDescription'],
	        );
	        $this->getAdapter()->insert('content_detail', $detailData);
	        
	        foreach ($data['categoryIds'] as $categoryId) {
	            $associationData = array(
	            		'content_id' => $contentId,
	            		'category_id' => (int) $categoryId
	            );
	            $this->getAdapter()->insert('category_associations', $associationData);
	        }
	        
	        
	    }
	}

	public function editContent($id, $data)
	{
	    $contentId = (int) $id;
	    
	    $categoriesOld= $this->getCategoryAssociation($contentId);
	    foreach ($categoriesOld as $key => $category) {
	        $categoriesId[$key] = $category['category_id'];
	    }
	    $categoriesId = implode(', ', $categoriesId);
	    if (count($categoriesId) > 1) {
	        $categoriesId = substr($categoriesId, 0, -2);
	    }
	    $this->getAdapter()->query('SET NAMES UTF8');
	    $this->getAdapter()->delete('category_associations', 'category_id IN ('.$categoriesId.') AND content_id = ' .$contentId);

	    if (!empty($data)) {
	    	$contentData = array(
	    			'start_date' => $data['startDate'],
	    			'expiry_date' => $data['expDate'],
	    			'hide_from_menu' => $data['hideFromMenu'],
	    			'content_status_id' => $data['contentStatusId'],
	    			'content_type_id' => $data['contentTypeId'],
	    	);
	    	$this->update($contentData, 'content_id =' . $contentId);
	    	$detailData = array(
	    			'content_id' => $contentId,
	    			'title' => $data['contentTitle'],
	    			'alias' => $data['contentAlias'],
	    			'summary' => $data['contentSummary'],
	    			'content' => $data['contentText'],
	    			'meta_title' => $data['metaTitle'],
	    			'meta_keyword' => $data['metaKeyword'],
	    			'meta_description' => $data['metaDescription'],
	    	);
	    	 
	    	$this->getAdapter()->update('content_detail', $detailData, 'content_detail_id = ' .$data['content_detail_id']);	   

	    	foreach ($data['categoryIds'] as $categoryId) {
	    		$associationData = array(
	    				'content_id' => $contentId,
	    				'category_id' => (int) $categoryId
	    		);
	    		$this->getAdapter()->insert('category_associations', $associationData);
	    	}
	    	
		}
	}
	
	public function deleteContent($id, $detailId) 
	{
	    $this->delete('content_id =' . (int) $id);
	    $this->getAdapter()->delete('content_detail','content_detail_id = ' . (int) $detailId );
	    $this->getAdapter()->delete('category_associations', 'content_id = ' . (int) $id);
	}
	
	public function getContentByContentType($contentTypeId)
	{
	    
	}
	
	public function getContentByContentStatus($ContentStatusId)
	{
	    
	}
	
	public function getContentDetail($contentId)
	{
	    $contentId = (int) $contentId;
	    $rs = $this->getAdapter()->fetchAll('SELECT * FROM content_detail WHERE content_id =' .$contentId);
	    return $rs;
	}
	
	public function getCategoryAssociation($contentId)
	{
	    $contentId = (int) $contentId;
	    $rs = $this->getAdapter()->fetchAll('SELECT * FROM category_associations WHERE content_id = ' . $contentId );
	    foreach ($rs as $key => $categoryId) {
	        $categories[] = $this->getAdapter()->fetchAll('SELECT * FROM categories WHERE category_id = '. $categoryId['category_id']);
	    }
	    return $categories[0];
	}
	
	public function getAllCategory($contentId)
	{
	    $contentId = (int) $contentId;
	    $rs = $this->getAdapter()->fetchAll('SELECT * FROM category_associations WHERE content_id = ' . $contentId);
	    return $rs;
	}
}	