<?php
ini_set('include_path', ini_get('include_path') . ':./holonet');
$news = new News('holo-is-queer');

function title() {
	return 'News';
}

function output() {
	global $news;
	
	echo 'Welcome to the Holonet. You may choose a module to view from the menu above.<br><br>';

	$table = new Table();
	foreach ($news->GetNews(5, 'posts') as $item) {
		$table->StartRow();
		$table->AddHeader($item->Render('%topic%'));
		$table->AddHeader($item->Render('Posted by <a href="index.php?module=roster&amp;page=hunter&amp;id=%poster_id%">%poster_name%</a> on %date%', 'j F Y \a\t G:i:s T'));
		$table->EndRow();
		$table->StartRow();
		$table->AddCell($item->Render('%message%'), 2);
		$table->EndRow();
	}
	$table->EndTable();
}
?>
