<?php
$auth_data = array();
$cadre = null;
$pleb = null;

function title() {
  return 'Administration :: Close Cadre';
}

function auth($person) {
  global $auth_data, $cadre, $pleb, $roster;

  $auth_data = get_auth_data($person);
  $pleb = $roster->GetPerson($person->GetID());
  $cadre = $pleb->GetCadre();

  return ($auth_data['cadre-leader']);
}

function output() {
  global $auth_data, $cadre, $roster, $pleb, $page;

  roster_header();

  if (   isset($_REQUEST['confirm'])
      && $_REQUEST['confirm'] == 'yes') {
    
    if ($cadre->Close()) {

      echo 'Cadre has been closed.';

      $pleb = $roster->GetPerson($pleb->GetID());

      // Update the menu
      $auth_data = get_auth_data($pleb);

    } else {

      echo 'Could not close Cadre: '.$cadre->Error();

    }
    
  } else {

    echo 'Are you really sure you wish to close the \''.$cadre->GetName()
      .'\' cadre?<br><br>'
      .'Once closed it can not be restored and will need to be recreated.'
      .'<br><br>'
      .'[ '
      .'<a href="'.internal_link('admin_cadre_close', array('confirm'=>'yes'))
      .'">Yes</a> '
      .'| '
      .'<a href="'.internal_link('admin', array()).'">No</a> '
      .']<br>';

  }

  admin_footer($auth_data);

}

?>
