<?php
function title() {
	return 'High Rollers';
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
        ."ORDER BY roster_rank.`order` ASC, "
                 ."roster_roster.rankcredits DESC, "
                 ."roster_roster.name ASC ";

  $result = mysql_query($sql, $roster->roster_db);

  if ($result && mysql_num_rows($result)) {

    $table = new Table();
    $table->StartRow();
    $table->AddHeader('&nbsp;');
    $table->AddHeader('Rank');
    $table->AddHeader('Hunter');
    $table->AddHeader('Credits');
    $table->EndRow();

    $row_n = 0;
    while ($row = mysql_fetch_array($result)) {
      $row_n++;
      $pleb = $roster->GetPerson($row['id']);
      $rank = $pleb->GetRank();
      $table->AddRow('<div style="text-align: right">'.number_format($row_n).'</div>',
        '<a href="'.internal_link('rank', array('id'=>$rank->GetID())).'">'.$rank->GetAbbrev().'</a>',
        '<a href="'.internal_link('hunter', array('id'=>$pleb->GetID())).'">'.$pleb->GetName().'</a>',
        '<div style="text-align: right">'.number_format($pleb->GetRankCredits()).'</div>');
    }
    $table->EndTable();
  } else {

    print mysql_error();

  }
	
	roster_footer();
}
?>
