<?php
$chapter = $library->GetChapter($_REQUEST['id']);
$book = $chapter->GetBook();
$shelf = $book->GetShelf();

function title() {
	global $chapter, $book;
	return $book->GetTitle() . ' :: ' . $chapter->GetTitle();
}

function output() {
	global $chapter, $book, $shelf;

	menu_header();
	
	$first = true;
	foreach ($chapter->GetSections() as $section) {
		if ($first) {
			$first = false;
		}
		else {
			hr();
		}
		if ($section->GetTitle()) {
			echo '<b>' . $section->GetTitle() . '</b><br><br>';
		}
		echo $section->GetBody();
	}
	
	library_footer($shelf->GetID(), $book->GetID(), $chapter->GetID());
}
?>
