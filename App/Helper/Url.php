<?php
use Zend\Crypt\PublicKey\Rsa\PublicKey;
class Helper_Url {
	
	public static function getInstance () {
		
		return new Helper_Url();
	}
	
	
	public function baseUrl () {
		
		
		return 'http://'. $_SERVER['SERVER_NAME'];
	}
}