<?php
@import_request_variables('gp');

$db = mysql_connect('localhost', 'tactician', 'thidrithow');
mysql_select_db('tactician', $db);

include('roster.inc');
include('table.php');
include('form.php');
$roster = new Roster('tact-whats-that');
$mb = new MedalBoard('tact-whats-that');
$login = new Login_HTTP();

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
		print_r($orders);
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

$tactician = $roster->GetPerson(1000);
$commish = $roster->GetDivision(10);
$peeps = $commish->GetMembers();
foreach ($peeps as $guy) {
	$pos = $guy->GetPosition();
	if ($pos->GetID() == 3) {
		$tactician = $guy;
		break;
	}
}
$rank = $tactician->GetRank();
$pos = $tactician->GetPosition();

function roster_link($id, $name = '') {
	global $roster;

	if (is_numeric($id)) {
		$id = $roster->GetPerson($id);
	}

	return '<a href="/om/hunter.php?id=' . $id->GetID() . '" TITLE="' . htmlspecialchars($id->GetName()) . '">' . htmlspecialchars(strlen($name) ? $name : $id->GetName()) . '</A>';
}

function format($text){

	return str_replace(array('“', '…', '’', '”'), array('"', '...', "'", '"'), $text);
	
}

function format_missions($complete = 0, $hide = 0){
	global $db, $roster, $login, $db;
	
	$hidden = $hide;
	
	$sql = "SELECT `id` FROM `assistant` WHERE `person` = ".$login->getID()." AND `date_deleted` = 0 AND `om` = 1";
	$pos = $login->getPosition();
	if (!in_array($login->GetID(), array(666, 2650)) && $pos->GetID() != 3 && !mysql_num_rows(mysql_query($sql, $db)))
		$hidden = 0;

	$missions_result = mysql_query("SELECT * FROM missions WHERE complete=$complete AND hidden " . ($hidden ? '!' : '') . "=0 ORDER BY mset DESC, title ASC", $db);
	if ($missions_result && mysql_num_rows($missions_result)) {
		$table = new Table('', true);
		
		$table->addRow('Mission', 'Author');
		
		while ($mission = mysql_fetch_array($missions_result)) {
			
			if (empty($lastset) || $mission['mset'] != $lastset) {
				
				$lastset = $mission['mset'];
				
				$table->StartRow();
				$table->AddHeader('Mission Set ' . $lastset, 2);
				$table->EndRow();
				
			}
			
			$author = $roster->GetPerson($mission['author']);
			
			$table->addRow('<a href="/om/mission.php?id=' . $mission['id'] . '">' . stripslashes(format($mission['title'])) . '</a>',
					roster_link($author));
		}
		$table->endTable();
	} else {
		echo '<div>No missions found.</div>';
	}	
	
}

function hunter_dropdown($exclude = array(0, 16), $select = false) {
	global $roster;

	$divisions = $roster->GetDivisions('name');
	foreach ($divisions as $div) {
		if (in_array($div->GetID(), $exclude)) {
			continue;
		}
		if ($div->GetMemberCount()) {
			$members = $div->GetMembers('name');
			foreach ($members as $pleb) {
				echo '<OPTION VALUE="' . $pleb->GetID() . '"' . ($select == $pleb->GetID() ? ' SELECTED' : '') . '>' . htmlspecialchars($div->GetName() . ': ' . $pleb->GetName()) . '</OPTION>';
			}
		}
	}
}

if (!function_exists('constructlayout')) {
	include_once('../Layout.inc');
}

ini_set('include_path', ini_get('include_path') . ':/var/www/html/include');
include_once('roster.inc');

if (empty($subarray)) {
	$subarray = array(
		'Current Missions'=>'om/index.php',
		'Archived Missions'=>'om/archive.php',
		'Statistics'=>'om/stats/index.php',
		'Administration'=>'om/administration/index.php'
	);
}

function hr(){
	echo '<hr>';
}

function page_header($ltitle) {
	global $title;

	$settitle = $ltitle;
}

function page_footer() {
	global $settitle, $ka, $global_ka;

	$ka = $global_ka;
	$new_output = iconv('ISO-8859-1', 'UTF-8', ob_get_contents());
	ob_clean();
	echo $new_output;
	ConstructLayout(iconv('ISO-8859-1', 'UTF-8', $settitle));
}

function add_menu($menu_array) {
	global $subarray;

	$subarray = array_merge(array('<b>Page Links</b>'=>'#'), $menu_array, array('<b>OM Links</b>'=>'#'), $subarray);
}

?>