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
	addMenu('Timeline Admin',
			array('Add Category' => internal_link('timeline_add_category'),
				'Edit Category' => internal_link('timeline_edit_category'),
				'Delete Category' => internal_link('timeline_delete_category'),
				'Add Event' => internal_link('timeline_add_event'),
				'Edit Event' => internal_link('timeline_edit_event'),
				'Delete Event' => internal_link('timeline_delete_event')
				));
	menu_footer();
}

function timeline_footer() {
	global $timeline, $page;

	$items = array('All' => internal_link($page));

	$items += timeline_items($timeline->GetCategories(), 0);

	addMenu('Categories', $items);

	$items = array('Admin' => internal_link('timeline_admin'));

	addMenu('Administration', $items);

	menu_footer();

}

function timeline_items($categories, $level) {
	global $page;

	$items = array();

	foreach ($categories as $cat) {

		if ($level > 0) {

			$prefix = str_repeat(' ', $level - 1).' - ';

		} else {

			$prefix = '';

		}

		$items[str_replace(' ', '&nbsp;', $prefix.$cat->getName())] = internal_link($page, array('id' => $cat->GetID()));

		$subs = $cat->getSubCategories();

		if (count($subs) > 0) {

			$items += timeline_items($subs, $level + 1);

		}

  }

	return $items;
	
}

function timeline_form_categories($categories, $level, $form) {

	foreach ($categories as $cat) {

		if ($level == 0) {

			$prefix = '';

		} else {

			$prefix = str_repeat(' ', $level - 1).' - ';

    }

		$form->addOption($cat->GetID(), '&nbsp;');

		$subs = $cat->getSubCategories();

		if (count($subs) > 0) {

			timeline_form_categories($subs, $level + 1, $form);

		}

	}

}


// Some quote stuff.
function quote_footer() {
	global $db, $roster;

	addMenu('Quotes',
		array('All Quotes' => internal_link('quotes', array('all'=>'')),
			'New Quotes' => internal_link('quotes', array('new'=>'7')),
			));
	
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

	$items = array();
	$items['Non-BHG'] = internal_link('quotes', array('id'=>696969));
	foreach ($names as $id=>$name) {
		$items[$name] = internal_link('quotes', array('id'=>$id));
	}
	addMenu('The Quoted', $items);

	addMenu('Administration',
			array('Administration' => internal_link('quote_admin')));
	menu_footer();
}

function library_footer($curr_shelf = -1, $curr_book = -1, $curr_chapter = -1) {
	global $library;
	
	if ($curr_book != -1) {
		$book = $library->GetBook($curr_book);
		$items = array();
		foreach ($book->GetChapters() as $chapter) {
			$items[$chapter->GetTitle()] = internal_link('chapter', array('id'=>$chapter->GetID()));
		}
		addMenu('Chapters', $items);
	}

	foreach ($library->GetShelves() as $shelf) {
		$items = array();
		foreach ($shelf->GetBooks() as $book) {
			$items[$book->GetTitle()] = internal_link('book', array('id'=>$book->GetID()));
		}
		addMenu($shelf->getName(), $items);
	}
	
	menu_footer();
}

function admin_library_footer($curr_shelf = -1, $curr_book = -1, $curr_chapter = -1) {
	global $library;
	
	if ($curr_book != -1) {
		$book = $library->GetBook($curr_book);
		$items = array();
		foreach ($book->GetChapters() as $chapter) {
			$items[$chapter->GetTitle()] = internal_link('admin_chapter', array('id'=>$chapter->GetID()));
		}
		addMenu('Chapters', $items);
	}

	foreach ($library->GetShelves() as $shelf) {
		$items = array();
		foreach ($shelf->GetBooks() as $book) {
			$items[$book->GetTitle()] = internal_link('admin_book', array('id'=>$book->GetID()));
		}
		addMenu($shelf->getName(), $items);
	}
	
	menu_footer();
}


?>
