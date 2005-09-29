<?php 

function pluralise($s, $n) {
	$str = number_format($n) . ' ' . $s;
	if ($n != 1) {
		$str .= 's';
	}
	return $str;
}

define('FT_YEAR', 0);
define('FT_WEEK', 1);
define('FT_DAY', 2);
define('FT_HOUR', 3);
define('FT_MINUTE', 4);
define('FT_SECOND', 5);
function format_time($seconds, $precision = FT_SECOND) {
	$anniv = mktime(0, 0, 0, date('m', $then), date('d', $then), date('Y'));
	if ($anniv > time()) {
		$years = date('Y') - date('Y', $then) - 1;
	}
	else {
		$years = date('Y') - date('Y', $then);
	}
	
	$days = date('z') - date('z', $then);
	if (date('L', $then) == 1
	 && date('L') == 0
	 && date('z') > 60)
		$days++;
	if ($days < 0) {
		$days += (date('L', mktime(0, 0, 0, date('m'), date('d'), date('Y') - 1)) ? 366 : 365);
	}

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
