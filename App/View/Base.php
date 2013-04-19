<?php

/*
 * Base view class to render layout
 */
class View_Base extends Core_View {
	
	/*
	 * page title
	 * 
	 */
	
	public $pageTitle = 'Dig we -- Knowledge is infinite';
	
	/*
     * Ordered list of CSS files for display
     */
	public $display_css = array (
		'css/style.css',
	);
	
	/*
     * Ordered list of Javascript include files
     */
	public $jsincludes = array (
		'js/jquery-1.9.1.min.js',
		'js/common.js',
	);
	
	/*
	 * render js files
	 */
    public function renderJS() {
		$return = '';
		$helper = Helper_Url::getInstance();
    	foreach ($this->jsincludes as $js) {
    		$js = $helper -> cleanUrl(). '/'. $js;
    		$return .= '<script type="text/javascript" src="' . $js . '"></script>';
    	}
    	return $return;
	}
	
	//get page title
	public function getPageTitle() {
		
		return $this->pageTitle;
	}
    
    
	/*
	 * render css files
	 */
	public function renderCss() {
		$return = '';
		$helper = Helper_Url::getInstance();
		foreach ( $this->display_css as $css ) {
			$css = $helper -> cleanUrl(). '/'. $css;
			$return .= "<link rel=\"stylesheet\" href=\"{$css}\" type=\"text/css\" />\n";
		}
		return $return;
	}
		
	/*
	 * render begin to render layout and necessary js and css, etc
	 */
	
	public function renderBegin() {
		$helper = Helper_Url::getInstance();
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $this->getPageTitle(); ?></title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<link rel="icon" href="<?php echo $helper -> baseUrl(); ?>/images/digv.ico" type="image/x-icon" /> <!-- company favicon -->

<!-- style css -->

<?php echo $this->renderCss(); ?>

<!-- js -->

<?php echo $this-> renderJS() ; ?>
</head>
<body>
<body>

    <div class="wrapper">   <!-- div wrapper starts -->
    
        <div class="page">  <!-- div page starts -->
        
            <div class="header-container">  <!-- div header container starts -->
            
                <div class="header">    <!-- div header starts -->
                	<?php echo $this -> renderHeader() ;?>
                </div>  <!-- div header ends -->
                <div class="nav-container"> <!-- div nav container starts -->
                	<?php echo $this -> renderNav() ;?>
                </div>  <!-- div nav container ends -->
            </div>  <!-- div header container ends -->
            
            <div class="main-container col2-right-layout">    <!-- div main container starts -->
            
            	<div class="main">  <!-- div main starts -->
            	
            		<div class="col-main">  <!-- div col main starts -->
                
<?php

	}
	
	
	public function renderEnd() {
		
		$return = <<<html
            	</div>  <!-- div col main ends -->
                    
                    <div class="col-right sidebar"> <!-- div col right starts -->
html;

		$return .= $this -> renderSideBar ();
	
		$return .= <<<html
	
			</div>  <!-- div col right ends -->
            	</div>  <!-- div main ends -->
            </div>  <!-- div main container ends -->
html;
	
		$return .= $this -> renderFooter();
		echo $return;
	}
	
	//side bar
	public function renderSideBar () {
		
	}
	
	
	//footer
	public function renderFooter () {
		
		$return = <<<html
		<div class="footer-container">    <!-- div footer container starts -->
            
                <div class="footer">    <!-- div footer starts -->
                
                    <div class="footer-right">&copy; 2013 Jianghai Zhang. All Rights Reserved.</div>
                    
                </div>  <!-- div footer ends -->
            
            </div>  <!-- div footer container ends -->
            
        </div>  <!-- div page ends -->
        
    </div>  <!-- div wrapper ends -->
    
</body>
</html>
		
html;

		return $return;
		
	}
	
	
	public function renderMain() {
		return 'first render test';
	}
	
	//navigation
	public function renderNav () {
		$helper = Helper_Url::getInstance();
		$baseUrl = $helper -> baseUrl();
		
		$return  = <<<html
					<ul id="nav2">
                        <li class=""><a href="{$baseUrl}"><span>Home</span></a></li>
                        <li class=""><a href="{$baseUrl}/staff"><span>Staff</span></a></li>
                        <li class=""><a href="{$baseUrl}/project"><span>Project</span></a></li>
                        <li class=""><a href="{$baseUrl}/logout"><span>Logout</span></a></li>
                        <li class=""><a href="d.html"><span>Assignment</span></a></li>
                        <li class=""><a href="e.html"><span>Contact us</span></a></li>
                        <li class="last"><a href="f.html"><span>Help</span></a></li>
                    </ul>
                    <div class="clear_both">
                        <span></span>
                    </div>
html;
		return $return;
	}
	
	public function renderHeader () {
		
		$helper = Helper_Url::getInstance();
		$baseUrl = $helper -> cleanUrl();
		$return = <<<html
		<div class="header">    <!-- div header starts -->
                
                    <div class="left-header">   <!-- div left header starts -->
                    
                        <h1 class="logo">
                            <a class="logo" title="Dig we" href=""><img alt="Dig we" src="{$baseUrl}/images/logo.jpg"></a>
                        </h1>
                        
                    </div>  <!-- div left header ends -->
                
                    <div class="quick-access">  <!-- div quick access starts -->
                    
                        <form id="search_mini_form" method="get" action="http://www.google.com.hk/search" target="_blank">    <!-- form starts -->
                        
                            <div class="form-search">   <!-- div form search starts -->
                            
                                <label for="search">Search:</label>
                                <input id="search_show" class="input-text" type="text" maxlength="128" value="" name="as_q"  />
                                <input id="sitesearch" class="input-text" type="hidden" value="canalys.com" maxlength="128"  name="sitesearch" />
                                <button class="button" title="search" type="submit" ><span><span>Search</span></span></button> 
                            
                            </div>   <!-- div form search ends -->
                                          
                        </form> <!-- form ends -->
                        
                    </div>  <!-- div quick access ends -->
                    <div class="clear_both"></div>
                </div>  <!-- div header ends -->
html;

		return $return;
	}
		

}