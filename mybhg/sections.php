<?php
$title = 'Sections';
include('header.php');

$table = new Table();

$table->StartRow();
$table->AddHeader('Section');
$table->AddHeader('Items');
$table->AddHeader('Last News Posted');
$table->EndRow();

foreach ($news->GetAvailableSections() as $section) {
	$items = $news->GetNews(1, 'posts', array($section['id']));
	if (count($items)) {
		$table->StartRow();
		$table->AddCell('<a href="section.php?id=' . $section['id'] . '">' . $section['name'] . '</a>');
		$table->AddCell('<div align="right">' . number_format($news->GetNewsCount($section['id'])) . '</div>');
		$table->AddCell('<a href="article.php?id=' . $items[0]->GetID() . '">' . date('j F Y \a\t G:i:s T', $items[0]->GetTimestamp()) . '</a>');
		$table->EndRow();
	}
}

$show_blocks = true;
$table->EndTable();

include('footer.php');
?>
