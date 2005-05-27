<?php
$shelf = $library->GetShelf($_REQUEST['id']);

function title() {
	global $shelf;
	return $shelf->GetName();
}

function output() {
	global $shelf;

	menu_header();
	
	echo '<p>'.$shelf->GetDescription().'</p>';

	echo '<p>Available Books:</p>';

	foreach ($shelf->GetBooks() as $book) {

		print '<p><a href="'.internal_link('book', array('id'=>$book->GetID())).'">'.$book->GetTitle().'</a><small><br>'.$book->GetDescription().'</small></p>';

	}
	
	library_footer($shelf->GetID());
}
?>
