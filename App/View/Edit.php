<?php
class View_Edit extends View_Base {
	
	public function renderMain() {
		$msg = $this->_model ->msg;
		$return = '<div class="edit-form">';
		$return .= "<div class='msg'>{$msg}</div>";
		$return .= '<form method="post" />';
		
		$return .= $this->_model -> renderEditors ();
		
		$return .= '<div class="field">';
		$return .= '<button class="edit-button savechanges" type="submit" name="savechanges">Save</button>';
		$return .= '<button class="edit-button deleterecord" type="submit" name="deleterecord">Delete</button>';
		$return .= '</div>';
		
		$return .= '</form>';
		$return .= '</div>';
		
		return $return;
	}
		
	/*
	 * render usefull link sidebar
	 */
	public function renderSideBar() {
		
		$helper = Helper_Url::getInstance ();
		$baseUrl = $helper->baseUrl ();
		$return = '<div class="block">';
		$return .= '<div class="block-title"><strong><span>Useful Links</span></strong></div>';
		$return .= '<ul>';
		$return .= '<li>';
		$return .= '<a href="' . $baseUrl . 'staff/edit">Add new staff</a>';
		$return .= '</li>';
		$return .= '<li>';
		$return .= '<a href="' . $baseUrl . 'project/edit/">Create new project</a>';
		$return .= '</li>';
		$return .= '<li>';
		$return .= '<a href="' . $baseUrl . 'default/edit/">Create new assignment</a>';
		$return .= '</li>';
		$return .= '</ul>';
		$return .= '</div>';
		return $return;
	}
	
}