<?php
function title() {
	return 'Time in Service';
}

function coders() {
	return array(94);
}

function output() {
	global $roster, $page;

	roster_header();

  $sql = "SELECT roster_roster.id "
        ."FROM roster_roster, "
             ."roster_rank "
        ."WHERE roster_roster.division != 16 "
          ."AND roster_roster.division != 11 "
          ."AND roster_roster.division != 0 "
          ."AND roster_roster.division != 12 "
          ."AND roster_roster.rank = roster_rank.id "
        ."ORDER BY roster_roster.date_joined ASC, "
                 ."roster_rank.`order` ASC ";

  $result = mysql_query($sql, $roster->roster_db);

  if ($result && mysql_num_rows($result)) {

    $table = new Table();
    $table->StartRow();
    $table->AddHeader('&nbsp;');
    $table->AddHeader('Hunter');
    $table->AddHeader('Join Date');
    $table->EndRow();

    $row_n = 0;
    while ($row = mysql_fetch_array($result)) {
      $row_n++;
      $pleb = $roster->GetPerson($row['id']);
      $table->AddRow('<div style="text-align: right">'.number_format($row_n).'</div>',
        '<a href="'.internal_link('hunter', array('id'=>$pleb->GetID())).'">'.$pleb->GetName().'</a>',
        date('d M Y', $pleb->GetJoinDate()));
    }
    $table->EndTable();
  }
	
	roster_footer();
}
?>
