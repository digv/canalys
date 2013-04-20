<?php
class Database_Editor {
	
	/*
	 * database table
	 */
	protected $_table;
	
	/*
	 * primary key
	 */
	
	protected $_pk;
	
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
		
		//handle list columns, only show those list=true;
		

		foreach ( $this->columns as $field => $col ) {
			if (isset ( $col ['list'] ) && $col ['list']) {
				$this->_listColumns [$field] = $col;
			}
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
		return array_keys($this->_listColumns);
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
		
		foreach ( $this->_listColumns as $name => $col ) {
			$label = $col ['label'];
			$cols [] = $label;
		}
		return $cols;
	}
	
	
	//prepare editor for edit page
	
	public function prepareEditor ($key) {
		
		if (!empty($key)) {
			
			//load column data
			$sql = str_replace('?', implode(' , ', array_keys($this->columns)), $this->sqlStatement);
			$sql .= ' WHERE '. $this-> _pk . '= ? ';
			$row = App::getDb ()->query_one ( $sql, array ($key ) );
			
			foreach ($this->columns as $field => $col) {
				$key = substr($field, strpos($field, '.' + 1));
				if (isset($row[$key])) {
					$this->columns[$field]['value'] = $row[$key];
				}
			}
		}
		
	}
	
	//start to render editor
	public function renderEditors () {
		$html = '';
		foreach ( $this->columns as $field => $col ) {
			
			if (isset ( $col ['renderer'] )) {
				$initMethod = "renderEditor_" . $col ['renderer'];
				if (method_exists ( $this, $initMethod )) {
					$html .= $this->$initMethod ( $col , $field);
				}
			}
		}
		return $html;
	}
	
	//render pk field or read only part
	public function renderEditor_PkField($col, $field) {
		
		$html .= '<div class="field">';
		$html .= '<label for="'.$col['label'].'" class="edit-label">'.$col['label']. '</label>';
		$value = isset($col['value']) ? $col['value'] : '';
		$html .= "<input readonly='readonly' type='text' value='{$value}' name='{$field}' class='edit-input' />";
		$html .= '</div>';
		return $html;
	}
	
	//render free text part
	public function renderEditor_String($col, $field) {
		$html .= '<div class="field">';
		$html .= '<label for="'.$col['label'].'" class="edit-label">'.$col['label']. '</label>';
		$value = isset($col['value']) ? $col['value'] : '';
		$html .= "<input type='text' value='{$value}' name='{$field}' class='edit-input' />";
		$html .= '</div>';
		return $html;
	}
	
}