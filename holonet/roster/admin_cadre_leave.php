<?php
$auth_data = array();
$cadre = null;
$pleb = null;

function title() {
  return 'Administration :: Leave Cadre';
}

function auth($person) {
  global $auth_data, $cadre, $pleb, $roster;

  $auth_data = get_auth_data($person);
  $pleb = $roster->GetPerson($person->GetID());
  $cadre = $pleb->GetCadre();

  return ($auth_data['cadre']);
}

function output() {
  global $auth_data, $cadre, $roster, $pleb, $page;

  roster_header();

  if (   isset($_REQUEST['confirm'])
      && $_REQUEST['confirm'] == 'yes') {
    
    if ($cadre->RemoveMember($pleb)) {

      echo 'You have left the '.$cadre->GetName().' Cadre.';

      $pleb = $roster->GetPerson($pleb->GetID());

      // Update the menu
      $auth_data = get_auth_data($pleb);

    } else {

      echo 'Could not leave Cadre: '.$cadre->Error();

    }
    
  } else {

    echo 'Are you really sure you wish to leave the \''.$cadre->GetName()
      .'\' cadre?<br><br>'
      .'[ '
      .'<a href="'.internal_link('admin_cadre_leave', array('confirm'=>'yes'))
      .'">Yes</a> '
      .'| '
      .'<a href="'.internal_link('admin', array()).'">No</a> '
      .']<br>';

  }

  admin_footer($auth_data);

}

?>
