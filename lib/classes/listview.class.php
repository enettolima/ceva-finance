<?php
	/**/
	class ListView {
		function build($class = null, $tdata = null, $script = TRUE){
			/* Missing actual table data information
			 * stop right here and return an error message*/
			/*if($tdata == null || !is_array($tdata)){
				return "ERROR - No table data passed to build function in Class ListView";
			}

			$id = rand();
			for ($col = 0; $col < count($tdata[0]); $col++){
				//$header_fields .= "<th>".translate($tdata[0][$col], $_SESSION['log_preferred_language'])."</th>";
			}
	
			for ($row = 1; $row < count($tdata); $row++){
				$body_rows .= "<tr>";
				for ($col = 0; $col < count($tdata[$row]); $col++){
          if(str_replace(" ", "", $tdata[$row][$col])!=""){
            $body_rows .= "<td>{$tdata[$row][$col]}</td>";
          }else{
            $body_rows .= "<td>&nbsp</td>";
          }
				}
				$body_rows .= "</tr>";
			}
		
			$header = "<thead>";
			$header .= $header_fields;
			$header .= "</thead>";

			$body = "<tbody>";
			$body .= $body_rows;
			$body .= "</tbody>";
      $out = '';
			if ($script) {
			$out .= "<script type=\"text/javascript\">	
				$(document).ready(function() { 
					$('#td{$id}').dataTable(); 
				}); 
			</script>";
			}
			$out .= "<table id='td{$id}' class='listview {$class}'>";
			$out .= $header;
			$out .= $body;
			$out .= "</table>";
			*/
			return $out;
		}
		
     function realbuild($class = NULL, $tdata = NULL, $function = NULL, $module = NULL, $total_records = NULL, $limit = NULL, $pager_current = NULL, $sort = NULL, $search_query = NULL, $build_pager = TRUE, $build_search = TRUE, $pager_length = 10, $container = ''){
			/* Missing actual table data information
			 * stop right here and return an error message*/
			if($tdata == null || !is_array($tdata)){
				return "ERROR - No table data passed to build function in Class ListView";
			}

			$id = rand();
			for ($col = 0; $col < count($tdata[0]); $col++){
				$header_fields .= "<th>{$tdata[0][$col]}</th>";
			}
			for ($row = 1; $row < count($tdata); $row++){
				if ($tr_class == 'odd') {
					$tr_class = 'even';
				}
				else {
					$tr_class = 'odd';
				}
				$body_rows .= '<tr class="' . $tr_class . '">';
				for ($col = 0; $col < count($tdata[$row]); $col++){
          if(str_replace(" ", "", $tdata[$row][$col])!=""){
            $body_rows .= "<td>{$tdata[$row][$col]}</td>";
          }
					else{
            $body_rows .= "<td>&nbsp</td>";
          }
				}
				$body_rows .= "</tr>";

			}

			$header = "<thead>";
			$header .= $header_fields;
			$header .= "</thead>";

			$body = "<tbody>";
			$body .= $body_rows;
			$body .= "</tbody>";
      $out = '';
			if ($build_search) {
			  $out .= build_search_form($function, $module, $container);
			}
			$out .= build_sort_form($function);
			$out .= "<table id='td{$id}' class='listview {$class}'>";
			$out .= $header;
			$out .= $body;
			$out .= "</table>";
			if ($build_pager) {
				$out .= build_pager($function, $module, $total_records, $limit, $pager_current, $sort, $search_query, $pager_length, $container);
			}
			return $out;
		}


	}

/**
 * This function builds a pager based on given parameters
 */
function build_pager($function, $module, $pager_total, $limit, $pager_current = 1, $sort = NULL, $query = NULL, $pager_length = 10, $container = '') {
  if ($container == '') {
    $container = 'null';
  }
  else {
    $container =  "'" . $container . "'";
  }
  $quantity = ceil($pager_total / $limit);
	// Links before current page
	for($i = $pager_current - $pager_length; $i <= $pager_current - 1; $i++) {
		if(!($i <=0)) {
			$items[$i]['page'] = $i;
			$items[$i]['class'] = 'pager-item pager-before';
		}
	}
	// Shows the actual page wihtout the link, just the number
	$items[$pager_current]['page'] = $pager_current;
	$items[$pager_current]['class'] = 'active';
	// Links after current page
	for($i = $pager_current + 1; $i <= $pager_current + $pager_length; $i++) {
	 if(!($i > $quantity)) {
		 $items[$i]['page'] = $i;
		 $items[$i]['class'] = 'pager-item pager-after';
	 }
	}
	if ($quantity > 1) {
		 $pager_first = 1;
		 $pager_last = $quantity;
	}
	if ($items) {
		$pager = '<ul class="pager">';
		$previous_page = $pager_current - 1;
		if ($quantity > 1 && $pager_current != 1) {
			$pager .= '<li class="pager-item pager-previous"><a onClick="javascript:proccess_information(\'' . $function . '_pager\', \'' . $function . '_pager\', \'' . $module . '\', null, \'pager_current|' . $previous_page . '\', null, ' . $container . ');">1</a></li>';
		}
		else {
			$pager .= '<li class="pager-item pager-previous disabled">' . $previous_page . '</li>';
		}
		foreach ($items as $item) {
			if ($item['class'] != 'active') {
				$pager .= '<li class="' . $item['class'] . '"><a onClick="javascript:proccess_information(\'' . $function . '_pager\', \'' . $function . '_pager\', \'' . $module . '\', null, \'pager_current|' . $item['page'] . '\', null, ' . $container . ');">' . $item['page'] . '</a></li>';
			}
			else {
				$pager .= '<li class="' . $item['class'] . '"><span>' . $item['page'] . '</span></li>';
			}
		}
		$next_page = $pager_current + 1;
		if ($quantity > 1 && $pager_current != $quantity) {
			$pager .= '<li class="pager-item pager-next"><a onClick="javascript:proccess_information(\'' . $function . '_pager\', \'' . $function . '_pager\', \'' . $module . '\', null, \'pager_current|' . $next_page . '\', null, ' . $container . ');">' . $next_page . '</a></li>';
		}
		else {
			$pager .= '<li class="pager-item pager-next disabled">' . $next_page . '</li>';
		}
		$pager .= '</ul>';
	}
	$pager_form = '<form id="' . $function . '_pager" name="' . $function . '_pager">
									 <input name="limit" type="hidden"  value="' . $limit . '" />
									 <input name="sort" type="hidden"  value="' . $sort . '" />
									 <input name="search_query" type="hidden"  value="' . $_GET['search_query'] . '" />
								 </form>';
	return $pager . $pager_form;
} // End of build_pager function


/**
 * Build Sort Header
 */
function build_sort_header ($function, $module, $fields, $sort, $container = '') {
  if ($container == '') {
    $container = 'null';
  }
  else {
    $container =  "'" . $container . "'";
  }
	if ($fields) {
		$i = 0;
		foreach ($fields as $field) {
			if ($field['field']) {
        $field['display'] = translate($field['display'],$_SESSION['log_preferred_language']);
        if ($sort == $field['field'] . ' ASC') {
	        $line[$i] = '<a class="sort asc" onClick="proccess_information(\'' . $function . '_sort\', \'' . $function . '_sort\', \'' . $module . '\', null, \'sort|' . $field['field'] . ' DESC\', null, ' . $container . ');">' . $field['display'] . '</a>';
	      }
	      elseif ($sort == $field['field'] . ' DESC') {
	        $line[$i] = '<a class="sort desc" onClick="proccess_information(\'' . $function . '_sort\', \'' . $function . '_sort\', \'' . $module . '\', null, \'sort|' . $field['field'] . ' ASC\', null, ' . $container . ');">' . $field['display'] . '</a>';
	      }
	      else {
		      $line[$i] = '<a class="sort" onClick="proccess_information(\'' . $function . '_sort\', \'' . $function . '_sort\', \'' . $module . '\', null, \'sort|' . $field['field'] . ' ASC\', null, ' . $container . ');">' . $field['display'] . '</a>';
	      }
			}
			else {
			  $line[$i] = $field['display'];
			}
			$i++;
		}
	}
	return $line;
}

/**
 * Search build
 */
function build_search_query($query, $search_fields, $exceptions = NULL) {
  if ($search_fields) {
    foreach($search_fields as $field) {
		  if ($exceptions[$field]) {
				if (is_array($exceptions[$field])) {
				  foreach ($exceptions[$field] as $key => $value) {
				    $pos = strpos(strtolower($value), strtolower($query));
            if ($pos !== false) {
				      $query_fields[] = "$field LIKE '%$key%'";
					  }
				  }
			  }
				elseif ($exceptions[$field] == 'date') {
					/**
					 * This is just for visual compatibility when you print a date in your listiview colunm like 02/27/2010
					 * it's going to transfrom the content from the search box to 2010-02-27 but if there is no '/' then you could type values in the search box like 2010-02 or 2010-02-27 and is going to work too
					 */
					if (strstr($query, '/')) {
					  $date = str_replace('/', '-', $query);
					  if ( strlen($query) == 10) {
					    $date = substr($query,6,4) . '-' . substr($query,0,2) . '-' . substr($query,3,2);
					  }
					  if ( strlen($query) == 7) {
					    $date = substr($query,3,4) . '-%-' . substr($query,0,2);
					  }
				    $query_fields[] = "$field LIKE '%$date%'";
					}
					else {
					  $query_fields[] = "$field LIKE '%$query%'";
					}
			  }
		  }
		  else {
		    $query_fields[] = "$field LIKE '%$query%'";
			}
		}
		$query = ' AND (' . implode(' OR ', $query_fields) . ')';
	}
	//die($query);
	return $query;
}

/**
 * Build Search Form
 */
function build_search_form($function, $module, $container = '') {
  if ($container == '') {
    $container = 'null';
  }
  else {
    $container =  "'" . $container . "'";
  }
	return '<form id="search_query_form" name="search_query_form" action="javascript:proccess_information(\'search_query_form\', \'' . $function . '_search\', \'' . $module . '\',  null, null, null, '. $container . ');"><input id="search_query" name="search_query" type="text" value="' . $_GET['search_query'] . '" /><input id="search_query_submit" class="button" type="submit" value="Search" /></form>';
}

/**
 * Build Sort Form
 */
function build_sort_form($function) {
	return '<form id="'. $function . '_sort" name="' . $function . '_sort"><input type="hidden" name="search_query" value="' . $_GET['search_query'] . '" /></form>';
}
	
?>
