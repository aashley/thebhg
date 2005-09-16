<?php
$cadre = $roster->GetCadre($_REQUEST['id']);

function title() {
	global $cadre;
	
	return 'Cadre :: ' . $cadre->GetName();
}

function output() {
	global $cadre, $roster;

  $links = array('title'=>'Cadre Information', 'roster/foaf/cadre.php?id='.$cadre->getID()=>'FOAF');

	roster_header();

  	$leader = $cadre->GetLeader();
	if ($leader->GetID()) {
		echo 'Leader: <a href="' . internal_link('hunter', array('id'=>$leader->GetID())) . '">' . $leader->GetName() . '</a><br>';
	}

	if ($cadre->GetHomePage()) {
		echo 'Home Page: <a href="' . html_escape($cadre->GetHomePage()) . '">' . html_escape($cadre->GetHomePage()) . '</a><br>';
	}

	if ($cadre->GetSlogan()) {
		echo 'Slogan: <i>' . html_escape($cadre->GetSlogan()) . '</i><br>';
	}

	hr();

	$table = new Table('', true);
	
	$table->StartRow();
	$table->AddHeader('Position');
	$table->AddHeader('Rank');
	$table->AddHeader('Name');
	$table->AddHeader('Rank Credits');
	$table->AddHeader('Account Balance');
	$table->EndRow();

	if ($cadre->GetMemberCount()) {
		foreach ($cadre->GetMembers() as $pleb) {
			$table->StartRow();
			$pos = $pleb->GetPosition();
			$table->AddCell('<a href="' . internal_link('position', array('id'=>$pos->GetID())) . '">' . $pos->GetName() . '</a>');
			$rank = $pleb->GetRank();
			$table->AddCell('<a href="' . internal_link('rank', array('id'=>$rank->GetID())) . '">' . $rank->GetName() . '</a>');
			$table->AddCell('<a href="' . internal_link('hunter', array('id'=>$pleb->GetID())) . '">' . html_escape($pleb->GetName()) . '</a>');
			if ($rank->IsUnlimitedCredits()) {
				$table->AddCell('N/A');
				$table->AddCell('N/A');
			}
			else {
				$table->AddCell(number_format($pleb->GetRankCredits()));
				$table->AddCell(number_format($pleb->GetAccountBalance()));
			}
			$table->EndRow();
		}
	}

	$table->EndTable();
	roster_footer();
}
?>
