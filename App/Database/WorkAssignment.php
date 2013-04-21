<?php
class Database_WorkAssignment extends Database_Editor {
	
	/*
	 * for retrieving work assignment records from table
	 */
	protected $sqlStatement = "SELECT ?  FROM assignment AS am
							   JOIN staff AS sf using (staff_id)
							   JOIN project AS pt using (project_id)";
	
	protected $_table = 'assignment';
	
	protected $_pk = 'am.assigment_id';
	
	protected $columns = array (
	
	'am.assigment_id' => array (
			'label' => 'Assignment Id',
			'renderer' => 'pkField',
			'list' => true,
		),
		
	'sf.name' => array (
		'label' => 'Staff Name',
		'renderer' => 'string',
		'list' => true,
		),
		
		
	'pt.project_name' => array (
		'label' => 'Project Name',
		'renderer' => 'string',
		'list' => true,
		),
		
	'pt.due_day' => array (
		'label' => 'Due Day',
		'renderer' => 'string',
		'list' => true,
		),
	
	);
	
	
	/*
	 * render listing cells
	 */
	
	public function renderListingCell($colName, $row) {
		$colName = $this->removeTablePrefix ( $colName );
		//for primary key, link to edit page
		if ($colName == $this->removeTablePrefix($this->_pk)) {
			$html = "<a href='http://ca.digv.co/index.php/staff/edit/{$row [$colName]}' target='_blank'>";
			$html .= $row [$colName];
			$html .= '</a>';
			return $html;
		}
		
		return $row [$colName];
	}
}