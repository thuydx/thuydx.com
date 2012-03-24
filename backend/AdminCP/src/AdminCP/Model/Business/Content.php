<?php
namespace AdminCP\Model\Business;

use Zend\Db\TableGateway\TableGateway,
    Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\Sql\Select;

class Content extends TableGateway
{
//     protected $_adapter;
//     protected $driverConfig;
// 	protected $_name = 'content';
// 	protected $_dependentTables = array('content_type','content_status');
// 	protected $_referenceMap    = array(
//         'CategoryAssociation' => array(
//             'columns'           => array('content_id'),
//             'refTableClass'     => 'CategoryAssociation',
//             'refColumns'        => array('content_id')
//         ),
// 	    'ContentDetail'		=> array(
//             'columns'           => array('content_detail_id'),
//             'refTableClass'     => 'ContentDetail',
//             'refColumns'        => array('content_detail_id')
// 	    ),
//     );
    /**
     * @var Select
     */
    protected $sqlSelect = null;
    	
    public function __construct(Adapter $adapter = null, $databaseSchema = null,
            ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('content', $adapter, $databaseSchema,
                $selectResultPrototype);
    }
	
	public function fetchAll()
	{
	    $resultSet = $this->select();
	    return $resultSet;
	}
		
	public function getContent($id)
	{
		$id = (int) $id;
		$rowset = $this->select(array('content_id' => $id));
		$row = $rowset->current();
		if (!$row) {
		    throw new \Exception("Could not find row $id");
		}
		return $row;
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
	    	$this->update($contentData, array('content_id' => $contentId));
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
        $select = new Select;
        $select->from('content_detail')
                ->where->equalTo('content_id', $contentId);  // option 1: using default function of Zend\Db\Sql\Select
//                 ->where('content_id ="'.$contentId.'"');  // option 2: using alter sql string
	    $statement = $this->adapter->createStatement();
	    
	    $select->prepareStatement($this->adapter, $statement);
	    
	    $resultSet = new ResultSet();
	    $resultSet->setDataSource($statement->execute());
	    return $resultSet->toArray();
	}
	
	public function getCategoryAssociation($contentId)
	{
	    $contentId = (int) $contentId;
	    $select = new Select;
	    $select->from('category_associations')
	    //->where->equalTo('content_id', $contentId);
	    ->where('content_id ="'.$contentId.'"');
	    $statement = $this->adapter->createStatement();
	    $select->prepareStatement($this->adapter, $statement);
	     
	    $resultSet = new ResultSet();
	    $resultSet->setDataSource($statement->execute());
	    
	    foreach ($resultSet->toArray() as $key => $categoryId) {
	        $catSelect = new Select();
	        $catSelect->from('categories')
	        //->where('category_id ="'.$categoryId['category_id'].'"');
	        ->where->equalTo('category_id', $categoryId['category_id']);
	        $catStatement = $this->adapter->createStatement();
	        
	        $catSelect->prepareStatement($this->adapter, $catStatement);
            $catResultSet = new ResultSet();
	        $catResultSet->setDataSource($catStatement->execute());
	        $categories[] = $catResultSet->toArray();
	    }
	    
	    return $categories;
	}
	
	public function getAllCategory($contentId)
	{
	    $contentId = (int) $contentId;
	    $select = new Select;
	    $select->from('category_associations')
	    ->where->equalTo('content_id', $contentId);  // option 1: using default function of Zend\Db\Sql\Select
	    //                 ->where('content_id ="'.$contentId.'"');  // option 2: using alter sql string
	    $statement = $this->adapter->createStatement();
	     
	    $select->prepareStatement($this->adapter, $statement);
	     
	    $resultSet = new ResultSet();
	    $resultSet->setDataSource($statement->execute());
	    return $resultSet->toArray();
	}
	
	public function setAdapter(Adapter $_adapter) 
	{
	    $this->_adapter = $_adapter;
	    return $this->_adapter;
	}
}	