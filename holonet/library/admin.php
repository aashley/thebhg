<?php
function title() {
  return 'Administration :: Index';
}

function auth($user) {
  $div = $user->GetDivision();
  return ($div->GetID() == 10 || $div->GetID() == 9);
}

function output() {
  global $library;

  menu_header();

  if (isset($_REQUEST['op'])) {

    switch ($_REQUEST['op']) {

      case 'shelf_down':
        $shelf = $library->GetShelf($_REQUEST['shelf']);
        if (!$shelf->MoveDown()) {
          echo 'Error: '.$shelf->Error().'<br>';
        }
        break;

      case 'shelf_up':
        $shelf = $library->GetShelf($_REQUEST['shelf']);
        if (!$shelf->MoveUp()) {
          echo 'Error: '.$shelf->Error().'<br>';
        }
        break;

    }

  }
  
  echo '<hr><img src="library/images/page.png">'
    .'<a href="'.internal_link('admin_shelf_create').'"><img src="library/images/add.png" border="0"></a>'
    .'<p>Welcome to the BHG Library Administration. From here you can edit all the books contained within this library.</p>';
  
  foreach ($library->GetShelves() as $shelf) {

		echo '<hr><img src="library/images/section.png">'
      .'<a href="'.internal_link('admin_shelf_delete', array('id'=>$shelf->GetID())).'"><img src="library/images/delete.png" border="0"></a>'
      .'<a href="'.internal_link('admin_shelf_edit', array('id'=>$shelf->GetID())).'"><img src="library/images/edit.png" border="0"></a>'
      .'<a href="'.internal_link('admin', array('op'=>'shelf_up','shelf'=>$shelf->GetID())).'"><img src="library/images/moveUp.png" border="0"></a>'
      .'<a href="'.internal_link('admin', array('op'=>'shelf_down','shelf'=>$shelf->GetID())).'"><img src="library/images/moveDown.png" border="0"></a>'
      .'<p><a href="'.internal_link('admin_shelf', array('id'=>$shelf->GetID())).'">'.$shelf->GetName().'</a><small><br>'.$shelf->GetDescription().'</small></p>';

	}


  admin_library_footer($auth_data);
  
}
?>
