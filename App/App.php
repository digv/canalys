<?php
/*
 * This provides global usefull staff
 * @author Gefferey
 * 
 */
class App {
	
	// Dispatch function to start the whole process
	

	public static function run() {
		
		$path = $_SERVER ['SCRIPT_URL'];
	
		//remove last trailing slash		
		if (substr($path, -1, 1) == '/') {	
					
			$path = substr($path, 0, strlen($path) - 1);		
		}
		
		$path = explode('/', $path);
		
		var_dump($path);
		
	}
	
	/*
	 * loads the given classname into memory if it isn't already there
	 */
	
	public static function loadClass($class) {
		
		// autodiscover the path from the class name		// Core_Controller becomes MUCO/Core/Controller.php		
		$path = App::findFilenameFromClassname ( $class );
		if (file_exists ( $_SERVER ['DOCUMENT_ROOT'] . '/../App/' . $path )) {
			
			require_once ($path);
		}
	}
	
	/*
	 * Determine a class's relative filename from its classname
	 */
	public static function findFilenameFromClassname($class) {
		
		return str_replace ( '_', DIRECTORY_SEPARATOR, $class ) . '.php';
	}
}

/***  Application autoloader */
function __autoload($class_name) {
	App::loadClass ( $class_name );
} 
