<?php
$book = $library->GetBook($_REQUEST['id']);
$shelf = $book->GetShelf();

function title() {
	global $book;
	return 'Administration :: '.$book->GetTitle().' :: Edit';
}

function auth($user) {
  $div = $user->GetDivision();
  return ($div->GetID() == 10 || $div->GetID() == 9);
}

function output() {
	global $shelf, $book, $page;

	menu_header();

  if (isset($_REQUEST['submit'])) {

    if ($book->SetTitle($_REQUEST['title'])) {

      echo 'Title Saved.<br>';

    } else {

      echo 'Error saving title: '.$book->Error().'<br>';

    }

    if ($book->SetDescription($_REQUEST['desc'])) {
      
      echo 'Description Saved.<br>';

    } else {

      echo 'Error saving description: '.$book->Error().'<br>';

    }

    if (   isset($_FILES['image'])
        && is_array($_FILES['image'])
        && is_uploaded_file($_FILES['image']['tmp_name'])) {

      $imagetype = exif_imagetype($_FILES['image']['tmp_name']);

      if (in_array($imagetype, array(IMAGETYPE_GIF,
                                     IMAGETYPE_JPEG,
                                     IMAGETYPE_PNG))) {

        if ($book->UploadNewImage($_FILES['image'])) {

          echo 'New Image Uploaded.<br>';

        } else {

          echo 'Error saving new image: '.$book->Error().'<br>';

        }

      } else {

        echo 'Invalid Image Type Uploaded.<br>';

      }

    } else {

      echo 'No File Uploaded.<br>';

    }

  } else {

    $form = new Form($page, 'post', $page, 'multipart/form-data');
    $form->AddHidden('id', $_REQUEST['id']);
    $form->AddTextBox('Title:', 'title', $book->GetTitle());
    $form->AddTextArea('Description:', 'desc', $book->GetDescription());
    $form->AddFile('Image:', 'image');
    $form->table->StartRow();
    $form->table->AddCell('&nbsp;');
    $form->table->AddCell('This will replace the current image for the book '
        .'only if a valid image is uploaded.');
    $form->table->EndRow();
    $form->AddSubmitButton('submit', 'Save Changes');
    $form->EndForm();

  }

	admin_library_footer($shelf->GetID(), $book->GetID());
}
?>
