<?php
function title() {
	return 'Hunters';
}

function output() {
	global $roster, $page;

	if (empty($_REQUEST['status'])) {
		$status = 0;
	}
	else {
		$status = $_REQUEST['status'];
	}
	if (empty($_REQUEST['sortrank'])) {
		$sortrank = 0;
	}
	else {
		$sortrank = $_REQUEST['sortrank'];
	}
	if (empty($_REQUEST['pageno'])) {
		$pageno = 0;
	}
	else {
		$pageno = $_REQUEST['pageno'];
	}

	$sql = "SELECT roster_roster.id FROM thebhg_roster.roster_roster, thebhg_roster.roster_position, thebhg_roster.roster_rank WHERE roster_roster.rank = roster_rank.id AND roster_roster.position = roster_position.id ";
	switch ($status) {
		case 0:
			$sql .= "AND roster_roster.division != 16 AND roster_roster.division != 12 AND roster_roster.division != 11 AND roster_roster.division != 0 ";
			break;
		case 1:
			$sql .= "AND roster_roster.division != 0 ";
			break;
		case 2:
			$sql .= "AND roster_roster.division = 12 AND roster_roster.division != 0 ";
			break;
		case 3:
			$sql .= "AND roster_roster.division = 11 AND roster_roster.division != 0 ";
			break;
		case 4:
			$sql .= "AND roster_roster.division = 16 AND roster_roster.division != 0 ";
			break;
	}		

	if ($sortrank) {
		$sql .= " ORDER BY roster_rank.order ASC, roster_roster.rankcredits DESC, roster_roster.name ASC";
	}
	else {
		$sql .= " ORDER BY roster_roster.name ASC";
	}

	$all_hunters = mysql_query($sql, $roster->roster_db);
	$sql .= " LIMIT " . ($pageno * 30) . ",30";
	$hunters = mysql_query($sql, $roster->roster_db);
	roster_header();
	if ($hunters && mysql_num_rows($hunters)) {
		$table = new Table('', true);
		$table->StartRow();
		$table->AddHeader('Name');
		$table->AddHeader('Division');
		$table->AddHeader('Rank');
		$table->AddHeader('Position');
		$table->EndRow();
		while ($hunter = mysql_fetch_array($hunters)) {
			$pleb = $roster->GetPerson($hunter['id']);
			$pos = $pleb->GetPosition();
			$rank = $pleb->GetRank();
			$div = $pleb->GetDivision();
			$table->StartRow();
			$table->AddCell('<a href="' . internal_link('hunter', array('id'=>$pleb->GetID())) . '">' . $pleb->GetName() . '</a>');
			$table->AddCell('<a href="' . internal_link('division', array('id'=>$div->GetID())) . '">' . $div->GetName() . '</a>');
			$table->AddCell('<a href="' . internal_link('rank', array('id'=>$rank->GetID())) . '">' . $rank->GetName() . '</a>');
			$table->AddCell('<a href="' . internal_link('position', array('id'=>$pos->GetID())) . '">' . $pos->GetName() . '</a>');
			$table->EndRow();
		}
		$table->EndTable();
	}
	else {
		echo 'No hunters found.';
	}

	echo '<br>Pages: ';
	if ($pageno > 0) {
		$page_array[] = '<a href="' . internal_link($page, array('pageno'=>($pageno - 1), 'status'=>$status, 'sortrank'=>$sortrank)) . '">Previous</a>';
	}
	$pages = ceil(mysql_num_rows($all_hunters) / 30);
	for ($i = 0; $i < $pages; $i++) {
		if ($i == $page) {
			$page_array[] = ($i + 1);
		}
		else {
			$page_array[] = '<a href="' . internal_link($page, array('pageno'=>($i - 1), 'status'=>$status, 'sortrank'=>$sortrank)) . '">' . ($i + 1) . '</a>';
		}
	}
	if ($pageno < ($pages - 1)) {
		$page_array[] = '<a href="' . internal_link($page, array('pageno'=>($pageno + 1), 'status'=>$status, 'sortrank'=>$sortrank)) . '">Next</a>';
	}
	echo implode(' | ', $page_array);

	hr();

	echo '<b>Options</b><br><br>';
	$form = new Form($page, 'get');
	$form->StartSelect('Hunter Status:', 'status', $status);
	$form->AddOption(0, 'active');
	$form->AddOption(1, 'all');
	$form->AddOption(2, 'retired');
	$form->AddOption(3, 'awol');
	$form->AddOption(4, 'disavowed');
	$form->EndSelect();
	$form->StartSelect('Sort By:', 'sortrank', $sortrank);
	$form->AddOption(0, 'name');
	$form->AddOption(1, 'rank');
	$form->EndSelect();
	$form->AddSubmitButton('', 'Go!');
	$form->EndForm();

	roster_footer();
}
?>
