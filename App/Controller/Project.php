<?php
class Controller_Project extends Core_Controller {
	
	public function handleDefault() {
		$this->mustLogin();
		$view = $this -> prepView('View_Project');
		$view -> render ();
	}
}