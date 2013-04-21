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
	
	/*
	 * store post value 
	 */
	
	protected $attributes = array();
	
	/*
	 * store processed post data
	 */
	
	protected $processedPost = array ();
	
	/*
	 * msg for some info
	 */
	public $msg = '';
	
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
	
	public function renderListingCell($colName, $row) {
		$colName = $this->removeTablePrefix ( $colName );
		return $row [$colName];
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
				$key = $this->removeTablePrefix($field);
				if (isset($row[$key])) {
					$col['value'] = $row[$key];
					$this->columns[$field] = $col;
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
		
		$html = '<div class="field">';
		$html .= '<label for="'.$col['label'].'" class="edit-label">'.$col['label']. '</label>';
		$value = isset($col['value']) ? $col['value'] : '';
		$html .= "<input readonly='readonly' type='text' value='{$value}' name='{$field}' class='edit-input' />";
		$html .= '</div>';
		return $html;
	}
	
	//render free text part
	public function renderEditor_String($col, $field) {
		$html = '<div class="field">';
		$html .= '<label for="'.$col['label'].'" class="edit-label">'.$col['label']. '</label>';
		$value = isset($col['value']) ? $col['value'] : '';
		$html .= "<input type='text' value='{$value}' name='{$field}' class='edit-input' />";
		$html .= '</div>';
		return $html;
	}
	
	public function addItem ($attr, $value) {
		//due to sf.field will be changed to sf_field, we need to get back
		$attr = $this-> removeTablePrefix($attr, '_');
		$this->attributes[$attr] = $value;
		
		return $this;
	}
	
	//remove table alias prefix
	public function removeTablePrefix ($attr, $flag = '.') {
		if (strpos($attr, $flag) !== false) {
			return $attr = substr($attr, strpos($attr, $flag) + 1);
		} else {
			return $attr;
		}
		
	}
	//if it is new, then insert 
	public function _insert () {
		$postValues = $this->processedPost;
		$columns = array();
		foreach ($this->columns as $field => $col) {
			if ($field == $this->_pk) {
				continue;
			}
			$field = $this->removeTablePrefix($field);
			$columns[$field] = isset($postValues[$field]) ? trim($postValues[$field]) : '';
		}
		
		return  App::getDb() -> insert ($this->_table, $columns);;
		
	}
	
	//update record
	public function _update () {
		
		$sql = "UPDATE ". $this->_table;
		$sql .= "  SET ";
		$postValues = $this->processedPost;
		
		foreach ( $this->columns as $field => $col ) {
			if ($field == $this->_pk) {
				continue;
			}
			$field = $this->removeTablePrefix ( $field );
			$fields [] = $field;
			$placeHolder [] = $field . " = ? ";
			if (isset ( $postValues [$field] )) {
				$values[] = trim ( $postValues [$field] );
			}
		}
		$normalPk = $this->removeTablePrefix($this->_pk);
		$pkValue = $postValues[$normalPk];
		$values[] = $pkValue;
		$sql .= implode(', ', $placeHolder). ' WHERE '. $normalPk . ' = ? ';
		
		return App::getDb() -> query ($sql, $values);
		
	}
	public function processPostData() {
		foreach ( $_POST as $key => $val ) {
			$key = $this->removeTablePrefix ( $key, '_' );
			$this->processedPost [$key] = $val;
		}
		
		return $this->processedPost;
	}
	//actions before save 
	public function beforeSave() {
		
	}
	
	public function save() {
		$postValues = $this->processPostData ();
		$normalPk = $this->removeTablePrefix ( $this->_pk );
		if (isset ( $postValues [$normalPk] ) && ! empty ( $postValues [$normalPk] )) {
			return $this->_update();
		} else {
			 return $this->_insert ();
		}
	}
	
	public function delete () {
		$sql = "DELETE FROM ". $this->_table;
		$normalPk = $this->removeTablePrefix($this->_pk);
		$postValues = $this->processPostData();
		$pkValue = isset($postValues[$normalPk]) ? $postValues[$normalPk] : '';
		if (!empty($pkValue)) {
			$sql .= " WHERE {$normalPk} = ? ";
			
			return App::getDb() -> query ($sql, array($pkValue));
		} else {
			return false;
		}
		
	}
	
}