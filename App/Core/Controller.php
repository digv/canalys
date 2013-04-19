<?php
use Zend\Crypt\PublicKey\Rsa\PublicKey;
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
	
	/*
	 * must login to process
	 */
	
	public function mustLogin () {
		
		if (isset ( $_POST ['commit'] )) {
			$model = new Model_User ();
			$login = trim ( $_POST ['login'] );
			$pwd = trim ( $_POST ['password'] );
			$result = $model->login ( $login, $pwd );
			if ($result) {
				$_SESSION ['userName'] = $result ['name'];
				return '';
			}
		}
		if (!$_SESSION['userName']) {
			$this-> renderLoginForm();
		}
	}
	
	/*
	 * render login form and process login 
	 */
	
	public function renderLoginForm () {
		$view = new View_Login();
		$view -> setModel($model);
		$view -> render();
		exit;
	}
	
}