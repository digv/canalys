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
	
	/*
	 * sql definition for retrieving records
	 */
	
	protected $sqlStatement = '';
	
	/*
	 * store the rows fetched from db
	 */
	
	protected $_listRows = array();
	
	/*
	 * store total row count
	 */
	
	protected  $_totalCount;
	
	
	public function prepareListing ($params) {
		
		$sql = $this->assembleSqlStatement();
		$this->_listRows = App::getDb() -> query_all ($sql);
		$this->_totalCount = App::getDb() -> query_one ('SELECT FOUND_ROWS()');
		
	}
	
	public function getListingRows () {
		
		return $this->_listRows;
	}
	
	public function getListingColumns () {
		return array_keys($this->columns);
	}
	
	public function assembleSqlStatement () {
		$listRows = implode(' , ', $this->getListingColumns());
		
		return  str_replace('? ', ' SQL_CALC_FOUND_ROWS '.$listRows, $this->sqlStatement);
	}
	
	public function renderListingCell ($colName, $row) {
		 return $row[$colName];
	}
	
}