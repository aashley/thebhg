<?php
$div = $roster->GetDivision($_REQUEST['id']);

function title() {
	global $div;
	
	return 'Division :: ' . $div->GetName();
}

function output() {
	global $div, $roster;

  $links = array('title'=>'Division Information', 'roster/foaf/division.php?id='.$div->getID()=>'FOAF');
  
	roster_header();

	if ($div->IsKabal() || $div->IsWing()) {
		echo '<table border=0 width="100%"><tr valign="top"><td>';
		if ($div->IsKabal()) {
			$kabal = $roster->GetKabal($div->GetID());
			$chief = $kabal->GetChief();
			$cra = $kabal->GetCRA();
			if ($chief->GetID()) {
				echo 'Chief: <a href="' . internal_link('hunter', array('id'=>$chief->GetID())) . '">' . $chief->GetName() . '</a><br>';
			}
			if ($cra->GetID()) {
				echo 'CRA: <a href="' . internal_link('hunter', array('id'=>$cra->GetID())) . '">' . $cra->GetName() . '</a><br>';
			}
		}
		else {
			$kabal = new Wing($div->GetID());
			$warden = $kabal->GetWarden();
			if ($warden->GetID()) {
				echo 'Warden: <a href="' . internal_link('hunter', array('id'=>$warden->GetID())) . '">' . $warden->GetName() . '</a><br>';
			}
		}
		if ($kabal->GetURL()) {
			echo 'Home Page: <a href="' . $kabal->GetURL() . '">' . $kabal->GetURL() . '</a><br>';
		}
		if ($div->GetMailingList()) {
			echo 'Mailing List: <a href="mailto:' . $div->GetMailingList() . '">' . str_replace(array('.', '@'), array(' [dot] ', ' [at] '), $div->GetMailingList()) . '</a><br>';
		}
		if ($kabal->GetSlogan()) {
			echo 'Slogan: ' . html_escape($kabal->GetSlogan()) . '<br>';
		}
		$report_result = mysql_query('SELECT * FROM hn_reports WHERE division=' . $div->GetID() . ' ORDER BY time DESC LIMIT 1', $roster->roster_db);
		if ($report_result && mysql_num_rows($report_result)) {
			$report = mysql_fetch_array($report_result);
			echo 'Latest Report: <a href="' . internal_link('report', array('id'=>$report['id'])) . '">' . date('j F Y', $report['time']) . '</a><br>';
		}
		echo '</td><td><div style="text-align: right">';
		if ($kabal->HasLogo()) {
			echo '<img src="' . $kabal->GetLogoURL() . '" border=0>';
		}
		else {
			echo '&nbsp;';
		}
		echo '</div></td></tr></table>';

		hr();
	}
	else {
		if ($div->GetMailingList()) {
			echo 'Mailing List: <a href="mailto:' . $div->GetMailingList() . '">' . str_replace(array('.', '@'), array(' [dot] ', ' [at] '), $div->GetMailingList()) . '</a><br>';
		}
		hr();
	}
	
	$table = new Table('', true);
	
	$table->StartRow();
	$table->AddHeader('Position');
	$table->AddHeader('Rank');
	$table->AddHeader('Name');
	$table->AddHeader('Rank Credits');
	$table->AddHeader('Account Balance');
	$table->EndRow();

	if ($div->GetMemberCount()) {
		foreach ($div->GetMembers() as $pleb) {
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
