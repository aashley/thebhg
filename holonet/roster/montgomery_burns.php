<?php
function title() {
	return 'Highest Account Balances';
}

function coders() {
	return array(94, 666);
}

function output() {
	global $roster, $page;

	roster_header();

  $sql = "SELECT roster_roster.id "
        ."FROM roster_roster "
        ."WHERE roster_roster.division NOT IN (16, 11, 0, 12) "
        ."ORDER BY roster_roster.accountbalance DESC, "
                 ."roster_roster.name ASC ";

  $result = mysql_query($sql, $roster->roster_db);

  if ($result && mysql_num_rows($result)) {

    $table = new Table();
    $table->StartRow();
    $table->AddHeader('&nbsp;');
    $table->AddHeader('Hunter');
    $table->AddHeader('Account Balance');
    $table->EndRow();

    $row_n = 0;
    while ($row = mysql_fetch_array($result)) {
      $pleb = $roster->GetPerson($row['id']);
      $rank = $pleb->GetRank();
      if (!$rank->IsUnlimitedCredits()) {
        $row_n++;
        $table->AddRow('<div style="text-align: right">'.number_format($row_n).'</div>',
          '<a href="'.internal_link('hunter', array('id'=>$pleb->GetID())).'">'.$pleb->GetName().'</a>',
          '<div style="text-align: right">'.number_format($pleb->GetAccountBalance()).'</div>');
      }
    }
    $table->EndTable();
  } else {

    print mysql_error();

  }
	
	roster_footer();
}
?>
