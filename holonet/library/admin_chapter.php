<?php
$chapter = $library->GetChapter($_REQUEST['id']);
$book = $chapter->GetBook();
$shelf = $book->GetShelf();

function title() {
	global $book, $chapter;
	return 'Administration :: '.$book->GetTitle().' :: '.$chapter->GetTitle();
}

function auth($user) {
  $div = $user->GetDivision();
  return ($div->GetID() == 10 || $div->GetID() == 9);
}

function output() {
	global $shelf, $book, $chapter;

	menu_header();

  if (isset($_REQUEST['op'])) {

    switch ($_REQUEST['op']) {

      case 'chapter_up':
        $chapter->MoveUp();
        break;
        

      case 'chapter_down':
        $chapter->MoveDown();
        break;

      case 'section_up':
        $section = $chapter->GetSection($_REQUEST['section']);
        $section->MoveUp();
        break;

      case 'section_down':
        $section = $chapter->GetSection($_REQUEST['section']);
        $section->MoveDown();
        break;

      case 'section_create':
        $chapter->AddSection();
        break;

    }

  }
  
  echo '<img src="library/images/page.png">'
    .'<a href="'.internal_link('admin_chapter_delete', array('id'=>$chapter->GetID())).'"><img src="library/images/delete.png" border="0"></a>'
    .'<a href="'.internal_link('admin_chapter_edit', array('id'=>$chapter->GetID())).'"><img src="library/images/edit.png" border="0"></a>'
    .'<a href="'.internal_link('admin_chapter', array('id'=>$chapter->GetID(),'op'=>'chapter_up')).'"><img src="library/images/moveUp.png" border="0"></a>'
    .'<a href="'.internal_link('admin_chapter', array('id'=>$chapter->GetID(),'op'=>'chapter_down')).'"><img src="library/images/moveDown.png" border="0"></a>'
    .'<a href="'.internal_link('admin_chapter', array('id'=>$chapter->GetID(),'op'=>'section_create')).'"><img src="library/images/add.png" border="0"></a>';

	foreach ($chapter->GetSections() as $section) {
    echo '<hr><img src="library/images/section.png">'
      .'<a href="'.internal_link('admin_section_delete', array('id'=>$section->GetID())).'"><img src="library/images/delete.png" border="0"></a>'
      .'<a href="'.internal_link('admin_section_edit', array('id'=>$section->GetID())).'"><img src="library/images/edit.png" border="0"></a>'
      .'<a href="'.internal_link('admin_chapter', array('id'=>$chapter->GetID(),'op'=>'section_up','section'=>$section->GetID())).'"><img src="library/images/moveUp.png" border="0"></a>'
      .'<a href="'.internal_link('admin_chapter', array('id'=>$chapter->GetID(),'op'=>'section_down','section'=>$section->GetID())).'"><img src="library/images/moveDown.png" border="0"></a><br>';
		if ($section->GetTitle()) {
			echo '<b>' . $section->GetTitle() . '</b><br><br>';
		}
		echo $section->GetBody();
	}
	
	admin_library_footer($shelf->GetID(), $book->GetID(), $chapter->GetID());
}
?>
