<?php
include_once('db.php');
include_once('classes/calendar.php');
$calendar = new Calendar($db);
$event = $calendar->GetEvent($_REQUEST['id']);
$title = 'Event :: ' . htmlspecialchars($event->GetTitle());
include_once('header.php');

foreach ($news->GetAvailableSections() as $sec) {
	$sec_names[$sec['id']] = $sec['name'];
}

$poster = $event->GetPoster();

$table = new Table();

$table->StartRow();
$table->AddHeader('Event Information', 2);
$table->EndRow();

$table->AddRow('Section:', '<a href="section.php?id=' . $event->GetSection() . '">' . htmlspecialchars($sec_names[$event->GetSection()]) . '</a>');
$table->AddRow('Event Time:', date('j F Y \a\t G:i:s T', $event->GetTime()));
$table->AddRow('Posted By:', '<a href="http://holonet.thebhg.org/index.php?module=roster&amp;page=hunter&amp;id=' . $poster->GetID() . '">' . htmlspecialchars($poster->GetName()) . '</a>');
$table->AddRow('Information:', nl2br($event->GetContent()));

$table->EndTable();

$show_blocks = true;
include_once('footer.php');
?>
