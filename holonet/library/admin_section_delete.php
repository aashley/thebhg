<?php
$section = $library->GetSection($_REQUEST['id']);
$chapter = $section->GetChapter();
$book = $chapter->GetBook();
$shelf = $book->GetShelf();

function title() {
	global $book, $chapter;
	return 'Administration :: '.$book->GetTitle().' :: '.$chapter->GetTitle().' :: Delete Section';
}

function auth($user) {
  $div = $user->GetDivision();
  return ($div->GetID() == 10 || $div->GetID() == 9);
}

function output() {
	global $section, $chapter, $book, $shelf, $page;

	menu_header();

  if (   isset($_REQUEST['delete'])
      && $_REQUEST['delete'] == $_REQUEST['id']) {

    $url = internal_link('admin_chapter', array('id'=>$chapter->GetID()));

    if ($section->Delete()) {

      print 'Section Deleted.<br>';

    } else {

      print 'Error deleting section: '.$section->Error().'<br>';

    }

    echo '<br><a href="'.$url.'">Back to Admin</a>';

  } else {

    echo 'You are about to delete the \''.$section->GetTitle().'\' section. '
      .'<br><br>'
      .'Are you really sure wish to delete the \''.$section->GetTitle().'\' '
      .'section?<br>'
      .'<br>'
      .'[ '
      .'<a href="'.internal_link('admin_section_delete', array('id'=>$section->GetID(),'delete'=>$section->GetID())).'">Yes</a> '
      .'| '
      .'<a href="'.internal_link('admin_chapter', array('id'=>$chapter->GetID())).'">No</a> '
      .']';

  }

	admin_library_footer($shelf->GetID(), $book->GetID(), $chapter->GetID());
}
?>
