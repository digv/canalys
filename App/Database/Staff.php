<?php
class Database_Staff extends Database_Editor {
	
	/*
	 * for retrieving staff records from table
	 */
	protected $sqlStatement = "SELECT ?  FROM staff as sf ";
	
	protected $_table = 'staff';
	
	protected $columns = array (
	
	'sf.staff_id' => array (
			'label' => 'Staff Id',
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
		
	'sf.gender' => array (
		'label' => 'Gender',
		'renderer' => 'string',
		
		),
		
		
	
	
	
	);
}