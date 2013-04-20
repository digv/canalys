<?php
class View_Edit extends View_Base {
	
	public function renderMain() {
		$return = '<div class="edit-form">';
		
		$return .= $this->_model -> renderEditors ();
		$return .= '</div>';
		
		return $return;
	}
	
}