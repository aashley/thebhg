<?php
$auth_data = array();
$pleb = null;

function title() {
  return 'Administration :: Apply to Cadre';
}

function auth($person) {
  global $auth_data, $pleb, $roster;

  $auth_data = get_auth_data($person);
  $pleb = $roster->GetPerson($person->GetID());

  return (!$auth_data['cadre']);
}

function output() {
  global $auth_data, $roster, $pleb, $page;

  roster_header();

  if ($_REQUEST['submit']) {

    if ($_REQUEST['submit'] == 'withdraw') {

      $sql = 'DELETE FROM hn_cadre_applications '
            .'WHERE cadre = '.$_REQUEST['cadre'].' '
              .'AND person = '.$pleb->GetID();

      if (mysql_query($sql, $roster->roster_db)) {

        print 'Application Withdrawn.<br><br>';

      } else {

        print 'Could not withdraw application.<br><br>';

      }

    } else {

      $sql = 'INSERT INTO hn_cadre_applications (cadre, '
                                             .'person) '
            ."VALUES (".$_REQUEST['cadre'].', '
                       .$pleb->GetID().')';

      if (mysql_query($sql, $roster->roster_db)) {

        print 'Application Saved.<br><br>';

      } else {

        print 'Could not save application.<br><br>';

      }

    }

  }

  $sql = 'SELECT cadre '
        .'FROM hn_cadre_applications '
        .'WHERE person = '.$pleb->GetID();

  $cadres = mysql_query($sql, $roster->roster_db);

  print 'Current Applications: ';

  if (mysql_num_rows($cadres) > 0) {

    $table = new Table();

    $table->StartRow();
    $table->AddHeader('Cadre Name');
    $table->AddHeader('Leader');
    $table->AddHeader('');
    $table->EndRow();

    while ($cadre = mysql_fetch_assoc($cadres)) {

      $c = $roster->GetCadre($cadre['cadre']);
      $leader = $c->GetLeader();

      $table->AddRow('<a href="'.internal_link('cadre', array('id'=>$c->GetID())).'">'.$c->GetName().'</a>', 
          '<a href="'.internal_link('hunter', array('id'=>$leader->GetID())).'">'.$leader->GetName().'</a>',
          '<a href="'.internal_link('admin_cadre_apply', array('submit'=>'withdraw', 'cadre'=>$c->GetID())).'">Withdraw</a>');

    }

    $table->EndTable();

  } else {

    print 'None.<br>';

  }

  hr();

  $form = new Form($page);
  $form->StartSelect('Cadre:', 'cadre');
  $cadres = $roster->GetCadres();
  foreach ($cadres as $cadre) {
    $form->AddOption($cadre->GetID(), $cadre->GetName());
  }
  $form->EndSelect();
  $form->AddSubmitButton('submit', 'Apply to Cadre');
  $form->EndForm();

  admin_footer($auth_data);

}
?>
