<?php

function pluralise($s, $n) {
	$str = number_format($n) . ' ' . $s;
	if ($n != 1) {
		$str .= 's';
	}
	return $str;
}

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

define('FT_YEAR', 0);
define('FT_WEEK', 1);
define('FT_DAY', 2);
define('FT_HOUR', 3);
define('FT_MINUTE', 4);
define('FT_SECOND', 5);
function format_time($seconds, $precision = FT_SECOND) {
	$days = floor($seconds / 86400);
	$years = floor($days / 365);
	$days %= 365;
	$weeks = floor($days / 7);
	$days %= 7;

	$seconds %= 86400;
	$hours = floor($seconds / 3600);
	$seconds %= 3600;
	$minutes = floor($seconds / 60);
	$seconds %= 60;

	switch ($precision) {
		case FT_SECOND:
			if ($seconds) {
				$bits[] = pluralise('second', $seconds);
			}
		case FT_MINUTE:
			if ($minutes) {
				$bits[] = pluralise('minute', $minutes);
			}
		case FT_HOUR:
			if ($hours) {
				$bits[] = pluralise('hour', $hours);
			}
		case FT_DAY:
			if ($days) {
				$bits[] = pluralise('day', $days);
			}
		case FT_WEEK:
			if ($weeks) {
				$bits[] = pluralise('week', $weeks);
			}
		case FT_YEAR:
			if ($years) {
				$bits[] = pluralise('year', $years);
			}
	}
	
	if (count($bits)) {
		$bits = array_reverse($bits, true);
		if (count($bits) > 2) {
			$last = $bits[0];
			unset($bits[0]);
			$str = implode(', ', $bits);
			$str .= ' and ' . $last;
		}
		else {
			$str = implode(' and ', $bits);
		}
	}
	else {
		$str = '0';
	}

	return $str;
}
?>
