<?php
function title() {
	return 'Hall of Fame Voters';
}

function coders() {
	return array(94);
}

function output() {
	global $roster, $page;

	roster_header();

  $sql = "SELECT roster_roster.id "
        ."FROM roster_roster, "
             ."roster_rank, "
             ."roster_position "
        ."WHERE (   roster_roster.position <= 9 "
	       ."OR roster_roster.position = 29 "
               ."OR (    roster_roster.rank >= 12 "
                   ."AND roster_roster.date_joined <= "
                       ."\"".(date('Y') - 3)."-".date('m')."-".date('d')."\")) "
          ."AND roster_roster.division != 16 "
          ."AND roster_roster.division != 11 "
          ."AND roster_roster.division != 0 "
          ."AND roster_roster.division != 12 "
          ."AND roster_roster.rank = roster_rank.id "
          ."AND roster_roster.position = roster_position.id "
        ."ORDER BY roster_position.`order` ASC, "
                 ."roster_rank.`order` ASC ";

  $result = mysql_query($sql, $roster->roster_db);

  if ($result && mysql_num_rows($result)) {

    $table = new Table();
    $table->StartRow();
    $table->AddHeader('&nbsp;');
    $table->AddHeader('Hunter');
    $table->EndRow();

    $row_n = 0;
    while ($row = mysql_fetch_array($result)) {
      $row_n++;
      $pleb = $roster->GetPerson($row['id']);
      $table->AddRow('<div style="text-align: right">'.number_format($row_n).'</div>',
        '<a href="'.internal_link('hunter', array('id'=>$pleb->GetID())).'">'.$pleb->GetName().'</a>');
    }
    $table->EndTable();
  } else {

    print $sql;

  }
	
	roster_footer();
}
?>
