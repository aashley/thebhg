<?php
$shelf = $library->GetShelf($_REQUEST['id']);

function title() {
	global $shelf;
	return 'Administration :: '.$shelf->GetName();
}

function auth($user) {
  $div = $user->GetDivision();
  return ($div->GetID() == 10 || $div->GetID() == 9);
}

function output() {
	global $shelf;

	menu_header();

  if (isset($_REQUEST['op'])) {

    switch ($_REQUEST['op']) {

      case 'shelf_up':
        $shelf->MoveUp();
        break;

      case 'shelf_down':
        $shelf->MoveDown();
        break;

    }

  }

  echo '<img src="library/images/page.png">'
    .'<a href="'.internal_link('admin_shelf_delete', array('id'=>$shelf->GetID())).'"><img src="library/images/delete.png" border="0"></a>'
    .'<a href="'.internal_link('admin_shelf_edit', array('id'=>$shelf->GetID())).'"><img src="library/images/edit.png" border="0"></a>'
    .'<a href="'.internal_link('admin_shelf', array('id'=>$shelf->GetID(),'op'=>'shelf_up')).'"><img src="library/images/moveUp.png" border="0"></a>'
    .'<a href="'.internal_link('admin_shelf', array('id'=>$shelf->GetID(),'op'=>'shelf_down')).'"><img src="library/images/moveDown.png" border="0"></a>'
    .'<a href="'.internal_link('admin_book_create', array('shelf'=>$shelf->GetID())).'"><img src="library/images/add.png" border="0"></a>';

	echo '<p>'.$shelf->GetDescription().'</p>';

  echo '<p>Available Books:</p>';

	foreach ($shelf->GetBooks() as $book) {

  	print '<hr><img src="library/images/section.png">'
      .'<a href="'.internal_link('admin_book_delete', array('id'=>$book->GetID())).'"><img src="library/images/delete.png" border="0"></a>'
      .'<a href="'.internal_link('admin_book_edit', array('id'=>$book->GetID())).'"><img src="library/images/edit.png" border="0"></a>'
      .'<p><a href="'.internal_link('admin_book', array('id'=>$book->GetID())).'">'.$book->GetTitle().'</a><small><br>'.$book->GetDescription().'</p>';

  }

	admin_library_footer($shelf->GetID());
}
?>
