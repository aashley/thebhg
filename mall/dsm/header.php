<?php
define('DEBUG', false);

// Include CPD.
include_once('store.php');

$roster = new Roster('ssl-2.5-sail');

// Execute this when you're ready to start the page.
function page_header() {
	if (defined('DEBUG') && DEBUG) {
		define('START', array_sum(explode(' ', microtime())));
	}
	
	ob_start('ob_gzhandler');

	// Start headers.
	echo <<<EOH
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html/loose.dtd">
<HTML>
<HEAD>
<TITLE>$str_name</TITLE>
<BASE TARGET="main">
<LINK REL="stylesheet" TYPE="text/css" HREF="style.css">
</HEAD>
<BODY>
EOH;
}

// Same for the end of the page.
function page_footer() {
	global $timers;
	
	if (defined('DEBUG') && DEBUG && defined('START')) {
		echo '<br><br><b>Time Elapsed: ' . number_format(array_sum(explode(' ', microtime())) - START, 3) . ' sec</b><br>';
		if (isset($timers)) {
			foreach ($timers as $name=>$time) {
				echo "<br>Timer $name: " . number_format($time, 3) . ' sec';
			}
		}
	}
	
	echo <<<EOF
</BODY>
</HTML>
EOF;
	ob_end_flush();
	exit;
}

function start_timer($name) {
	global $timers;

	if (empty($timers)) {
		$timers = array();
	}
	$timers[$name] = array_sum(explode(' ', microtime()));
}

function end_timer($name) {
	global $timers;
	
	$timers[$name] = array_sum(explode(' ', microtime())) - $timers[$name];
}

function add_timer($name, $time) {
	global $timers;

	if (isset($timers[$name])) {
		$timers[$name] += $time;
	}
	else {
		$timers[$name] = $time;
	}
}

// Returns a Roster URL for a person.
function roster_person($id) {
	global $roster_person_url;

	return str_replace('<id>', $id, $roster_person_url);
}

// Prints a list of OPTION tags for every person in the BHG.
function person_list($select = 0) {
	global $roster;

	$categories = $roster->GetDivisionCategories();
	foreach ($categories as $cat) {
		$divisions = $cat->GetDivisions();
		foreach ($divisions as $div) {
			if ($div->GetID() == 16) continue;
			$people = $div->GetMembers();
			foreach ($people as $pleb) {
				$all[$div->GetName()][$pleb->GetName()] = $pleb->GetID();
			}
		}
	}

	ksort($all);
	foreach ($all as $name=>$div) {
		ksort($div);
		foreach ($div as $pname=>$pleb) {
			if ($pleb == $select) $sel = ' SELECTED';
			else $sel = '';
			echo "<OPTION VALUE=\"$pleb\"$sel>$name: $pname</OPTION>\n";
		}
	}
}

// Formats a time (in the format of the number of seconds).
function format_time($time_remaining) {
	$minutes = floor($time_remaining / 60) % 60;
        $hours = floor($time_remaining / 3600) % 24;
        $days = floor($time_remaining / 3600 / 24);
        $day_text = ($days == 1 ? ' day' : ' days');
        $hour_text = ($hours == 1 ? ' hour' : ' hours');
        $minute_text = ($minutes == 1 ? ' minute': ' minutes');

        if ($days) {
          if ($hours) {
            if ($minutes) {
              $rem_str = $days.$day_text.' '.$hours.$hour_text.' '.$minutes.$minute_text;
            } else {
              $rem_str = $days.$day_text.' '.$hours.$hour_text;
            }
          } else {
            if ($minutes) {
              $rem_str = $days.$day_text.' '.$minutes.$minute_text;
            } else{
              $rem_str = $days.$day_text;
            }
          }
        } else {
          if ($hours) {
            if ($minutes) {
              $rem_str = $hours.$hour_text.' '.$minutes.$minute_text;
            } else {
              $rem_str = $hours.$hour_text;
            }
          } else {
            if ($minutes) {
              $rem_str = $minutes.$minute_text;
            } else {
              $rem_str = 'None.';
            }
          }
        }

	return $rem_str;
}

?>
