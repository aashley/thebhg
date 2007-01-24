<?php
function title() {
	global $timeline, $category;
	
	$title = 'Timeline :: ';
	if (isset($_REQUEST['id'])) {
		$category = $timeline->GetCategory($_REQUEST['id']);
		$title .= $category->GetName();
	}
	else {
		$title .= 'All';
	}
	return $title;
}

function output() {
	global $timeline, $category, $page;
	
	menu_header();

	if (isset($_REQUEST['id'])) {
		$events = $timeline->GetEventsByCategory($_REQUEST['id']);
	}
	else {
		$events = $timeline->GetAllEvents();
	}

	if (count($events)) {
		$last_date = '';
		foreach ($events as $event) {
			if ($event->GetFormattedDate() != $last_date) {
				if ($last_date != '') {
					echo '</ul><br>';
				}
				echo '<b>' . $event->GetFormattedDate() . '</b><ul style="list-style: disc">';
				$last_date = $event->GetFormattedDate();
			}
			echo '<li>' . nl2br($event->GetContent()) . '</li>';
		}
		echo '</ul>';
	}
	else {
		echo 'There are no events in this category at present.';
	}

	timeline_footer();
	
}
?>
