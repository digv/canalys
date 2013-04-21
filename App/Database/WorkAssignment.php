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
								array('option' => 'staff_id', 'label' => 'name'),
								
							),
		),
		
		
	'pt.project_name' => array (
		'label' => 'Project Name',
		'renderer' => 'select',
		'list' => true,
		'link_table' => array ('project' => 
								array('option' => 'project_id', 'label' => 'project_name'),
								
							),
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
		if ($colName == $this->removeTablePrefix($this->_pk)) {
			$html = "<a href='http://ca.digv.co/index.php/staff/edit/{$row [$colName]}' target='_blank'>";
			$html .= $row [$colName];
			$html .= '</a>';
			return $html;
		}
		
		if ($colName == 'due_day') {
			$present = strtotime(now());
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
		
		$sql = "SELECT $option, $label FROM $table ";
		$results = App::getDb() -> query_all ($sql);
		var_dump($results);
		
		$html .= "<select name='{$field}' class='edit-select'>";
		foreach ($genders as $gender) {
			$selected = '';
			if ($value == $gender) {
				$selected = 'selected="selected"';
			}
			$html .= "<option $selected value='{$gender}'>{$gender}</option>";
		}
		$html .= "</select>";
		$html .= '</div>';
		return $html;
	}
	
}