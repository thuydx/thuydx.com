<?php

namespace AdminCP\Model\Business;

use Zend\Db\Table\AbstractTable;
// 	AdminCP\Model\Entity\ContentType;

class ContentType extends AbstractTable
{
	protected $_name = 'content_types';
	protected $_referenceMap    = array(
        'Content' => array(
            'columns'           => array('content_type_id'),
            'refTableClass'     => 'Content',
            'refColumns'        => array('content_type_id')
        ),
	);
	public function getContentType($id)
	{
		$id = (int) $id;
		$row = $this->fetchRow('content_type_id = ' . $id);
		if (!$row) {
			throw new Exception("Could not find row $id");
		}
		return $row->toArray();
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
		$this->update($data, 'content_type_id = ' . (int) $id);
	}
	public function deleteContentType($id)
	{
		$this->delete('content_type_id =' . (int) $id);
	}
}