<?php
$chapter = $library->GetChapter($_REQUEST['id']);
$book = $chapter->GetBook();
$shelf = $book->GetShelf();

function title() {
	global $book, $chapter;
	return 'Administration :: '.$book->GetTitle().' :: '.$chapter->GetTitle().' :: Delete';
}

function auth($user) {
  $div = $user->GetDivision();
  return ($div->GetID() == 10 || $div->GetID() == 9);
}

function output() {
	global $chapter, $book, $shelf, $page;

	menu_header();

  if (   isset($_REQUEST['delete'])
      && $_REQUEST['delete'] == $_REQUEST['id']) {

    $url = internal_link('admin_book', array('id'=>$book->GetID()));

    if ($chapter->Delete()) {

      print 'Chapter Deleted.<br>';

    } else {

      print 'Error deleting chapter: '.$chapter->Error().'<br>';

    }

    echo '<br><a href="'.$url.'">Back to Admin</a>';

  } else {

    echo 'You are about to delete the \''.$chapter->GetTitle().'\' chapter. '
      .'Deleting a chapter also deletes all sections within that chapter. This '
      .'action can not be undone.<br><br>'
      .'Are you really sure wish to delete the \''.$chapter->GetTitle().'\' '
      .'chapter?<br>'
      .'<br>'
      .'[ '
      .'<a href="'.internal_link('admin_chapter_delete', array('id'=>$chapter->GetID(),'delete'=>$chapter->GetID())).'">Yes</a> '
      .'| '
      .'<a href="'.internal_link('admin_chapter', array('id'=>$chapter->GetID())).'">No</a> '
      .']';

  }


	admin_library_footer($shelf->GetID(), $book->GetID(), $chapter->GetID());
}
?>
