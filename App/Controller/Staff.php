<?php
class Controller_Staff extends Core_Controller {
	
	public function handleDefault() {
		$this->mustLogin();
		$model = new Database_Staff();
		$model -> prepareListing(array());
		$view = $this->prepView('View_Staff');
		$view -> render ();
	}
}