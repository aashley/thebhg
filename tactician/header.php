<?php
import_request_variables('gp');

$db = mysql_connect('localhost', 'thebhg_tactician', 'tacdba70');
mysql_select_db('thebhg_tactician', $db);

include('roster.inc');
include('table.php');
$roster = new Roster('tact-whats-that');
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
$marshal = $roster->GetPerson(1000);
$commish = $roster->GetDivision(10);
$peeps = $commish->GetMembers();
foreach ($peeps as $guy) {
	$pos = $guy->GetPosition();
	if ($pos->GetID() == 3) {
		$tactician = $guy;
		break;
	}
}
$ca = $roster->GetDivision(9);
foreach ($ca->GetMembers() as $guy) {
	$pos = $guy->GetPosition();
	if ($pos->GetID() == 7) {
		$marshal = $guy;
		break;
	}
}
$rank = $tactician->GetRank();

function page_header($title = '', $bclass = '') {
	echo <<<EOH
<HTML>
<HEAD>
<BASE TARGET="main">
<LINK REL="stylesheet" TYPE="text/css" HREF="tactician.css">
</HEAD>
EOH;
	if ($bclass != '') {
		echo '<BODY CLASS="' . $bclass . '">';
	}
	else {
		echo '<BODY>';
	}

	if ($title != '') {
		echo '<H1>' . $title . '</H1><HR NOSHADE>';
	}
}

function page_footer() {
	echo <<<EOF
</BODY>
</HTML>

EOF;
	exit;
}

function roster_link($id, $name = '') {
	global $roster;

	if (is_numeric($id)) {
		$id = $roster->GetPerson($id);
	}

	return '<A HREF="/hunter.php?id=' . $id->GetID() . '" TITLE="' . htmlspecialchars($id->GetName()) . '">' . htmlspecialchars($name == '' ? $id->GetName() : $name) . '</A>';
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
?>
