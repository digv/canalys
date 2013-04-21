<?php
class Database_Staff extends Database_Editor {
	
	/*
	 * for retrieving staff records from table
	 */
	protected $sqlStatement = "SELECT ?  FROM staff AS sf ";
	
	protected $_table = 'staff';
	
	protected $_pk = 'sf.staff_id';
	
	protected $columns = array (
	
	'sf.staff_id' => array (
			'label' => 'Staff Id',
			'renderer' => 'pkField',
			'list' => true,
		),
		
	'sf.name' => array (
		'label' => 'Staff Name',
		'renderer' => 'string',
		'list' => true,
		),
		
	'sf.birthday' => array (
		'label' => 'Date Of Birth',
		'renderer' => 'date',
		'list' => true,
		),
		
	'sf.gender' => array (
		'label' => 'Gender',
		'renderer' => 'gender',
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