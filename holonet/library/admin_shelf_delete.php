<?php
$shelf = $library->GetShelf($_REQUEST['id']);

function title() {
	global $shelf;
	return 'Administration :: '.$shelf->GetName().' :: Delete';
}

function auth($user) {
  $div = $user->GetDivision();
  return ($div->GetID() == 10 || $div->GetID() == 9);
}

function output() {
	global $shelf, $page;

	menu_header();

  if (   isset($_REQUEST['delete'])
      && $_REQUEST['delete'] == $_REQUEST['id']) {

    $url = internal_link('admin');

    if ($shelf->Delete()) {

      print 'Shelf Deleted.<br>';

    } else {

      print 'Error deleting shelf: '.$shelf->Error().'<br>';

    }

    echo '<br><a href="'.$url.'">Back to Admin</a>';

  } else {

    echo 'You are about to delete the \''.$shelf->GetName().'\' shelf. '
      .'Deleting a Shelf also deletes all books that are on that shelf. This '
      .'action can not be undone.<br><br>'
      .'Are you really sure wish to delete the \''.$shelf->GetName().'\' '
      .'shelf?<br>'
      .'<br>'
      .'[ '
      .'<a href="'.internal_link('admin_shelf_delete', array('id'=>$shelf->GetID(),'delete'=>$shelf->GetID())).'">Yes</a> '
      .'| '
      .'<a href="'.internal_link('admin_shelf', array('id'=>$shelf->GetID())).'">No</a> '
      .']';

  }

	admin_library_footer($shelf->GetID());
}
?>
