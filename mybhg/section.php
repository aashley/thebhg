<?php
include_once('roster.php');
$title = 'Section';
foreach ($news->GetAvailableSections() as $section) {
	if ($section['id'] == $_REQUEST['id']) {
		$title .= ' :: ' . $section['name'];
		break;
	}
}
include('header.php');

$items = $news->GetNews($my_posts, 'posts', array($_REQUEST['id']));
display_articles($items);

$events = $calendar->GetEventsByTime(0, 7, array($_REQUEST['id']));
if ($events) {
	hr();
	display_calendar_events($events, false);
}

$show_blocks = true;
include('footer.php');
?>
