<?php
function title() {
	return 'Search';
}

function output() {
	global $roster;

	$results = array();
	$changed = array();
	switch ($_REQUEST['searchtype']) {
		case 'searchid':
			$pleb = $roster->GetPerson($_REQUEST['searchfor']);
			if ($pleb) {
				$results[0] = $pleb;
				header('Location: http://' . $_SERVER['HTTP_HOST'] . str_replace('&amp;', '&', internal_link('hunter', array('id'=>$_REQUEST['searchfor']))));
			}
			else {
				$results = false;
			}
			break;
		case 'searchname':
			$results = $roster->SearchName($_REQUEST['searchfor']);
			if ($results) {
				foreach ($results as $pleb) {
					$roster_ids[] = $pleb->GetID();
				}
			}
			else {
				$roster_ids = array();
			}
			$name_change_result = mysql_query('SELECT person, item1 FROM roster_history WHERE type=4 AND item1 LIKE "%' . addslashes($_REQUEST['searchfor']) . '%"', $roster->roster_db);
			if ($name_change_result && mysql_num_rows($name_change_result)) {
				while ($nc_row = mysql_fetch_array($name_change_result)) {
					if (!in_array($nc_row['person'], $roster_ids)) {
						$changed[stripslashes($nc_row['item1'])] = $roster->GetPerson($nc_row['person']);
					}
				}
			}
			break;
		case 'searchemail':
			$results = $roster->SearchEmail($_REQUEST['searchfor']);
			break;
		case 'searchircnick':
			$results = $roster->SearchIRCNick($_REQUEST['searchfor']);
			break;
		case 'searchposition':
			$results = $roster->SearchPosition($_REQUEST['searchfor']);
			break;
		case 'searchrank':
			$results = $roster->SearchRank($_REQUEST['searchfor']);
	}

	if ($results && empty($_REQUEST['disavowed'])) {
		$new_results = array();
		foreach ($results as $pleb) {
			$div = $pleb->GetDivision();
			if ($div->GetID() != 16) {
				$new_results[] = $pleb;
			}
		}
		$results = $new_results;
	}

	roster_header();

	if ($results) {
		$table = new Table('', true);
		$table->StartRow();
		$table->AddHeader('Name');
		$table->AddHeader('Division');
		$table->AddHeader('Rank');
		$table->AddHeader('Position');
		$table->EndRow();
		foreach ($results as $pleb) {
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
		echo 'No hunters were found matching the criteria given.';
	}

	if (count($changed)) {
		ksort($changed);
		
		hr();
		
		$table = new Table('Old Names', true);
		$table->StartRow();
		$table->AddHeader('Old Name');
		$table->AddHeader('Current Name');
		$table->AddHeader('Division');
		$table->AddHeader('Rank');
		$table->AddHeader('Position');
		$table->EndRow();
		foreach ($changed as $old_name=>$pleb) {
			$pos = $pleb->GetPosition();
			$rank = $pleb->GetRank();
			$div = $pleb->GetDivision();
			$table->StartRow();
			$table->AddCell('<a href="' . internal_link('hunter', array('id'=>$pleb->GetID())) . '">' . $old_name . '</a>');
			$table->AddCell('<a href="' . internal_link('hunter', array('id'=>$pleb->GetID())) . '">' . $pleb->GetName() . '</a>');
			$table->AddCell('<a href="' . internal_link('division', array('id'=>$div->GetID())) . '">' . $div->GetName() . '</a>');
			$table->AddCell('<a href="' . internal_link('rank', array('id'=>$rank->GetID())) . '">' . $rank->GetName() . '</a>');
			$table->AddCell('<a href="' . internal_link('position', array('id'=>$pos->GetID())) . '">' . $pos->GetName() . '</a>');
			$table->EndRow();
		}
		$table->EndTable();
	}

	roster_footer();
}
?>
