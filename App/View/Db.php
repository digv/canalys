<?php
class View_Db extends View_Base {
	
	/*
	 * render html result table
	 */
	public function resultTable() {
		
		$html = '';
		
		$cols = $this->_model->getListingColumns ();
		
		foreach ( $this->_model->getListingRows () as $row ) {
			$html .= "<tr>";
			foreach ( $cols as $colname ) {
				$html .= "<td>";
				$html .= $this->_model->renderListingCell ( $colname, $row );
				$html .= "</td>";
			}
			
			$html .= "</tr>\n";
		
		}
		
		return $html;
	}
	
}
