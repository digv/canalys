<?php
class Controller_Staff extends Core_Controller {
	
	public function handleDefault() {
		$this->mustLogin();
		$view = $this->prepView('View_Staff');
		$view -> render ();
	}
}