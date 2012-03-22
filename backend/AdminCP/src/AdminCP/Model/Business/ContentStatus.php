<?php

namespace AdminCP\Model\Business;

use Zend\Db\TableGateway\TableGateway,
    Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet;

class ContentStatus extends TableGateway
{	
	public function __construct(Adapter $adapter = null, $databaseSchema = null,
	        ResultSet $selectResultPrototype = null)
	{
	    return parent::__construct('content_status', $adapter, $databaseSchema,
	            $selectResultPrototype);
	}
	
	public function fetchAll()
	{
	    $resultSet = $this->select();
	    return $resultSet;
	}
	
	public function getContentStatus($id)
	{
		$id = (int) $id;
		$rowset = $this->select(array('content_status_id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}
	
	public function addContentStatus($contentStatusName)
	{
		$data = array(
				'status_title' => $contentStatusName,
		);
		$this->insert($data);
	}
	
	public function updateContentStatus($id, $contentStatusName)
	{
		$data = array(
				'status_title' => $contentStatusName,
		);
		$this->update($data, array('content_status_id' => (int) $id));
	}
	
	public function deleteContentStatus($id)
	{
		$this->delete(array('content_status_id' => (int) $id));
	}
}