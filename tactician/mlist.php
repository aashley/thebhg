<?php
include('header.php');
$hidden = false;
if ($complete == 2) {
	$complete = 0;
	$hidden = true;
	include('auth.php');
	$pos = $login->GetPosition();
	page_header('Hidden Missions');
	if ($login->GetID() != 666 && $pos->GetID() != 3 && $pos->GetID() != 7) {
		echo 'You are not permitted to access this page.';
		page_footer();
	}
}
elseif ($complete == 0 || empty($complete)) {
	$complete = 0;
	page_header('Current Missions');
}
else {
	$complete = 1;
	page_header('Archived Missions');
}

$missions_result = mysql_query("SELECT * FROM missions WHERE complete=$complete" . (!$hidden ? ' AND hidden=0' : ' AND hidden != 0') . ' ORDER BY mset DESC, title ASC', $db);
if ($missions_result && mysql_num_rows($missions_result)) {
	while ($mission = mysql_fetch_array($missions_result)) {
		if (empty($lastset) || $mission['mset'] != $lastset) {
			if (isset($lastset)) {
				echo "</UL><BR><BR>\n";
			}
			$lastset = $mission['mset'];
			echo "<U>Mission Set $lastset</U><BR><UL>\n";
		}
		$author = $roster->GetPerson($mission['author']);
		echo '<LI><A HREF="mission.php?id=' . $mission['id'] . ($hidden ? '&amp;hidden=1' : '') . '">' . stripslashes($mission['title']) . '</A> by ' . roster_link($author) . "\n";
	}
}
else {
	echo 'No missions found.';
}

page_footer();
?>
