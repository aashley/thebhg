<?php
$shelf = $library->GetShelf($_REQUEST['id']);

function title() {
	global $shelf;
	return 'Administration :: '.$shelf->GetName().' :: Edit';
}

function auth($user) {
  $div = $user->GetDivision();
  return ($div->GetID() == 10 || $div->GetID() == 9);
}

function output() {
	global $shelf, $page;

	menu_header();

  if (isset($_REQUEST['submit'])) {

    if ($shelf->SetName($_REQUEST['title'])) {

      echo 'Title Saved.<br>';

    } else {

      echo 'Error saving title: '.$shelf->Error().'<br>';

    }

    if ($shelf->SetDescription($_REQUEST['desc'])) {

      echo 'Description Saved.<br>';

    } else {

      echo 'Error saving description: '.$shelf->Error().'<br>';

    }

    echo '<br><a href="'.internal_link('admin_shelf', array('id'=>$shelf->GetID())).'">Back to Shelf</a>';

  } else {

    $form = new Form($page);
    $form->AddHidden('id', $_REQUEST['id']);
    $form->AddTextBox('Title:', 'title', $shelf->GetName());
    $form->AddTextArea('Description:', 'desc', $shelf->GetDescription());
    $form->AddSubmitButton('submit', 'Save Changes');
    $form->EndForm();

  }

	admin_library_footer($shelf->GetID());
}
?>
