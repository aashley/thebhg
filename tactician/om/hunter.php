<?php
include_once 'header.php';

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

$mWrittenResult = mysql_query('SELECT id, mset, title FROM missions WHERE author=' . $hunter->GetID() . ' AND hidden=0' . ' ORDER BY mset ASC, title ASC', $db);
$authorCount = mysql_num_rows($mWrittenResult);

page_header('Hunter :: ' . $hunter->GetName());

$table = new Table('', true);
		
$table->addRow('Roster Information', '<a href="http://holonet.thebhg.org/index.php?module=roster&amp;page=hunter&amp;id=' . $hunter->GetID() . '" TARGET="holonet">'. $hunter->IDline(0) . '</a>');
$table->addRow('Missions Attempted', number_format($missionCount) . ' (' . number_format($missionRate) . '% correct)');
$table->addRow('Missions Written', number_format($authorCount));

if ($authorCount > 0) {
	$table->startRow();
	$table->addHeader('Missions', 2);
	$table->endRow();

	while ($mission = mysql_fetch_array($mWrittenResult)) {
		$table->addRow('Mission Set ' . $mission['mset'], '<a href="mission.php?id=' . $mission['id'] . '">' . htmlspecialchars(stripslashes(format($mission['title']))) . '</a>');
	}
}

$table->endTable();

page_footer();
?>
