<?php
function title() {
	global $library;
	return 'Administration :: Create Shelf';
}

function auth($user) {
  $div = $user->GetDivision();
  return ($div->GetID() == 10 || $div->GetID() == 9);
}

function output() {
	global $library, $page;

	menu_header();

  if (isset($_REQUEST['submit'])) {

    $shelf = $library->CreateShelf($_REQUEST['title']);

    if ($shelf === false) {

      print 'Error creating shelf: '.$shelf->Error().'<br>'

        .'<br><a href="'.internal_link('admin').'">Back to Admin</a>';

    } else {

      print 'Shelf Created.<br>'
        .'<br><a href="'
        .internal_link('admin_shelf', array('id'=>$shelf->GetID()))
        .'">Back to New Shelf</a>';
      
    }

  } else {

    $form = new Form($page);
    $form->AddHidden('id', $_REQUEST['id']);
    $form->AddTextBox('Title:', 'title');
    $form->AddSubmitButton('submit', 'Create');
    $form->EndForm();

  }

	admin_library_footer();
}
?>
