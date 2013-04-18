<?php
/*
 * This provides global usefull staff
 * @author Gefferey
 * 
 */
class App {
	
	const METHOD_PREFIX = 'handle';
	const CONTROLLER_PREFIX = 'Controller';
	
	
	// Dispatch function to start the whole process

	public static function run() {
		
		$path = $_SERVER ['PHP_SELF'];
	
		//remove last trailing slash		
		if (substr($path, -1, 1) == '/') {	
					
			$path = substr($path, 0, strlen($path) - 1);		
		}
		
		$path = explode('/', $path);
		//always remove the first
		array_shift($path);
		
		//as we didnt do url rewrite, so we take path[1] as controller name, path[2] as action,
		// the following as the params
		$controllerName = (isset ($path[1]) && App :: isValidIdentifier($path[1])) ? $path[1] : 'default';
		
		//get controller class name and upper case the first letter
		$controllerName = strtolower($controllerName);
		$controllerName = App::CONTROLLER_PREFIX. '_'. ucFirst($controllerName);
		
		$controller = new $controllerName ();
		//get the method name
		
		$method = (isset ($path[2]) && App :: isValidIdentifier($path[2])) ? $path[2] : 'default';
		$method = strtolower($method);
		$method = App::METHOD_PREFIX. ucfirst($method);
		
		//begin to run
		
		$controller -> {$method} ();
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
	
	/**
	 * Indicates whether given string is a valid controller or method identifier
	 */
	public static function isValidIdentifier($id) {
		return preg_match ( '/^[a-zA-Z0-9 \_\"\'\,\.]+$/', $id ) ? true : false;
	}
}

/***  Application autoloader */
function __autoload($class_name) {
	App::loadClass ( $class_name );
} 
