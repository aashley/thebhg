<?php
$title = 'Search';
include('header.php');

if ($_REQUEST['submit']) {
	if ($_REQUEST['search'] == 'calendar') {
		$items = $calendar->Search($_REQUEST['terms'], $_REQUEST['section'] == 0 ? array() : array($_REQUEST['section']));
	}
	else {
		$items = $news->Search($_REQUEST['terms'], $_REQUEST['search'], $_REQUEST['section'] == 0 ? array() : array($_REQUEST['section']));
	}
	if (count($items)) {
		$table = new Table('', true);
		$table->StartRow();
		if ($_REQUEST['section'] == 0) {
			$table->AddHeader('Section');
		}
		$table->AddHeader('Title');
		$table->AddHeader('Date/Time');
		$table->EndRow();
		foreach ($items as $item) {
			$table->StartRow();
			if ($_REQUEST['section'] == 0 && is_a($item, 'newsitem')) {
				$table->AddCell('<a href="section.php?id=' . $item->GetSectionID() . '">' . htmlspecialchars($item->GetSectionName()) . '</a>');
			}
			elseif ($_REQUEST['section'] == 0 && is_a($item, 'calendarevent')) {
				$table->AddCell('<a href="section.php?id=' . $item->GetSection() . '">' . htmlspecialchars(get_section_name($item->GetSection())) . '</a>');
			}
			$table->AddCell('<a href="' . (is_a($item, 'newsitem') ? 'article' : 'event') . '.php?id=' . $item->GetID() . '">' . $item->GetTitle() . '</a>');
			$table->AddCell(date('j F Y \a\t G:i:s T', (is_a($item, 'newsitem') ? $item->GetTimestamp() : $item->GetTime())));
			$table->EndRow();
		}
		$table->EndTable();
	}
	else {
		echo 'No items were found matching the search criteria.';
	}
}
else {
	$form = new Form($_SERVER['PHP_SELF']);
	$form->AddTextBox('Search For:', 'terms');
	
	$form->StartSelect('Search In:', 'search', 'message');
	$form->AddOption('message', 'News items');
	$form->AddOption('calendar', 'Calendar items');
	$form->EndSelect();

	$sections = $news->GetAvailableSections();
	$form->StartSelect('Section:', 'section', '0');
	$form->AddOption('0', 'All sections');
	foreach ($sections as $section) {
		$form->AddOption($section['id'], $section['name']);
	}
	$form->EndSelect();

	$form->AddSubmitButton('submit', 'Search Articles');
	$form->EndForm();
}

$show_blocks = true;
include('footer.php');
?>
