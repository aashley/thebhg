<?php
$book = $library->GetBook($_REQUEST['id']);
$shelf = $book->GetShelf();

function title() {
	global $book;
	return $book->GetTitle();
}

function output() {
	global $book, $shelf;

	menu_header();

  if ($book->HasImage()) {

    echo '<center><img src="library/book_image.php?id='.$book->GetID().'"></center>';

  }
	echo $book->GetDescription();

  echo '<OL>';
  foreach ($book->GetChapters() as $chapter) {

    echo '<LI><a href="'.internal_link('chapter', array('id'=>$chapter->GetID())).'">'.$chapter->GetTitle().'</a></LI>';

  }
  echo '</OL>';
	library_footer($shelf->GetID(), $book->GetID());
}
?>
