<?php
Class Core_Controller {
	
	/*
	* Storing of arguments from app run
	*/
	private $_requestArgs = array ();
	
	
	// create view and inform it with model and controller
	public function prepView($view, $model = null) {
		
		//create the view/model if not supplied
		if (is_string($view)) {
			$view = new $view ();
		}
		//set controller
		$view->setController($this);
		
		//set model
		$view->setModel($model);
		
		//set the URL-requested arguments (e.g. field ID)
		//$this->set('requestArgs', $this->getRequestArgs());

		return $view;
	}
	
	/*
	 * set request args from url 
	 */
	public function setRequestArgs(array $args = null) {
		($args) ? $this->_requestArgs = $args : 0;
	}
	
	
	/*
	 * get request args
	 */
	public function getRequestArgs() {
		return $this->_requestArgs;
	}
	
	/*
	 * postRequest function
	 */
	public function postRequest () {
		
	}
	
	/*
	 * preRequest function 
	 */
	
	public function preRequest () {
		session_start();
	}
	
}