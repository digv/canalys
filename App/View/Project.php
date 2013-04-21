<?php
class View_Project extends View_Db {
	
	protected $baseUrl = "http://ca.digv.co/index.php/project/qbf";
	
	public $heading = "Project Management";
	
	/*
	 * sort rows
	 */
	
	public function sortRow($params) {
		
		$html = "";
		
		$hdrs = $this->_model->getListingHeaders ();
		$cols = $this->_model->getListingColumns ();
		$base = 'http://ca.digv.co/index.php/project';
		
		foreach ( $hdrs as $idx => $hdr ) {
			$col = $cols [$idx];
			
			$html .= "<td>";
			if ($col == $params ['sort']) {
				$html .= "<b>";
				$url = $base . "?" . $this->encodeParams ( $params, 'offset', 0, 'sort', $col, 'so', - $params ['so'] );
				$html .= "<a title=\"Reverse sort order\" href=\"$url\">$hdr</a>";
				
				$html .= "</b>";
			} else {
				$url = $base . "?" . $this->encodeParams ( $params, 'offset', 0, 'sort', $col, 'order', 1 );
				$html .= "<a title=\"Sort by $hdr\" href=\"$url\">$hdr</a>";
			}
			
			$html .= "</td>\n";
		}
		
		return $html;
	
	}
	public function renderMain() {
		//get url params and parse
		$params = $this->parseParams();
		
		$return = "<div class='edit-form'>";
		$return .= "<div class='heading-title'><h1>Project Management</h1></div>";
		
		$this->_model-> prepareListing ($params);
		
		$return .= '<table class="datalist">';
		
		//thead starts
		$return .= "<thead>";
		$return .= "<tr class='sortrow'>";
		$return .= $this->sortRow($params);
		$return .= "</tr>";
		$return .= "<tr class='sortqbf'>";
		foreach ($this->_model->getListingColumns() as $col) {
			$return .= "<td>";
			if ($this->_model -> canQbf ($col)) {
				$value = isset ($params['qbf'][$col]) ? htmlentities($params['qbf'][$col]) : '';
				$return .= "<input class=\"qbf\" type=\"text\" id=\"qbf_{$col}\" ";
				$return .=" value=\"$value\" placeholder=\"Type here to quick filter\" />";
			}
			$return .= "</td>";
		}
		$return .= "</tr>";
		$return .= "</thead>";	//thead ends
		
		$return .= "<tbody class='listbody'>";
		$return .= $this->resultTable();
		$return .= "</tbody>";
		
		
		$return .= '</table></div>';
		
		$return .= $this->renderQbfJs();
		
		return $return;
	}
		
	/*
	 * render usefull link sidebar
	 */
	public function renderSideBar() {
		
		$return = '<div class="block">';
		$return .= '<div class="block-title"><strong><span>Useful Links</span></strong></div>';
		$return .= '<ul>';
		$return .= '<li>';
		$return .= '<a href="">Work assignment index</a>';
		$return .= '</li>';
		$return .= '<li>';
		$return .= '<a href="">Create new assignment</a>';
		$return .= '</li>';
		$return .= '</ul>';
		$return .= '</div>';
		return $return;
	}
}