<?php
function create_sort_headers(&$table, $array) {
	foreach ($array as $field=>$name) {
		$link = $_SERVER['PHP_SELF'] . '?order=' . urlencode($field) . '&amp;sort=';
		if ($_REQUEST['order'] == $field) {
			if ($_REQUEST['sort'] == 'asc') {
				$link .= 'desc';
				$name .= '&nbsp;&darr;';
			}
			else {
				$link .= 'asc';
				$name .= '&nbsp;&uarr;';
			}
		}
		else {
			$link .= 'asc';
		}
	
		$request = array();
		foreach (array_merge($_GET, $_POST) as $key=>$value) {
			if ($key != 'order' && $key != 'sort') {
				$request[] = urlencode($key) . '=' . urlencode($value);
			}
		}
		if (count($request)) {
			$link .= '&amp;' . implode('&amp;', $request);
		}
		
		$table->AddHeader('<a href="' . $link . '">' . $name . '</a>');
	}
}

function sort_result_array(&$a, &$b) {
	if ($a[$_REQUEST['order']] > $b[$_REQUEST['order']]) {
		$rv = -1;
	}
	elseif ($a[$_REQUEST['order']] == $b[$_REQUEST['order']]) {
		$rv = 0;
	}
	else {
		$rv = 1;
	}
	if ($_REQUEST['sort'] == 'asc') {
		$rv *= -1;
	}
	return $rv;
}
?>
