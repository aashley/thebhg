<?php
$book = $library->GetBook($_REQUEST['id']);
$shelf = $book->GetShelf();

function title() {
	global $book;
	return 'Administration :: '.$book->GetTitle().' :: Delete';
}

function auth($user) {
  $div = $user->GetDivision();
  return ($div->GetID() == 10 || $div->GetID() == 9);
}

function output() {
	global $shelf, $book;

	menu_header();

  if (   isset($_REQUEST['delete'])
      && $_REQUEST['delete'] == $_REQUEST['id']) {

    $url = internal_link('admin_shelf', array('id'=>$shelf->GetID()));

    if ($book->Delete()) {

      print 'Book Deleted.<br>';

    } else {

      print 'Error deleting book: '.$book->Error().'<br>';

    }

    echo '<br><a href="'.$url.'">Back to Admin</a>';

  } else {

    echo 'You are about to delete the \''.$book->GetTitle().'\' book. '
      .'Deleting a Book also deletes all chapters within that book. This '
      .'action can not be undone.<br><br>'
      .'Are you really sure wish to delete the \''.$book->GetTitle().'\' '
      .'book?<br>'
      .'<br>'
      .'[ '
      .'<a href="'.internal_link('admin_book_delete', array('id'=>$book->GetID(),'delete'=>$book->GetID())).'">Yes</a> '
      .'| '
      .'<a href="'.internal_link('admin_book', array('id'=>$book->GetID())).'">No</a> '
      .']';

  }


	admin_library_footer($shelf->GetID());
}
?>
