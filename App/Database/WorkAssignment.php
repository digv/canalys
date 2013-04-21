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
		if ($colName == $this->removeTablePrefix($this->_pk)) {
			$html = "<a href='http://ca.digv.co/index.php/staff/edit/{$row [$colName]}' target='_blank'>";
			$html .= $row [$colName];
			$html .= '</a>';
			return $html;
		}
		
		if ($colName == 'due_day') {
			$present = strtotime(time());
			$dueDay = strtotime($row[$colName]);
			if ($dueDay < $present) {
				$html = "<span style='color:red;'>$row[$colName]</span>";
			} else {
				$html = $row[$colName];
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
			$placeHolder [] = $field . " = ? ";
			$values [] = isset ( $postValues [$field] ) ? trim ( $postValues [$field] ) : '';
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
		
		return App::getDb ()->insert ( $this->_table, $columns );
		;
	
	}
	
}