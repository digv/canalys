<?php

class Controller_Default extends Core_Controller {
	
	public function handleDefault() {
		$this->mustLogin();
		$view = $this -> prepView('View_Base');
		$view -> render ();
	}
}