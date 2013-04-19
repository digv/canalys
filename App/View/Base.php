<?php

/*
 * Base view class to render layout
 */
class View_Base extends Core_View {
	
	/*
     * Ordered list of CSS files for display
     */
	public $display_css = array ();
	
	/*
     * Ordered list of Javascript include files
     */
	public $jsincludes = array ();
	
	/*
	 * render js files
	 */
    public function renderJS() {
		$return = '';
    	foreach ($this->jsincludes as $js) {
    		$return .= '<script type="text/javascript" src="' . $js . '"></script>';
    	}
    	return $return;
	}
	
	/*
	 * render css files
	 */
	public function renderCss() {
		$return = '';
		foreach ( $this->display_css as $css ) {
			$return .= "<link rel=\"stylesheet\" href=\"{$css}\" type=\"text/css\" />\n";
		}
		return $return;
	}
    
	/*
	 * render begin to render layout and necessary js and css, etc
	 */
	
	public function renderBegin() {
		
		
	}
	
	public function renderMain() {
		return 'first render test';
	}

}