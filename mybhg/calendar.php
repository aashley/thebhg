<?php
if (isset($_REQUEST['month'])) {
	$month = (int) $_REQUEST['month'];
	$year = (int) $_REQUEST['year'];
}
else {
	$month = (int) date('n');
	$year = (int) date('Y');
}

$title = 'Calendar :: ' . date('F Y', mktime(0, 0, 0, $month, 2, $year));
include_once('header.php');

$start = mktime(0, 0, 0, $month, 1, $year);
$end = mktime(23, 59, 59, $month + 1, 0, $year);

$table = new Table();

$table->StartRow();
$table->AddHeader('<center><a href="calendar.php?month=' . ($month - 1) . '&amp;year=' . $year . '">&lt;&lt;</a></center>');
$table->AddHeader('<center>' . date('F Y', $start) . '</center>', 5);
$table->AddHeader('<center><a href="calendar.php?month=' . ($month + 1) . '&amp;year=' . $year . '">&gt;&gt;</a></center>');
$table->EndRow();

$row = 0;
for ($i = 1; $i <= date('t', $start); $i++) {
	$time = mktime(0, 0, 0, $month, $i, $year);
	$dow = (int) date('w', $time);
	if ($dow == 0) {
		$row++;
	}
	$days[$row][$dow] = $time;
	$dname[$dow] = date('D', $time);
}

if (count($days) == 6) {
	$first = key($days);
	$last = end($days);
	foreach ($last as $dow=>$ts) {
		$days[$first][$dow] = $ts;
	}
	array_pop($days);
}

$table->StartRow();
ksort($dname);
foreach ($dname as $day) {
	$table->AddHeader('<center>' . $day . '</center>', 1, 1, '14%');
}
$table->EndRow();

foreach ($days as $week) {
	// There will be a problem here if we ever change the number of days in
	// a week from seven.
	$table->StartRow();
	for ($i = 0; $i < 7; $i++) {
		if (isset($week[$i])) {
			$day = date('j', $week[$i]);
		}
		else {
			$day = '';
		}
		if ($calendar->GetEventsByDay(date('j', $week[$i]), $month, $year, $my_sections)) {
			$day = "<a href=\"#$day\">$day</a>";
		}
		$table->AddCell('<center>' . $day . '</center>');
	}
	$table->EndRow();
}

$table->EndTable();

hr();

$events = $calendar->GetEventsByMonth($month, $year, $my_sections);
if ($events) {
	$table = new Table();
	$table->StartRow();
	$table->AddHeader('Date');
	$table->AddHeader('Time');
	$table->AddHeader('Section');
	$table->AddHeader('Title');
	$table->EndRow();
	$last_day = false;
	foreach ($events as $event) {
		$day = date('j F Y', $event->GetTime());
		if ($last_day != $day) {
			$last_day = $day;
			$day = '<a name="' . date('j', $event->GetTime()) . '"></a>' . $day;
		}
		$table->StartRow();
		$table->AddCell($day);
		$table->AddCell(date('G:i:s T', $event->GetTime()));
		$table->AddCell('<a href="section.php?id=' . $event->GetSection() . '">' . get_section_name($event->GetSection()) . '</a>');
		$table->AddCell('<a href="event.php?id=' . $event->GetID() . '">' . $event->GetTitle() . '</a>');
		$table->EndRow();
	}
	$table->EndTable();
}
else {
	echo 'No events have been found for this month.';
}

$show_blocks = true;
include_once('footer.php');
?>
