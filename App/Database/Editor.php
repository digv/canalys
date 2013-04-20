<?php
class Database_Editor {
	
	/*
	 * database table
	 */
	protected $_table;
	
	/*
	 * columns that need to be listed
	 */
	
	protected $_listColumns = array ();
	
	/*
	 * columns conf
	 */
	
	protected $columns = array ();
	
	
	public function prepareListing ($params) {
		
		$selection = 'SELECT ';
		$sep = '';
		$join = '';
		foreach ($this->columns as $name => $col) {
			
			$selection .= $sep . $this->_table. '.'. $name;
			$sep = ',';
			
			if ($col['foreign_table']) {
				$join .= " join ". $col['foreign_table'] . ' on ';
			}
		}
	}
	
}