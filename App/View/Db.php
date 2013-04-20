<?php
class View_Db extends View_Base {
	
	protected $baseUrl ;
	
	/*
	 * render html result table
	 */
	public function resultTable() {
		
		$html = '';
		
		$cols = $this->_model->getListingColumns ();
		
		foreach ( $this->_model->getListingRows () as $row ) {
			$html .= "<tr>";
			foreach ( $cols as $colname ) {
				$html .= "<td>";
				$html .= $this->_model->renderListingCell ( $colname, $row );
				$html .= "</td>";
			}
			
			$html .= "</tr>\n";
		
		}
		
		return $html;
	}
	
	/*
	 * parse url params
	 */
	
	public function parseParams() {
		$params = array ();
		
		$params ['pagesize'] = isset ( $_GET ['p'] ) ? intval ( $_GET ['p'] ) : 25;
		$params ['offset'] = isset ( $_GET ['o'] ) ? intval ( $_GET ['o'] ) : 0;
		$params ['sort'] = isset ( $_GET ['sf'] ) ? preg_replace ( '/[^a-z0-9_\.]/i', '', $_GET ['sf'] ) : '';
		$params ['so'] = isset ( $_GET ['so'] ) ? intval ( $_GET ['so'] ) : 1;
		$params ['order'] = $params ['so'] > 0 ? 'asc' : 'desc';
		
		$params ['qbf'] = array ();
		//get the qbf parameters
		foreach ( $_GET as $name => $value ) {
			$matches = array ();
			if (preg_match ( '/^qbf_(.*)$/', $name, $matches )) {
				$matches [1] = substr($matches [1], 0,  strpos($matches[1], '_')). '.'. substr($matches [1], strpos($matches[1], '_')+ 1);
				$params ['qbf'] [$matches [1]] = $value;
			}
		}
		
		return $params;
	}
	
	public function encodeParams($params) {
		if (func_num_args () > 1) {
			$c = (func_num_args () - 1) / 2;
			for($i = 0; $i < $c; $i ++) {
				$name = func_get_arg ( $i * 2 + 1 );
				$value = func_get_arg ( $i * 2 + 2 );
				$params [$name] = $value;
			}
		}
		
		$url = 'p=' . $params ['pagesize'];
		$url .= '&o=' . $params ['offset'];
		if (strlen ( $params ['sort'] )) {
			$url .= '&sf=' . $params ['sort'];
			$url .= '&so=' . $params ['so'];
		}
		
		foreach ( $params ['qbf'] as $name => $value ) {
			$url .= '&qbf_' . $name . '=' . urlencode ( $value );
		}
		
		return $url;
	}
		
	
	/*
	 * Render an ajax result
	 */
	public function renderAjax() {
		$params = $this->parseParams();

		$this->_model->prepareListing($params);

		$hdrs = $this->_model->getListingHeaders();
		$cols = $this->_model->getListingColumns();
		//$total = $this->_model->getTotalRowCount();

		$result = array ();

		$result['resultrows'] = $this->resultTable();
		//$result['nav'] = $this->pageControls($params);
		$result['sortrow'] = $this->sortRow($params);

		$jsonResult = json_encode($result);
		header('Content-Type: application/json');
		echo $jsonResult;
	}
	
	public function renderQbfJs () {
		$html = <<<html
		<script type="text/javascript">
		function handleQbfCall () {
		
			var url = '$this->baseUrl';
			
			var query = '';
			
			var sep = '';
			$('.qbf').each (function(index, Ele){
				
				var id = $(this).attr('id');
				var value = $.trim($(this).val ());
				if(value) {
				
					query = query + sep + id + '=' + value;
					sep = '&';
				}
			
			});
			
			url = url + '?' + query;
			$.ajax ({
				url:url,
				type:'get',
				dataType:'json',
				success:function (text) {
					
					var json=eval('('+text+')');
					$('.listbody').html(json.resultrows);
					$('.sortrow').html(json.sortrow);
	
				},
			
			});
		
		}
		
		
		</script>
		
html;

		return $html;
	}
	
}
