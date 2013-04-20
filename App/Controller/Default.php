<?php

class Controller_Default extends Core_Controller {
	
	public function handleDefault() {
		$this->mustLogin();
		$model = new Database_WorkAssignment();
		$view = $this->prepView('View_WorkAssignment', $model);
		$view -> render ();
	}
	
	public function handleQbf() {
		$this->mustLogin ();
		$model = new Database_WorkAssignment ();
		$view = $this->prepView ( 'View_WorkAssignment', $model );
		$view->renderAjax ();
	}
}