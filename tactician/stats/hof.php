<?php
include('../header.php');
page_header('Mission Hall of Fame');

define('NA', 1000);

class Mission {
	var $id;
	var $author;
	var $title;
	var $correct;
	var $total;

	function Mission($id, $author, $title) {
		$this->id = $id;
		$this->author = $author;
		$this->title = $title;
		$this->correct = 0;
		$this->total = 0;
	}

	function GetPercentage() {
		if ($this->total == 0)
			return NA;
		
		return (100 * ($this->correct / $this->total));
	}
}

function sort_missions($a, $b) {
	$ap = $a->GetPercentage();
	$bp = $b->GetPercentage();
	if ($ap > $bp) {
		return 1;
	}
	elseif ($ap == $bp) {
		if ($a->title > $b->title) {
			return 1;
		}
		return -1;
	}
	return -1;
}

$missions = array();

$all_result = mysql_query('SELECT id, author, title FROM missions WHERE complete=1 AND hidden=0', $db);
while ($row = mysql_fetch_array($all_result))
	$missions[$row['id']] = new Mission($row['id'], $row['author'], stripslashes($row['title']));

$total_result = mysql_query('SELECT missions.id, COUNT(DISTINCT answers.id) AS num FROM answers, missions WHERE answers.mission=missions.id AND missions.complete=1 AND missions.hidden=0 GROUP BY missions.id', $db);
while ($row = mysql_fetch_array($total_result))
	$missions[$row['id']]->total = $row['num'];

$correct_result = mysql_query('SELECT missions.id, COUNT(DISTINCT answers.id) AS num FROM answers, missions WHERE answers.mission=missions.id AND answers.correct=1 AND missions.complete=1 AND missions.hidden=0 GROUP BY missions.id', $db);
while ($row = mysql_fetch_array($correct_result))
	$missions[$row['id']]->correct = $row['num'];

usort($missions, 'sort_missions');

$table = new Table();
$table->StartRow();
$table->AddHeader('&nbsp;');
$table->AddHeader('Title');
$table->AddHeader('Author');
$table->AddHeader('Correct');
$table->EndRow();
$row_no = 0;
$last_rank = 0;
$last_perc = -1;
foreach ($missions as $mission) {
	$row_no++;
	$perc = $mission->GetPercentage();
	if ($perc != $last_perc) {
		$last_perc = $perc;
		$last_rank = $row_no;
	}

	if ($perc == NA)
		$perc = 'N/A';
	else
		$perc = number_format($perc, 1) . '%';

	$table->StartRow();
	$table->AddCell($last_rank);
	$table->AddCell('<A HREF="../mission.php?id=' . $mission->id . '">' . htmlspecialchars($mission->title) . '</A>');
	$table->AddCell(roster_link($mission->author));
	$table->AddCell($perc);
	$table->EndRow();
}
$table->EndTable();

page_footer();
?>
