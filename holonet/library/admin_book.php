<?php
$book = $library->GetBook($_REQUEST['id']);
$shelf = $book->GetShelf();

function title() {
	global $book;
	return 'Administration :: '.$book->GetTitle();
}

function auth($user) {
  $div = $user->GetDivision();
  return ($div->GetID() == 10 || $div->GetID() == 9);
}

function output() {
	global $shelf, $book;

	menu_header();

  if (isset($_REQUEST['op'])) {

    switch ($_REQUEST['op']) {

      case 'chapter_up':
        $chapter = $book->GetChapter($_REQUEST['chapter']);
        $chapter->MoveUp();
        break;

      case 'chapter_down':
        $chapter = $book->GetChapter($_REQUEST['chapter']);
        $chapter->MoveDown();
        break;

      case 'chapter_create':
        $book->AddChapter();
        break;

    }

  }

  echo '<img src="library/images/page.png">'
      .'<a href="'.internal_link('admin_book_delete', array('id'=>$book->GetID())).'"><img src="library/images/delete.png" border="0"></a>'
      .'<a href="'.internal_link('admin_book_edit', array('id'=>$book->GetID())).'"><img src="library/images/edit.png" border="0"></a>'
    .'<a href="'.internal_link('admin_book', array('id'=>$book->GetID(),'op'=>'chapter_create')).'"><img src="library/images/add.png" border="0"></a>';
  
  if ($book->HasImage()) {

    echo '<center><img src="library/book_image.php?id='.$book->GetID().'"></center>';

  }
	echo $book->GetDescription();

  echo '<OL>';
  foreach ($book->GetChapters() as $chapter) {

    echo '<hr><img src="library/images/section.png">'
      .'<a href="'.internal_link('admin_chapter_delete', array('id'=>$chapter->GetID())).'"><img src="library/images/delete.png" border="0"></a>'
      .'<a href="'.internal_link('admin_chapter_edit', array('id'=>$chapter->GetID())).'"><img src="library/images/edit.png" border="0"></a>'
      .'<a href="'.internal_link('admin_book', array('id'=>$book->GetID(),'op'=>'chapter_up','chapter'=>$chapter->GetID())).'"><img src="library/images/moveUp.png" border="0"></a>'
      .'<a href="'.internal_link('admin_book', array('id'=>$book->GetID(),'op'=>'chapter_down','chapter'=>$chapter->GetID())).'"><img src="library/images/moveDown.png" border="0"></a>'
      .'<LI><a href="'.internal_link('admin_chapter', array('id'=>$chapter->GetID())).'">'.$chapter->GetTitle().'</a></LI>';

  }
  echo '</OL>';

	admin_library_footer($shelf->GetID(), $book->GetID());
}
?>
