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
		
		$count = intval($params['pagesize']);
        $offset = intval($params['offset']);
        $sort_field = $params['sort'];
        $sort_order = $params['order'];
        
        $order = "";
        $where = array();
        
        if (!empty($sort_field) && !empty($sort_order)) {
        	$order = " ORDER BY $sort_field $sort_order";
        }
        
        foreach ($params['qbf'] as  $field => $fieldValue) {
        	$where[] = $field . " LIKE '%". $fieldValue. "%' ";
        }
		$sql = $this->assembleSqlStatement();
		if (!empty($where)) {
			$where = " where " .implode(' AND ', $where);
		} else {
			$where = '';
		}
		
		$sql = $sql . $where . $order;
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
		if (strpos($colName, '.') !== false) {
			$colName = substr($colName, strpos($colName, '.') + 1);
		}
		 return $row[$colName];
	}
	
	//for quick filter
	public function canQbf ($col) {
		if (isset($this->columns[$col]['qbf']))
            return $this->columns[$col]['qbf'];
        else
            return true;
	}
		
	/*
	 * return human readable headers
	 */
	
	public function getListingHeaders() {
		$cols = array ();
		
		foreach ( $this->columns as $name => $col ) {
			$label = $col ['label'];
			$cols [] = $label;
		}
		return $cols;
	}
	
}