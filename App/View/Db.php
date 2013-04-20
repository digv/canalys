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
	 * sort rows
	 */
	
	public function sortRow($params) {
		
		$html = "";
		
		$hdrs = $this->_model->getListingHeaders ();
		$cols = $this->_model->getListingColumns ();
		$base = '/database/list/';
		
		foreach ( $hdrs as $idx => $hdr ) {
			$col = $cols [$idx];
			
			$html .= "<td>";
			if ($col == $params ['sort']) {
				$html .= "<b>";
				$url = $base . "?" . $this->encodeParams ( $params, 'offset', 0, 'sort', $col, 'so', - $params ['so'] );
				$html .= "<a title=\"Reverse sort order\" href=\"$url\">$hdr</a>";
				
				$html .= "</b>";
			} else {
				$url = $base . "?" . $this->encodeParams ( $params, 'offset', 0, 'sort', $col, 'order', 1 );
				$html .= "<a title=\"Sort by $hdr\" href=\"$url\">$hdr</a>";
			}
			
			$html .= "</td>\n";
		}
		
		return $html;
	
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
			
			});
		
		}
		
		
		</script>
		
html;

		return $html;
	}
	
}
