<?php
$shelf = $library->GetShelf($_REQUEST['shelf']);

function title() {
	global $shelf;
	return 'Administration :: '.$shelf->GetName().' :: Create Book';
}

function auth($user) {
  $div = $user->GetDivision();
  return ($div->GetID() == 10 || $div->GetID() == 9);
}

function output() {
	global $shelf, $page;

	menu_header();
  
  if (isset($_REQUEST['submit'])) {

    $book = $shelf->CreateBook($_REQUEST['title']);

    if ($book === false) {

      print 'Error creating book: '.$shelf->Error().'<br>'

        .'<br><a href="'.internal_link('admin_shelf', array('id'=>$shelf->GetID())).'">Back to Shelf Admin</a>';

    } else {

      print 'Book Created.<br>'
        .'<br><a href="'
        .internal_link('admin_book', array('id'=>$book->GetID()))
        .'">Back to New Book</a>';
      
    }

  } else {

    $form = new Form($page);
    $form->AddHidden('shelf', $_REQUEST['shelf']);
    $form->AddTextBox('Title:', 'title');
    $form->AddSubmitButton('submit', 'Create');
    $form->EndForm();

  }

	admin_library_footer($shelf->GetID());
}
?>
