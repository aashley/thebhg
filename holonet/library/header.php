<?php
// Include the library.
include_once('library.inc');
$library = new Library('holo-is-queer');

// Include the Timeline stuff.
include_once('timeline/timeline.php');
include_once('timeline/category.php');
include_once('timeline/event.php');
$timeline = new Timeline();

function timeline_admin_footer() {
	menu_sep();
	echo 'Timeline&nbsp;Admin<small><br><br>';
	echo '<a href="' . internal_link('timeline_add_category') . '">Add&nbsp;Category</a><br>';
	echo '<a href="' . internal_link('timeline_edit_category') . '">Edit&nbsp;Category</a><br>';
	echo '<a href="' . internal_link('timeline_delete_category') . '">Delete&nbsp;Category</a><br><br>';
	echo '<a href="' . internal_link('timeline_add_event') . '">Add&nbsp;Event</a><br>';
	echo '<a href="' . internal_link('timeline_edit_event') . '">Edit&nbsp;Event</a><br>';
	echo '<a href="' . internal_link('timeline_delete_event') . '">Delete&nbsp;Event</a><br>';
	echo '</small>';
	menu_footer();
}

// Some quote stuff.
function quote_footer() {
	global $db, $roster;

	menu_sep();

	echo '<a href="' . internal_link('quotes', array('all'=>'')) . '">All&nbsp;Quotes</a><br>';
	echo '<a href="' . internal_link('quotes', array('new'=>'7')) . '">New&nbsp;Quotes</a><br><br>';
	
	echo 'The&nbsp;Quoted<small><br><br>';
	
	$result = mysql_query('SELECT speaker FROM irc_quotes WHERE speaker NOT IN (0, 696969) GROUP BY speaker', $db);
	$names = array();
	while ($row = mysql_fetch_array($result)) {
		$pleb = $roster->GetPerson($row['speaker']);
		if (strlen($pleb->GetName()) > 20) {
			$names[$pleb->GetID()] = substr($pleb->GetName(), 0, 20) . '...';
		}
		else {
			$names[$pleb->GetID()] = $pleb->GetName();
		}
	}
	asort($names);

	echo '<a href="' . internal_link('quotes', array('id'=>696969)) . '">Non-BHG</a><br>';
	foreach ($names as $id=>$name) {
		echo '<a href="' . internal_link('quotes', array('id'=>$id)) . '">' . str_replace(' ', '&nbsp;', $name) . '</a><br>';
	}

	echo '<br><a href="' . internal_link('quote_admin') . '">Admin</a></small>';
	menu_footer();
}

function library_footer($curr_shelf = -1, $curr_book = -1, $curr_chapter = -1) {
	global $library;
	
	menu_sep();

	if ($curr_book != -1) {
		$book = $library->GetBook($curr_book);
		echo '<b>Chapters</b><small><br><br>';
		foreach ($book->GetChapters() as $chapter) {
			echo $chapter->Error();
			$title = str_replace(' ', '&nbsp;', $chapter->GetTitle());
			if ($chapter->GetID() == $curr_chapter) {
				echo $title;
			}
			else {
				echo '<a href="' . internal_link('chapter', array('id'=>$chapter->GetID())) . '">' . $title . '</a>';
			}
			echo '<br>';
		}
		echo '<br></small><b>Other</b>&nbsp;';
	}

	echo '<b>Books</b><br>';
	foreach ($library->GetShelves() as $shelf) {
		$shelf_title = str_replace(' ', '&nbsp;', $shelf->GetName());
		echo '<br><a href="' . internal_link('shelf', array('id'=>$shelf->GetID())) . '">' . $shelf_title . '</a><small>';
		foreach ($shelf->GetBooks() as $book) {
			echo '<br>';
			$title = str_replace(' ', '&nbsp;', $book->GetTitle());
			if ($book->GetID() == $curr_book) {
				echo '&nbsp;'.$title;
			}
			else {
				echo '&nbsp;<a href="' . internal_link('book', array('id'=>$book->GetID())) . '">' . $title . '</a>';
			}
		}
		echo '</small><br>';
	}
	
	menu_footer();
}

function admin_library_footer($curr_shelf = -1, $curr_book = -1, $curr_chapter = -1) {
	global $library;
	
	menu_sep();

	if ($curr_book != -1) {
		$book = $library->GetBook($curr_book);
		echo '<b>Chapters</b><small><br><br>';
		foreach ($book->GetChapters() as $chapter) {
			echo $chapter->Error();
			$title = str_replace(' ', '&nbsp;', $chapter->GetTitle());
			echo '<a href="' . internal_link('admin_chapter', array('id'=>$chapter->GetID())) . '">' . $title . '</a>';
			echo '<br>';
		}
		echo '<br></small><b>Other</b>&nbsp;';
	}

	echo '<b>Books</b><br>';
	foreach ($library->GetShelves() as $shelf) {
		$shelf_title = str_replace(' ', '&nbsp;', $shelf->GetName());
		echo '<br><a href="' . internal_link('admin_shelf', array('id'=>$shelf->GetID())) . '">' . $shelf_title . '</a><small>';
		foreach ($shelf->GetBooks() as $book) {
			echo '<br>';
			$title = str_replace(' ', '&nbsp;', $book->GetTitle());
			echo '&nbsp;<a href="' . internal_link('admin_book', array('id'=>$book->GetID())) . '">' . $title . '</a>';
		}
		echo '</small><br>';
	}
	
	menu_footer();
}


?>
