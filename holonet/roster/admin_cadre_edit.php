<?php
$auth_data = array();
$cadre = null;
$pleb = null;

function title() {
  return 'Administration :: Edit Cadre Details';
}

function auth($person) {
  global $auth_data, $cadre, $pleb, $roster;

  $auth_data = get_auth_data($person);
  $pleb = $roster->GetPerson($person->GetID());
  $cadre = $pleb->GetCadre();

  return ($auth_data['cadre-leader']);
}

function output() {
  global $auth_data, $cadre, $roster, $page, $pleb;

  roster_header();

  if ($_REQUEST['submit']) {
    
    $cadre->SetName($_REQUEST['name']) || print 'Could not save cadre name: ' . $cadre->Error() . '<br>';
    $cadre->SetHomePage($_REQUEST['homepage']) || print 'Could not save cadre home page: ' . $cadre->Error() . '<br>';
    $cadre->SetSlogan($_REQUEST['slogan']) || print 'Could not save cadre slogan: ' . $cadre->Error() . '<br>';

    echo 'Cadre saved.';
    
  } else {

    $form = new Form($page);
    $form->AddTextBox('Name:', 'name', $cadre->GetName(), 40);
    $form->AddTextBox('Home Page:', 'homepage', $cadre->GetHomePage(), 40);
    $form->AddTextBox('Slogan:', 'slogan', $cadre->GetSlogan(), 40);
    $form->AddSubmitButton('submit', 'Save Cadre Details');
    $form->EndForm();

  }

  admin_footer($auth_data);

}

?>
