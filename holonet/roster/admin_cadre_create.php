<?php
$auth_data = array();
$pleb = null;

function title() {
  return 'Administration :: Create Cadre';
}

function auth($person) {
  global $auth_data, $roster, $pleb;

  $auth_data = get_auth_data($person);
  $pleb = $roster->GetPerson($person->GetID());

  return (   $auth_data['cadre-create'] 
          && !$auth_data['cadre-leader']
          && !$auth_data['cadre']);
}

function output() {
  global $auth_data, $roster, $pleb, $page;

  roster_header();

  if ($_REQUEST['submit']) {
    
    if ($cadre = $roster->CreateCadre($pleb, $_REQUEST['name'])) {

      echo 'Cadre created.';

      $pleb = $cadre->GetLeader();

      // update menu
      $auth_data = get_auth_data($pleb);

    } else {

      echo 'Could not create Cadre: '.$roster->Error();

    }
    
  } else {

    $form = new Form($page);
    $form->AddTextBox('Name:', 'name', null, 40);
    $form->AddSubmitButton('submit', 'Create Cadre');
    $form->EndForm();

  }

  admin_footer($auth_data);

}

?>
