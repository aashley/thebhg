<?php
$auth_data = array();
$cadre = null;
$pleb = null;

function title() {
  return 'Administration :: Manage Cadre Membership';
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

  if (isset($_REQUEST['submit'])) {

    if ($_REQUEST['submit'] == 'add') {

      $m = $roster->GetPerson($_REQUEST['hunter']);

      if ($cadre->AddMember($m)) {

        print $m->GetName().' added to Cadre roster.<br><br>';

        $sql = 'DELETE FROM hn_cadre_applications '
              .'WHERE person = '.$m->GetID();

        mysql_query($sql, $roster->roster_db);

      } else {

        print 'Could not add '.$m->GetName().' to Cadre roster.<br><br>';

      }
    
    } elseif ($_REQUEST['submit'] == 'remove') {
      
      $m = $roster->GetPerson($_REQUEST['hunter']);

      if ($cadre->RemoveMember($m)) {

        print $m->GetName().' removed from Cadre roster.<br><br>';

      } else {

        print 'Could not remove '.$m->GetName().' from Cadre roster.<br>'
          .$cadre->Error().'<br><br>';

      }

     }
   
  }

  print 'Current Members:';

  $members = $cadre->GetMembers();

  $table = new Table();

  $table->StartRow();
  $table->AddHeader('Name');
  $table->AddHeader('E-Mail');
  $table->AddHeader('');
  $table->EndRow();

  foreach ($members as $member) {

    if ($member->GetID() == $pleb->GetID()) {

      $table->AddRow('<a href="'.internal_link('hunter', array('id'=>$member->GetID())).'">'.$member->GetName().'</a>',
          '<a href="mailto:'.$member->GetEmail().'">'.$member->GetEmail().'</a>',
          '&nbsp;');

    } else {

      $table->AddRow('<a href="'.internal_link('hunter', array('id'=>$member->GetID())).'">'.$member->GetName().'</a>',
          '<a href="mailto:'.$member->GetEmail().'">'.$member->GetEmail().'</a>',
          '<a href="'.internal_link('admin_cadre_buy_members', array('submit'=>'remove','hunter'=>$member->GetID())).'">Remove</a>');

    }

  }

  $table->EndTable();

  hr();

  print 'New Member Applications: ';

  $sql = 'SELECT person '
        .'FROM hn_cadre_applications '
        .'WHERE cadre = '.$cadre->GetID();

  $members = mysql_query($sql, $roster->roster_db);

  if (mysql_num_rows($members) > 0) {

    $table = new Table();

    $table->StartRow();
    $table->AddHeader('Name');
    $table->AddHeader('Cost');
    $table->AddHeader('In Cadre?');
    $table->AddHeader('Can Join This Cadre?');
    $table->AddHeader('');
    $table->EndRow();

    while ($member = mysql_fetch_assoc($members)) {

      $m = $roster->GetPerson($member['person']);

      $table->AddRow(
          '<a href="'.internal_link('hunter', array('id'=>$m->GetID())).'">'
            .$m->GetName().'</a>',
          $cadre->GetCostToJoin($m),
          ($m->InCadre() ? 'Yes' : 'No'),
          ($cadre->CanJoin($m) ? 'Yes' : 'No'),
          ($cadre->CanJoin($m) 
           ? '<a href="'.internal_link('admin_cadre_buy_members',
                                       array('submit'=>'add',
                                             'hunter'=>$m->GetID()))
             .'">Add</a>'
           : ''));
      
    }

    $table->EndTable();

  } else {

    print 'None.<br>';

  }

  admin_footer($auth_data);

}

?>
