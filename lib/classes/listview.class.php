<?php
/**
 * ListView Class
 */
class ListView {
	/**
	 * Method build...
	 * Just a helper module that invokes the twig table template
	 */
	function build($rows, $headers = NULL, $options = array()) {

		global $twig;

		$render = array(
			'rows' => $rows,
			'headers' => $headers,
			'show_headers' => isset($options['show_headers']) ? $options['show_headers'] : TRUE,
			'page_title' => isset($options['page_title']) ? $options['page_title'] : '',
			'page_subtitle' => isset($options['page_subtitle']) ? $options['page_subtitle'] : '',
			'empty_message' => isset($options['empty_message']) ? $options['empty_message'] : '',
			'pager_items' => isset($options['pager_items']) ? $options['pager_items'] : '',
			'search_string' => isset($options['search_string']) ? $options['search_string'] : '',
		  'limit' => isset($options['limit']) ? $options['limit'] : '',
		  'function' => isset($options['function']) ? $options['function'] : '',
		  'update_row_id' => isset($options['update_row_id']) ? $options['update_row_id'] : '',
	    'table_form_id' => isset($options['table_form_id']) ? $options['table_form_id'] : '',
		  'table_form_process' => isset($options['table_form_process']) ? $options['table_form_process'] : '',
		 );

		$template = $twig->loadTemplate('table.html');
		$template->display($render);
	}
}

/**
 * This function builds a pager based on given parameters
 */
function build_pager($function, $module, $pager_total, $limit, $pager_current = 1, $sort = NULL, $query = NULL, $pager_length = 10) {
  $quantity = ceil($pager_total / $limit);



  // Links before current page
  for($i = 1; $i <= $quantity; $i++) {
		// theme_link_process_information($text, $formname, $func, $module, $options = array())
		// <a href="javascript:proccess_information('user_list_pager', 'user_list_pager', 'user', null, 'pager_current|1', null, null);">2</a>
		$items[$i]['link'] = theme_link_process_information($i, $function . '_pager', $function . '_pager', $module, array('extra_value' => 'pager_current|' . $i));
		$items[$i]['class'] = 'pager-item';
		if ($i == $pager_current) {
		  $items[$i]['class'] = 'active';
		}
	}


	if (!empty($items)) {
		/* Disabling previous/next links
		$previous_page = $pager_current - 1;
		if ($quantity > 1 && $pager_current != 1) {
			array_unshift($items, array(
        'link' => theme_link_process_information('<', $function . '_pager', $function . '_pager', $module, array('extra_value' => 'pager_current|' . $previous_page)),
				'class' => 'previous-item',
			));
		}
		$next_page = $pager_current + 1;
		if ($quantity > 1 && $pager_current != $quantity) {
		  array_push($items, array(
        'link' => theme_link_process_information('>', $function . '_pager', $function . '_pager', $module, array('extra_value' => 'pager_current|' . $next_page)),
				'class' => 'next-item',
		  ));
		}
		*/
		return $items;
	}
	else {
		return FALSE;
	}
}


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
