<?php
include('header.php');
if (isset($hidden)) {
	include('auth.php');
	$pos = $login->GetPosition();
	if ($login->GetID() != 666 && $pos->GetID() != 3) {
		page_header();
		echo 'You are not permitted to access this page.';
		page_footer();
	}
}

$id = (int) $id;
$hunter = $roster->GetPerson($id);

$mTotalResult = mysql_query('SELECT COUNT(*) FROM answers WHERE person=' . $hunter->GetID(), $db);
$missionCount = mysql_result($mTotalResult, 0, 0);

$mCorrectResult = mysql_query('SELECT COUNT(*) FROM answers WHERE correct=1 AND person=' . $hunter->GetID(), $db);
$missionCorrect = mysql_result($mCorrectResult, 0, 0);

if ($missionCount == 0)
	$missionRate = 0;
else
	$missionRate = round(100 * $missionCorrect / $missionCount);

$mWrittenResult = mysql_query('SELECT id, mset, title FROM missions WHERE author=' . $hunter->GetID() . (!$hidden ? ' AND hidden=0' : '') . ' ORDER BY mset ASC, title ASC', $db);
$authorCount = mysql_num_rows($mWrittenResult);

page_header($hunter->GetName());

echo '<UL>';
echo '<LI><B><A HREF="http://holonet.thebhg.org/index.php?module=roster&amp;page=hunter&amp;id=' . $hunter->GetID() . '" TARGET="_top">Jump to Holonet Information</A></B>';
echo '<LI><B>ID Line</B>: ' . htmlspecialchars($hunter->IDLine());
echo '<LI><B>Missions Attempted</B>: ' . number_format($missionCount) . ' (' . number_format($missionRate) . '% correct)';
echo '<LI><B>Missions Written</B>: ' . number_format($authorCount);
echo '</UL>';

if ($authorCount > 0) {
	echo '<HR NOSHADE><BR><U>Missions</U><UL>';

	while ($mission = mysql_fetch_array($mWrittenResult)) {
		echo '<LI>Mission Set ' . $mission['mset'] . ': <A HREF="mission.php?id=' . $mission['id'] . ($hidden ? '&amp;hidden=1' : '') . '">' . htmlspecialchars(stripslashes($mission['title'])) . '</A>';
	}
	
	echo '</UL>';
}

page_footer();
?>
