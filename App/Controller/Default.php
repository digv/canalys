<?php

class Controller_Default extends Core_Controller {
	
	public function handleDefault() {
		$view = $this -> prepView('View_Base');
		$view -> render ();
	}
}