<?php
include('roster.inc');
include('table.php');
include('form.php');

$roster = new Roster();

$om = mysql_connect('localhost', 'tactician', 'thidrithow');
mysql_select_db('tactician', $om);

$dm = date('m');
$dy = date('y');

if (date('j') <= 5){
	$dm--;
	
	if ($dm == 0){
		$dm = 12;
		$dy--;
	}
	
}

if ($_REQUEST['dm']){
	if (in_array($_REQUEST['dm'], range('01', '12')))
		$dm = $_REQUEST['dm'];
} else {
	$dm--;
}

if ($_REQUEST['dy']){
	if (in_array($_REQUEST['dy'], range('04', date('y'))))
		$dy = $_REQUEST['dy'];
}

$mb = new MedalBoard('tact-whats-that');

function next_medal($person, $group) {
	global $mb;

	$mg = $mb->GetMedalGroup($group);
	if ($mg->GetDisplayType() != 0) {
		echo 'Numeric medal, leaving immediately.<br>';
		$medals = $mg->GetMedals();
		return $medals[0];
	}
	
	$medals = $person->GetMedals();
	if (count($medals)) {
		$orders = array();
		$group_medals = $mg->GetMedals();
		foreach ($group_medals as $medal) {
			$orders[$medal->GetOrder()] = 0;
		}
		foreach ($medals as $am) {
			$medal = $am->GetMedal();
			$mgroup = $medal->GetGroup();
			if ($mgroup->GetID() == $group) {
				$orders[$medal->GetOrder()]++;
			}
		}
		
		ksort($orders);
		$last = 0;
		foreach ($orders as $key=>$o) {
			if ($o < $last) {
				$order = $key;
				break;
			}
			$last = $o;
		}
		if (empty($order)) {
			$order = min(array_keys($orders));
		}
		
		$medals = $mg->GetMedals();
		foreach ($medals as $medal) {
			if ($medal->GetOrder() == $order) {
				return $medal;
			}
		}
		return $medals[0];
	}
	else {
		$medals = $mg->GetMedals();
		return $medals[0];
	}
}

$subarray = array('Current Ladder'=>'ladder/ladder.php', 'Ladder Filters'=>'ladder/filter.php', 'Ladder Seasons'=>'ladder/season.php', 'About'=>'ladder/', 'Administration'=>'ladder/administration/');

$last_month_start = mktime(0, 0, 0, $dm, 1, $dy);
$last_month_end = mktime(0, 0, 0, $dm + 1 + $_REQUEST['months'], 0, $dy);

$ladder = array();
$diagnose = array();

function diagnose($person, $event, $reason){
	global $diagnose, $ladder;
	
	if (!in_array($person, array_keys($ladder)))
		$ladder[$person] = 0;
		
	$ladder[$person]++;
	
	$diagnose[$person][$event][] = $reason;
}

if (!function_exists('constructlayout')) {
	include_once('../Layout.inc');
}

function hr(){
	echo '<hr>';
}

function page_header($ltitle) {
	global $title;

	$settitle = $ltitle;
}

function page_footer() {
	global $settitle, $db, $global_ka;

	$new_output = iconv('ISO-8859-1', 'UTF-8', ob_get_contents());
	ob_clean();
	echo $new_output;
	ConstructLayout(iconv('ISO-8859-1', 'UTF-8', $settitle));
}

?>