<?php
class View_Staff extends View_Db {
	
	protected $baseUrl = "http://ca.digv.co/index.php/staff/qbf";
	public function renderMain() {
		//get url params and parse
		$params = $this->parseParams();
		
		
		$return = "<h1>Staff Management</h1>";
		
		$this->_model-> prepareListing ($params);
		
		$return .= '<table class="nav">';
		
		//thead starts
		$return .= "<thead>";
		$return .= "<tr>";
		$return .= $this->sortRow($params);
		$return .= "</tr>";
		$return .= "<tr>";
		foreach ($this->_model->getListingColumns() as $col) {
			$return .= "<td>";
			if ($this->_model -> canQbf ($col)) {
				$value = isset ($params['qbf'][$col]) ? htmlentities($params['qbf'][$col]) : '';
				$return .= "<input class=\"qbf\" type=\"text\" id=\"qbf_{$col}\"  value=\"$value\">";
			}
			$return .= "</td>";
		}
		$return .= "</tr>";
		$return .= "</thead>";	//thead ends
		
		
		$return .= "<tbody>";
		$return .= $this->resultTable();
		$return .= "</tbody>";
		
		
		$return .= '</table>';
		
		$return .= $this->renderQbfJs();
		
		return $return;
	}
}