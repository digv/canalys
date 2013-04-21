<?php
class Database_Project extends Database_Editor {
	
	/*
	 * for retrieving project records from table
	 */
	protected $sqlStatement = "SELECT ?  FROM project AS pt ";
	
	protected $_table = 'project';
	
	protected $_pk = 'pt.project_id';
	
	protected $columns = array (
	
	'pt.project_id' => array (
			'label' => 'Project Id',
			'renderer' => 'pkField',
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
	
	/*
	 * render listing cells
	 */
	
	public function renderListingCell($colName, $row) {
		$colName = $this->removeTablePrefix ( $colName );
		//for primary key, link to edit page
		$helper = Helper_Url::getInstance();
		$baseUrl = $helper -> baseUrl();
		if ($colName == $this->removeTablePrefix($this->_pk)) {
			$html = "<a href='{$baseUrl}index.php/project/edit/{$row [$colName]}' target='_blank'>";
			$html .= $row [$colName];
			$html .= '</a>';
			return $html;
		}
		
		if ($colName == 'due_day') {
			if ($row [$colName] == '0000-00-00 00:00:00') {
				$html = "na";
			} else {
				$html = date ( 'm/d/Y', strtotime ( $row [$colName] ) );
			}
			return $html;
		}
		return $row [$colName];
	}
}