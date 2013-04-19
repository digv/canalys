<?php

class Controller_Default extends Core_Controller {
	
	public function handleDefault() {
		$arr = App::getDb() -> query ('select * from employee');
		var_dump($arr);
		$view = $this -> prepView('View_Base');
		$view -> render ();
	}
}