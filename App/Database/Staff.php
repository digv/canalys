<?php
class Database_Staff extends Database_Editor {
	
	protected $columns = array (
	
	'staff_id' => array (
			'label' => 'Staff Id',
			'renderer' => 'string',
		),
		
	'name' => array (
		'label' => 'Staff Name',
		'renderer' => 'string',
		
		),
		
	'birth_day' => array (
		'label' => 'Date Of Birth',
		'renderer' => 'Date',
		
		),
		
	'gender' => array (
		'label' => 'Gender',
		'renderer' => 'string',
		
		),
		
		
	
	
	
	);
}