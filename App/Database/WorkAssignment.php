<?php
class Database_WorkAssignment extends Database_Editor {
	
	/*
	 * for retrieving staff records from table
	 */
	protected $sqlStatement = "SELECT ?  FROM assignment AS am
							   JOIN staff AS sf using (staff_id)
							   JOIN project AS pt using (project_id)";
	
	protected $_table = 'assignment';
	
	protected $columns = array (
	
	'am.staff_id' => array (
			'label' => 'Project Id',
			'renderer' => 'string',
		),
		
	'sf.name' => array (
		'label' => 'Staff Name',
		'renderer' => 'string',
		
		),
		
	/*'sf.birth_day' => array (
		'label' => 'Date Of Birth',
		'renderer' => 'Date',
		
		),*/
		
	'pt.project_name' => array (
		'label' => 'Project Name',
		'renderer' => 'string',
		
		),
		
		
	
	
	
	);
}