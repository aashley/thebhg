<?php
@import_request_variables('gp');

$db = mysql_connect('localhost', 'tactician', 'thidrithow');
mysql_select_db('tactician', $db);

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
	if ($pos->GetID() == 7) {
		$marshal = $guy;
		break;
	}
}
$rank = $tactician->GetRank();
$pos = $tactician->GetPosition();

function page_header($title = '') {
	echo <<<EOH
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<HTML>
<HEAD>
	<TITLE>Tactician's Office</TITLE>
	<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<LINK rel="stylesheet" href="main.css" type="text/css">
</HEAD>
<BODY>
<MAP id="bannermap" name="bannermap">
	<AREA shape="rect" coords="340,5,375,47" href="http://www.thebhg.org/" target="_blank" alt="Bounty Hunters Guild">
	<AREA shape="rect" coords="394,5,430,46" href="http://holonet.thebhg.org/" target="_blank" alt="Holonet">
	<AREA shape="rect" coords="446,9,487,43" href="http://mall.thebhg.org/" target="_blank" alt="Xerokine Outlet Center">
</MAP>
<DIV id="top"></DIV>
<IMG id="banner" src="img/banner.jpg" usemap="#bannermap">
<DIV id="nav"><a href="index.php">News</a> - <a href="mlist.php?complete=0">Current Missions</a> - <a href="mlist.php?complete=1">Archived Missions</a> - <a href="submit.php">Submit Mission</a> - <a href="stats/index.php">Statistics</a> - <a href="faq.php">FAQ</a> - <a href="contact.php">Contact Us</a> - <a href="admin.php">Administration</a></DIV>
<DIV id="main">
EOH;
	if ($title != '') {
		echo '<H1>' . $title . '</H1>';
	}
}

function page_footer() {
	echo <<<EOF
<HR>
<P class="disclaimer">Site Graphics © 2005 Baron Kal-Ket, and licensed for use by the Bounty Hunters Guild.</P>
<P class="disclaimer">All rights reserved 1995-2005; original contents are protected by the United States (US) Copyright Act
<BR>in accordance with the Bounty Hunters Guild <A href="http://www.thebhg.org/disclaimer/">Disclaimers and Copyrights</A> detailed herein.
<BR>This site abides by the Bounty Hunters Guild <A href="http://www.thebhg.org/privacy/">Privacy Policy</A>.</P>
</DIV>
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
