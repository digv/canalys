<?php
class Database_WorkAssignment extends Database_Editor {
	
	/*
	 * for retrieving work assignment records from table
	 */
	protected $sqlStatement = "SELECT ?  FROM assignment AS am
							   JOIN staff AS sf using (staff_id)
							   JOIN project AS pt using (project_id)";
	
	protected $_table = 'assignment';
	
	protected $_pk = 'am.assignment_id';
	
	/*
	 * store table schema for save
	 */
	
	protected $tableSchema = array('assignment_id', 'staff_id', 'project_id');
	
	protected $columns = array (
	
	'am.assignment_id' => array (
			'label' => 'Assignment Id',
			'renderer' => 'pkField',
			'list' => true,
		),
		
	'sf.name' => array (
		'label' => 'Staff Name',
		'renderer' => 'select',
		'list' => true,
		'link_table' => array ('staff' => 
								array('option' => 'sf.staff_id', 'label' => 'sf.name'),
							),
		),
		
		
	'pt.project_name' => array (
		'label' => 'Project Name',
		'renderer' => 'select',
		'list' => true,
		'link_table' => array ('project' => 
								array('option' => 'pt.project_id', 'label' => 'pt.project_name'),
								
							),
		),
		
	'pt.due_day' => array (
		'label' => 'Due Day',
		//'renderer' => 'date',
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
			$html = "<a href='{$baseUrl}index.php/default/edit/{$row [$colName]}' target='_blank'>";
			$html .= $row [$colName];
			$html .= '</a>';
			return $html;
		}
		
		if ($colName == 'due_day') {
			$present = time();
			$dueDay = strtotime($row[$colName]);
			if ($dueDay < $present) {
				$html = "<span style='color:red;'>".date('m/d/Y', strtotime($row[$colName]))."</span>";
			} else {
				$html = date('m/d/Y', strtotime($row[$colName]));
			}
			
			return $html;
		}
		
		return $row [$colName];
	}
	
	
	/*
	 * render select
	 */
	
	public function renderEditor_Select ($col, $field) {
		$html = '<div class="field">';
		$html .= '<label for="' . $col ['label'] . '" class="edit-label">' . $col ['label'] . '</label>';
		$value = isset ( $col ['value'] ) ? $col ['value'] : '';
		
		$table = array_shift(array_keys($col['link_table']));
		$option = $col['link_table'][$table]['option'];
		$label = $col['link_table'][$table]['label'];
		
		$html .= "<select name='{$option}' class='edit-select'>";
		$option = $this->removeTablePrefix($option);
		$label = $this -> removeTablePrefix($label);
		
		$sql = "SELECT $option, $label FROM $table ";
		$results = App::getDb() -> query_all ($sql);
		
		foreach ($results as $result) {
			$selected = '';
			if ($value == $result[$label]) {
				$selected = 'selected="selected"';
			}
			$html .= "<option $selected value='{$result[$option]}'>{$result[$label]}</option>";
		}
		$html .= "</select>";
		$html .= '</div>';
		return $html;
	}
	
	//update record
	public function _update () {
		
		$sql = "UPDATE ". $this->_table;
		$sql .= "  SET ";
		$postValues = $this->processedPost;
		foreach ( $this->tableSchema as $field ) {
			if ($field == $this->removeTablePrefix($this->_pk)) {
				continue;
			}
			$fields[] = $field;
			$placeHolder [] = $field . " = ? ";
			$values [] = isset ( $postValues [$field] ) ? trim ( $postValues [$field] ) : '';
		}
		$check = $this->checkUnique($this->_table, $fields, $values);
		
		if ($check) {
			return  false;
		}
		$normalPk = $this->removeTablePrefix($this->_pk);
		$pkValue = $postValues[$normalPk];
		$values[] = $pkValue;
		$sql .= implode(', ', $placeHolder). ' WHERE '. $normalPk . ' = ? ';
		
		return App::getDb() -> query ($sql, $values);
		
	}
	
	//if it is new, then insert 
	public function _insert() {
		$postValues = $this->processedPost;
		$columns = array ();
		foreach ( $this->tableSchema as $field ) {
			if ($field == $this->removeTablePrefix($this->_pk)) {
				continue;
			}
			$columns [$field] = isset ( $postValues [$field] ) ? trim ( $postValues [$field] ) : '';
		}
		$check = $this->checkUnique($this->_table, array_keys($columns), array_values($columns));
		if ($check) {
			return false;
		}
		
		return App::getDb ()->insert ( $this->_table, $columns );
		;
	
	}
	
	
}