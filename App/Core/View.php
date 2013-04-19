<?php
class Core_View {
	
	/* 
	 * model passed via controller
	 * 
	 */
	protected $_model;
	
	/* 
	 * controller passed via controller
	 * 
	 */
	
	protected $_controller;
	
	
	/*
	 * H1 heading
	 */
	
	public $heading;
	
	/*
	* Set the model
	* @param object $model
	*/
	public function setModel($model) {
		$this->_model = & $model;
	}
	
	/*
	 * Set the controller.
	 * @param object $controller - Core_Controller derived object
	 */
	public function setController($controller) {
		$this->_controller = & $controller;
	}

	
	/* override this to provide any functionality ocurring before render
	 * 
	 */
	protected function preRender() {
		
	}
		
	/*override to privide header
	 * 
	 */
	
	protected function doHeader() {
		header ( "Content-type: text/html; charset=UTF-8" );
	}
	
	
	protected function renderBegin () {
		
	}
	
	/*
	 * Render the H1 heading if needed
	 */
	
	protected function renderHeading() {
		
		if (isset ( $this->heading )) {
			return "<h1>{$this->heading}</h1>";
		}
	}
	
	protected function renderEnd () {
		
	}
	
	protected function postRender () {
		
	}
			
	/*
	 *  view renderer
	 *  
	 */
	public function render() {
		
		$this->preRender();

		$this->doHeader();

		//renderMain provide the main content
		$main = $this->renderMain();
		//renderBegin provide the css and js, etc
		$begin = $this->renderBegin();
		$heading = $this->renderHeading();

		echo $begin;
		echo $heading;
		echo $main;
		$this->renderEnd();
		echo $this->postRender();
	}
}