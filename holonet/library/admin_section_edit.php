<?php
$section = $library->GetSection($_REQUEST['id']);
$chapter = $section->GetChapter();
$book = $chapter->GetBook();
$shelf = $book->GetShelf();

function title() {
	global $book, $chapter;
	return 'Administration :: '.$book->GetTitle().' :: '.$chapter->GetTitle().' :: Edit Section';
}

function auth($user) {
  $div = $user->GetDivision();
  return ($div->GetID() == 10 || $div->GetID() == 9);
}

function output() {
	global $section, $chapter, $book, $shelf, $page;

	menu_header();

  if (isset($_REQUEST['submit'])) {

    if ($section->SetTitle($_REQUEST['title'])) {

      echo 'Title Saved.<br>';

    } else {

      echo 'Error saving title: '.$section->Error().'<br>';

    }

    if ($section->SetBody($_REQUEST['body'])) {

      echo 'Body Saved.<br>';

    } else {

      echo 'Error saving body: '.$section->Error().'<br>';

    }

    echo '<br><a href="'.internal_link('admin_chapter', array('id'=>$chapter->GetID())).'">Back to Chapter</a><br>';

  } else {

    $form = new Form($page);
    $form->AddHidden('id', $_REQUEST['id']);
    $form->AddTextBox('Title:', 'title', $section->GetTitle());
    $form->AddTextArea('Body:', 'body', $section->GetBody());
    $form->AddSubmitButton('submit', 'Save Changes');
    $form->EndForm();

  }

	admin_library_footer($shelf->GetID(), $book->GetID(), $chapter->GetID());
}
?>
