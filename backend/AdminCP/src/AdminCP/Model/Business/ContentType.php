<?php

namespace AdminCP\Model\Business;

use Zend\Db\TableGateway\TableGateway,
    Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet;

class ContentType extends TableGateway
{
    public function __construct(Adapter $adapter = null, $databaseSchema = null,
            ResultSet $selectResultPrototype = null)
    {
        return parent::__construct('content_types', $adapter, $databaseSchema,
                $selectResultPrototype);
    }
    
    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }
    
	public function getContentType($id)
	{
		$id = (int) $id;
		$rowset = $this->select(array('content_type_id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function addContentType($contentTypeName, $contentTypeDescription = '')
	{
		$data = array(
				'content_type_name' => $contentTypeName,
				'content_type_description' => $contentTypeDescription,
		);
		$this->insert($data);
	}
	
	public function updateContentType($id, $contentTypeName, $contentTypeDescription)
	{
		$data = array(
				'content_type_name' => $contentTypeName,
				'content_type_description' => $contentTypeDescription,
		);
		$this->update($data, array('content_type_id' => (int) $id));
	}
	
	public function deleteContentType($id)
	{
		$this->delete(array('id' =>(int) $id));
	}
	
}