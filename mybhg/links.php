<?php
$title = 'Link Database';
include('header.php');

$table = new Table('', true);

$section_result = mysql_query('SELECT * FROM link_sections ORDER BY name', $db);
if ($section_result && mysql_num_rows($section_result)) {
	while ($section = mysql_fetch_array($section_result)) {
		$link_result = mysql_query('SELECT * FROM links WHERE section=' . $section['id'] . ' ORDER BY name', $db);
		if ($link_result && mysql_num_rows($link_result)) {
			$table->StartRow();
			$table->AddHeader(stripslashes($section['name']), 2);
			$table->EndRow();
			while ($link = mysql_fetch_array($link_result)) {
				$table->StartRow();
				$table->AddCell('<a href="' . htmlspecialchars(stripslashes($link['url'])) . '">' . stripslashes($link['name']) . '</a>');
				$table->AddCell('<a href="' . htmlspecialchars(stripslashes($link['url'])) . '">' . stripslashes($link['url']) . '</a>');
				$table->EndRow();
			}
		}
	}
}

$table->EndTable();

$show_blocks = true;
include('footer.php');
?>
