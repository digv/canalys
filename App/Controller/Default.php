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
		
	/*
	 * handle edit
	 */
	
	public function handleEdit() {
		$this->mustLogin ();
		
		$args = $this->getRequestArgs ();
		$model = new Database_WorkAssignment ();
		
		if (isset ( $_POST ['savechanges'] )) {
			$value = $model->save ();
			
			if (is_numeric ( $value )) {
				header ( "location:http://ca.digv.co/index.php/default/edit/" . $value );
			} else if ($value) {
				$model->msg = "Successfully saved !";
			} else {
				$model->msg = "Save failed !";
			}
		} else if (isset ( $_POST ['deleterecord'] )) {
			if ($model->delete ()) {
				header ( "location:http://ca.digv.co/index.php" );
			}
		}
		if (isset ( $args [0] ) && is_numeric ( $args [0] )) {
			$model->prepareEditor ( $args [0] );
		}
		$view = $this->prepView ( 'View_Edit', $model );
		$view->render ();
	}
}