<?php
$article_result = mysql_query('SELECT * FROM aq_articles WHERE id=' . $_REQUEST['id'], $db);
$article_row = mysql_fetch_array($article_result);

if ($article_row['column']) {
	$column_result = mysql_query('SELECT * FROM aq_columns WHERE id=' . $article_row['column'], $db);
	$column_row = mysql_fetch_array($column_result);
}

function title() {
	global $article_row, $column_row;

	if (isset($column_row)) {
		return 'Issue ' . $_REQUEST['year'] . '-' . $_REQUEST['week'] . ' :: ' . html_escape(stripslashes($column_row['name']));
	}
	else {
		return 'Issue ' . $_REQUEST['year'] . '-' . $_REQUEST['week'] . ' :: ' . html_escape(stripslashes($article_row['title']));
	}
}

function output() {
	global $article_row, $column_row, $roster;

	issue_header();

	$table = new Table();
	$table->AddRow('Title:', html_escape(stripslashes($article_row['title'])));
	if (isset($column_row)) {
		$table->AddRow('Column:', html_escape(stripslashes($column_row['name'])));
	}
	$author = $roster->GetPerson($article_row['author']);
	$table->AddRow('Author:', '<a href="' . internal_link('hunter', array('id'=>$author->GetID()), 'roster') . '">' . html_escape($author->GetName()) . '</a>');
	$table->EndTable();

	hr();

	echo nl2br(stripslashes($article_row['content']));

	issue_footer($_REQUEST['year'], $_REQUEST['week']);
}
?>
