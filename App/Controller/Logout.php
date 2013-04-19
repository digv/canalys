<?php
class Controller_Logout extends Core_Controller {
	
	public function handleDefault() {
		unset($_SESSION['userName']);
		header('location:'. $_SERVER['HTTP_HOST']);
	}
}