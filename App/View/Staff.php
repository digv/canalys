<?php
class View_Staff extends View_Db {
	
	public function renderMain() {
		$this->_model-> prepareListing (array());
		$return = "<table>";
		$return .= $this->resultTable();
		$return .= '</table>';
		
		return $return;
	}
}