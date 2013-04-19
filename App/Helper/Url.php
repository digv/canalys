<?php
use Zend\Crypt\PublicKey\Rsa\PublicKey;
class Helper_Url {
	
	public static function getInstance () {
		
		return new Helper_Url();
	}
	
	
	public function baseUrl () {
		
		var_dump($_SERVER);
		return 'ca.digv.co';
	}
}