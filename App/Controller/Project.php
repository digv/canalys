<?php
class Controller_Project extends Core_Controller {
	
	public function handleDefault() {
		$this->mustLogin();
		$model = new Database_Project();
		$view = $this->prepView('View_Project', $model);
		$view -> render ();
	}
	
	public function handleQbf() {
		$this->mustLogin ();
		$model = new Database_Project ();
		$view = $this->prepView ( 'View_Project', $model );
		$view->renderAjax ();
	}
}