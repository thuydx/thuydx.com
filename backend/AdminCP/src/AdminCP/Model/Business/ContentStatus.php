<?php

namespace AdminCP\Model\Business;

use Zend\Db\Table\AbstractTable;

class ContentStatus extends AbstractTable
{
	protected $_name = 'content_status';
	protected $_referenceMap    = array(
			'Content' => array(
					'columns'           => array('content_status_id'),
					'refTableClass'     => 'Content',
					'refColumns'        => array('content_status_id')
			)
	);

	public function getContentStatus($id)
	{
		$id = (int) $id;
		$row = $this->fetchRow('content_status_id = ' . $id);
		if (!$row) {
			throw new Exception("Could not find row $id");
		}
		return $row->toArray();
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
		$this->update($data, 'content_status_id = ' . (int) $id);
	}
	
	public function deleteContentStatus($id)
	{
		$this->delete('content_status_id =' . (int) $id);
	}
}