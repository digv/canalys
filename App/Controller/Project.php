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
		
	/*
	 * handle edit
	 */
	
	public function handleEdit() {
		$this->mustLogin ();
		
		$args = $this->getRequestArgs ();
		$model = new Database_Project ();
		
		if (isset ( $_POST ['savechanges'] )) {
			$value = $model->save ();
			
			if (is_numeric ( $value )) {
				header ( "location:http://ca.digv.co/index.php/project/edit/" . $value );
			} else if ($value) {
				$model->msg = "Successfully saved !";
			} else {
				$model->msg = "Save failed !";
			}
		} else if (isset ( $_POST ['deleterecord'] )) {
			if ($model->delete ()) {
				header ( "location:http://ca.digv.co/index.php/project" );
			}
		}
		if (isset ( $args [0] ) && is_numeric ( $args [0] )) {
			$model->prepareEditor ( $args [0] );
		}
		$view = $this->prepView ( 'View_Edit', $model );
		$view->render ();
	}
}