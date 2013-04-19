/**
 * 
 */

var searchSite = "site:www.canalys.com";
$(document).ready (function () {
	$('#search_show').change (function () {
		
		$('#search_str').val (searchSite + '  ' + $(this).val());
		
	});
	
})