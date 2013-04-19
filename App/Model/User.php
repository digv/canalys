<?php
class Model_User {
	
	
	//try to login
	public function login ($username, $pwd) {
		$md5pwd = md5 ($pwd);
		$sql = "SELECT name FROM admin WHERE name= ?  AND pwd = ? ";
		$result = App::getDb() -> query_one ($sql, array($username, $md5pwd));
		var_dump($md5pwd);
		return $result;
	}
}