<?php
class Database_Project extends Database_Editor {
	
	/*
	 * for retrieving project records from table
	 */
	protected $sqlStatement = "SELECT ?  FROM project AS pt ";
	
	protected $_table = 'project';
	
	protected $columns = array (
	
	'pt.project_id' => array (
			'label' => 'Project Id',
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
		'renderer' => 'date',
		'list' => true,
		),
		
	);
}