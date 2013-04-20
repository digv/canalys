<?php
class View_Edit extends View_Base {
	
	public function renderMain() {
		
		$return = '<div class="edit-form">';
		$return .= '<form method="post" />';
		
		$return .= $this->_model -> renderEditors ();
		
		$return .= '<div class="field">';
		$return .= '<button class="edit-button" type="submit" name="savechanges">Save</button>';
		$return .= '<button class="edit-button" type="submit" name="deleterecord">Delete</button>';
		$return .= '</div>';
		
		$return .= '</form>';
		$return .= '</div>';
		
		return $return;
	}
	
}