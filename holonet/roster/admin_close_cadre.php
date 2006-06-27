<?php
$auth_data = array();
$cadre = null;
$pleb = null;

function title() {
  return 'Administration :: Close Cadre';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return $auth_data['underlord'];
}

function output() {
  global $auth_data, $cadre, $roster, $pleb, $page;

  roster_header();

  if ($_REQUEST['submit']) {
		$cadre = $roster->GetCadre($_REQUEST['id']);
		if ($cadre->Close())
			echo 'Cadre closed.';
		else
			echo 'Error: '. $cadre->Error();
	}
	else {
		$form = new Form($page);
		$form->StartSelect('Cadre:', 'id');
		foreach ($roster->GetCadres('name') as $div) {
			$form->AddOption($div->GetID(), $div->GetName());
		}
		$form->EndSelect();
		$form->AddSubmitButton('submit', 'Delete Cadre');
		$form->EndForm();
	}
  
  
  
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
