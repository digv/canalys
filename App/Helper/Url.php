<?php
use Zend\Crypt\PublicKey\Rsa\PublicKey;
class Helper_Url {
	
	public static function getInstance () {
		
		return new Helper_Url();
	}
	
	
	public function baseUrl () {
		
		
		return 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
	}
	
	public function cleanUrl () {
		return str_replace('index.php', '', $this->baseUrl());
	}
}