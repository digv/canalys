<?php
class Controller_Staff extends Core_Controller {
	
	public function handleDefault() {
		$this->mustLogin();
		$model = new Database_Staff();
		$view = $this->prepView('View_Staff', $model);
		$view -> render ();
	}
	
	/*
	 * handle quick filter
	 */
	public function handleQbf () {
		$this->mustLogin();
		$model = new Database_Staff();
		$view = $this->prepView('View_Staff', $model);
		$view -> renderAjax ();
	}
	
	/*
	 * handle edit
	 */
	
	public function handleEdit () {
		$this->mustLogin();
		
		$args = $this->getRequestArgs();
		$model = new Database_Staff();
		
		if (isset($_POST['savechanges'])) {
			$model -> save();
		} else if (isset($_POST['deleterecord'])) {
			
		}
		if (isset($args[0]) && is_numeric($args[0])) {
			$model -> prepareEditor($args[0]);
		}
		$view = $this->prepView('View_Edit', $model);
		$view -> render ();
	}
}