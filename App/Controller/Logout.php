<?php
class Controller_Logout extends Core_Controller {
	
	public function handleDefault() {
		unset($_SESSION['userName']);
		$helper = Helper_Url::getInstance();
		$url = $helper -> baseUrl();
		header('location:'. $url);
	}
}