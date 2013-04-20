<?php
class Controller_Staff extends Core_Controller {
	
	public function handleDefault() {
		$this->mustLogin();
		$model = new Database_Staff();
		$view = $this->prepView('View_Staff', $model);
		$view -> render ();
	}
	
	public function handleQbf () {
		$this->mustLogin();
		$model = new Database_Staff();
		$view = $this->prepView('View_Staff', $model);
		$view -> renderAjax ();
	}
}