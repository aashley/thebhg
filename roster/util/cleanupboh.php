<?php

include_once 'DB.php';

$db = DB::connect('mysql://thebhg_rosedit:657cbf05@localhost/thebhg_roster');
$db->setFetchMode(DB_FETCHMODE_ASSOC);

$mids = array(20, 21, 22, 23, 24);

$sql = 'SELECT recipientid, COUNT(*) as count FROM mb_awarded_medals WHERE medal IN ('.implode(',', $mids).') GROUP BY recipientid';

$people = $db->getCol($sql);

foreach ($people as $person) {
	print 'Fixing BOH for '.$person."\n";
	$sql = 'SELECT * '
				.'FROM mb_awarded_medals '
				.'WHERE recipientid = '.$person.' '
					.'AND medal IN ('.implode(',', $mids).') '
				.'ORDER BY `date` ASC';
	$medals = $db->query($sql);

	$success = true;
	$id = 0;
	while ($medal = $medals->fetchRow()) {

		print $medal['medal'].': '.$mids[$id]."\n";

		$sql = 'UPDATE mb_awarded_medals SET medal = '.$mids[$id].' WHERE id = '.$medal['id'];

		$db->query($sql);

		$id++;

		if ($id == sizeof($mids)) $id = 0;

	}
}

?>
