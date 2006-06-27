<?php
// Include the Calypso classes. We're not doing this in header.php because no
// other pages need them, and it would just increase execution time.
/*if (file_exists('/home/virtual/thebhg.org/home/blogs/Objects/Calypso.class.php')) {
	include_once('/home/virtual/thebhg.org/home/blogs/Objects/Calypso.class.php');
	$calypso = new Calypso();
}*/

// Also include the Citadel classes, since this is one of only two pages where
// they are used.
include_once('citadel.inc');
$citadel = new Citadel();

$pleb = $roster->GetPerson($_REQUEST['id']);

function title() {
	global $pleb;
	
	return 'Hunter :: ' . $pleb->GetName();
}

function output() {
	global $pleb, $roster, $citadel;

	$links = array('title'=>'Hunter Information', '#personal'=>'Personal Details', '#property'=>'Personal Property', '#history'=>'Recent History', '#medals'=>'Recent Medals', '#courses'=>'Recent Courses');

	$rank = $pleb->GetRank();
	$pos = $pleb->GetPosition();
	$div = $pleb->GetDivision();
	$cadre = $pleb->GetCadre();

	// Check for reports.
	$report_result = mysql_query('SELECT * FROM hn_reports WHERE author=' . $pleb->GetID() . ' ORDER BY time DESC', $roster->roster_db);
	$reports = array();
	if ($report_result && mysql_num_rows($report_result)) {
		while ($report = mysql_fetch_array($report_result)) {
			$reports[] = $report;
		}
		$links['#reports'] = 'Recent Reports';
	}

  //$links['roster/foaf/person.php?id='.$pleb->getID()] = 'FOAF';

	roster_header();
	
	echo '<table border=0 width="100%"><tr valign="top"><td>';

	echo '<a name="personal"></a>';
	$table = new Table();
	$table->StartRow();
	$table->AddHeader('Personal Details', 2);
	$table->EndRow();
	$table->AddRow('ID Number:', $pleb->GetID());
	$table->AddRow('Name:', html_escape($pleb->GetName()));
	$table->AddRow('Rank:', '<a href="' . internal_link('rank', array('id'=>$rank->GetID())) . '">' . $rank->GetName() . '</a>');
	$table->AddRow('Position:', '<a href="' . internal_link('position', array('id'=>$pos->GetID())) . '">' . $pos->GetName() . '</a>');
	$table->AddRow('Division:', '<a href="' . internal_link('division', array('id'=>$div->GetID())) . '">' . $div->GetName() . '</a>');
  if ($pleb->InCadre()) {
    $table->AddRow('Cadre:', '<a href="' . internal_link('cadre', array('id'=>$cadre->GetID())) . '">' . $cadre->GetName() . '</a>');
  }
	if ($pleb->GetQuote()) {
		$table->AddRow('Quote:', '<i>' . html_escape($pleb->GetQuote()) . '</i>');
	}
	if ($div->GetID() != 16) {
		$table->AddRow('E-Mail Address:', '<a href="mailto:' . html_escape($pleb->GetEmail()) . '">' . html_escape(str_replace(array('.', '@'), array(' [dot] ', ' [at] '), $pleb->GetEmail())) . '</a>');
		if ($pleb->GetHomePage()) {
			$table->AddRow('Home Page:', '<a href="' . html_escape($pleb->GetHomePage()) . '">' . html_escape($pleb->GetHomePage()) . '</a>');
		}
		if ($pleb->GetIRCNicks()) {
			$table->AddRow('IRC Nicks:', html_escape($pleb->GetIRCNicks()));
		}
		if ($pleb->GetAIM()) {
			$table->AddRow('AIM Screen Name:', html_escape($pleb->GetAIM()));
		}
		if ($pleb->GetICQ()) {
			$table->AddRow('ICQ Number:', html_escape($pleb->GetICQ()));
		}
		if ($pleb->GetJabber()) {
			$table->AddRow('Jabber ID:', html_escape($pleb->GetJabber()));
		}
		if ($pleb->GetMSN()) {
			$table->AddRow('MSN Passport Name:', html_escape($pleb->GetMSN()));
		}
		if ($pleb->GetYahoo()) {
			$table->AddRow('Yahoo Messager ID:', html_escape($pleb->GetYahoo()));
		}
	}
	$table->AddRow('Total Credits Earned:', ($rank->IsUnlimitedCredits() ? 'N/A' : number_format($pleb->GetRankCredits())) . ' ICs');
	$table->AddRow('Account Balance:', ($rank->IsUnlimitedCredits() ? 'N/A' : number_format($pleb->GetAccountBalance())) . ' ICs');
	$table->AddRow('Time in the BHG:', format_time(time() - $pleb->GetJoinDate(), FT_DAY));
  $table->AddRow('Join Date:', date('jS F Y', $pleb->GetJoinDate()));

	$history = new PersonHistory($pleb->GetID());
	$history->Load(0, 0, array(1), 'DESC');
	if ($history->Count()) {
		$item = $history->GetItem();
		$promoDate = $item->GetDate();
	}
	else {
		$promoDate = $pleb->GetJoinDate();
	}
	$table->AddRow('Time at Current Rank:', format_time(time() - $promoDate, FT_DAY));
	$table->AddRow('Last Promotion Date:', date('jS F Y', $promoDate));
	
	$table->AddRow('ID Line:', html_escape($pleb->IDLine()));
	$table->EndTable();
	
	echo '</td><td><div style="text-align: right"><a href="roster/armour/armour.php?id=' . $pleb->GetID() . '"><img src="roster/armour/armour.php?id=' . $pleb->GetID() . '&amp;mini=1" alt="Armour" width=160 height=120 border=0></a><br><br><a href="roster/ipkc/ipkc2.php?id=' . $pleb->GetID() . '"><img src="roster/ipkc/ipkc2.php?id=' . $pleb->GetID() . '&amp;mini=1&amp;format=png" alt="IPKC" width=113 height=148 border=0></a></div></td></tr></table>';
	
	hr();

	echo '<a name="property"></a>';
	$ships = file('http://mall.thebhg.org/ssl/person-summary.php?id=' . $pleb->GetID());
	$weapons = file('http://mall.thebhg.org/kiw/person-summary.php?id=' . $pleb->GetID());
	$kke = file('http://mall.thebhg.org/kke/person-summary.php?id=' . $pleb->GetID());
	$dsm = file('http://mall.thebhg.org/dsm/person-summary.php?id=' . $pleb->GetID());
	$rgt = file('http://mall.thebhg.org/rgt/person-summary.php?id=' . $pleb->GetID());
	$krf = file('http://mall.thebhg.org/krf/person-summary.php?id=' . $pleb->GetID());
	$table = new Table();
	$table->StartRow();
	$table->AddHeader('Personal Property', 2);
	$table->EndRow();
	$table->AddRow('SSL Ships:', $ships[0]);
	$table->AddRow('KIW Weapons:', $weapons[0]);
	$table->AddRow('KKE Items:', $kke[0]);
	$table->AddRow('DSM Armour:', $dsm[0]);
	$table->AddRow('RGT Vehicles:', $rgt[0]);
	$table->AddRow('KRF Droids:', $krf[0]);
	$table->StartRow();
	$table->AddCell('<a href="' . internal_link('hunter_property', array('id'=>$pleb->GetID())) . '">Get More Information</a>', 2);
	$table->EndRow();
	$table->EndTable();

	hr();
	echo '<table border=0 width="100%"><tr valign="top"><td>';

	echo '<a name="history"></a>';
	$table = new Table();
	$table->StartRow();
	$table->AddHeader('Recent History', 2);
	$table->EndRow();
	$history = new PersonHistory($pleb->GetID());
	$history->Load(0, 0, array(1, 2, 3, 4, 5, 9), 'DESC');
	if ($history->Count()) {
		$row = 0;
		do {
			$item = $history->GetItem();
			$table->AddRow(date('j F Y', $item->GetDate()), html_escape($item->GetReadable(false)));
		} while ($history->Next() && $row++ < 5);
	}
	$table->StartRow();
	$table->AddCell('<a href="' . internal_link('hunter_history', array('id'=>$pleb->GetID())) . '">Show Full History</a>', 2);
	$table->EndRow();
	$table->EndTable();

	echo '</td><td><div style="text-align: right"><a href="roster/graphs/credit_history.php?id=' . $pleb->GetID() . '"><img src="roster/graphs/tn_credit_history.php?id=' . $pleb->GetID() . '" alt="Credit History" title="Credit History" width=120 height=90 border=0></a></div></td></tr></table>';
	hr();

	echo '<a name="medals"></a>';
	$table = new Table();
	$table->StartRow();
	$table->AddHeader('Recent Medals', 2);
	$table->EndRow();
	$medals = $pleb->GetMedals();
	if ($medals && count($medals)) {
		$row = 0;
		usort($medals, 'recent_medals');
		foreach ($medals as $am) {
			if (++$row > 5) {
				break;
			}
			$medal = $am->GetMedal();
			$group = $medal->GetGroup();
			$awarder = $am->GetAwarder();
			$table->AddRow(date('j F Y', $am->GetDate()), '<a href="' . internal_link('browse', array('group'=>$group->GetID()), 'mb') . '">' . html_escape($medal->GetName()) . '</a>' . ($am->GetReason() ? ' for ' . html_escape($am->GetReason()) : '') . '.');
		}
		if ($row == 6) {
			$table->StartRow();
			$table->AddCell('<a href="' . internal_link('hunter_medals', array('id'=>$pleb->GetID())) . '">Show All Medals</a>', 2);
			$table->EndRow();
		}
	}
	else {
		$table->StartRow();
		$table->AddCell('No medals have been awarded to this hunter.', 2);
		$table->EndRow();
	}
	$table->EndTable();

	hr();

	echo '<a name="courses"></a>';
	$results = $citadel->GetPersonsResults($pleb, CITADEL_PASSED);
	$table = new Table();
	$table->StartRow();
	$table->AddHeader('Recent Courses', 2);
	$table->EndRow();
	if (is_array($results)) {
		usort($results, 'citadel_recent_sort');
		foreach (array_slice($results, 0, 5) as $cex) {
			$exam = $cex->GetExam();
			$table->AddRow(date('j F Y', $cex->GetDateTaken()), 'Passed ' . html_escape($exam->GetName()) . ' exam with a score of ' . number_format($cex->GetScore(), 0) . '%.');
		}
		if (count($results) > 5) {
			$table->StartRow();
			$table->AddCell('<a href="' . internal_link('hunter_courses', array('id'=>$pleb->GetID())) . '">Show All Courses</a>', 2);
			$table->EndRow();
		}
	}
	else {
		$table->StartRow();
		$table->AddCell('This hunter has not passed any courses yet.', 2);
		$table->EndRow();
	}
	$table->EndTable();

	if (count($reports)) {
		hr();

		echo '<a name="reports"></a>';
		$table = new Table();
		$table->StartRow();
		$table->AddHeader('Recent Reports', 2);
		$table->EndRow();
		$table->StartRow();
		$table->AddHeader('Date');
		$table->AddHeader('Position');
		$table->EndRow();
		
		foreach (array_slice($reports, 0, 5) as $report) {
			$pos = $roster->GetPosition($report['position']);
			$pos_text = '<a href="' . internal_link('position', array('id'=>$pos->GetID())) . '">' . $pos->GetName() . '</a>';
			if ($report['position'] >= 10) {
				$div = $roster->GetDivision($report['division']);
				$pos_text = '<a href="' . internal_link('division', array('id'=>$div->GetID())) . '">' . $div->GetName() . '</a> ' . $pos_text;
			}
			$table->AddRow('<a href="' . internal_link('report', array('id'=>$report['id'])) . '">' . date('j F Y', $report['time']) . '</a>', $pos_text);
		}

		if (count($reports) > 5) {
			$table->StartRow();
			$table->AddCell('<a href="' . internal_link('hunter_reports', array('id'=>$pleb->GetID())) . '">Show All Reports</a>', 2);
			$table->EndRow();
		}

		$table->EndTable();
	}

	// Add any further items that need to be on the menu.
	$links['sep1'] = '';

	$links[internal_link('hunter_courses', array('id'=>$pleb->GetID()))] = 'View All Courses';
	$links[internal_link('hunter_medals', array('id'=>$pleb->GetID()))] = 'View All Medals';
	$links[internal_link('hunter_property', array('id'=>$pleb->GetID()))] = 'View All Property';
	if (count($reports)) {
		$links[internal_link('hunter_reports', array('id'=>$pleb->GetID()))] = 'View All Reports';
	}
	$links[internal_link('hunter_history', array('id'=>$pleb->GetID()))] = 'View Full History';
	
	$links['sep2'] = '';
	
/*	if (isset($calypso)) {
		if ($calypso->AccountExists($pleb->GetID())) {
			$blog = new Blog($pleb->GetID());
			$links['http://blogs.thebhg.org/' . $blog->GetLinkTitle() . '/'] = 'View Blog';
		}
	}*/

/*	$sheet = new Sheet($pleb);
	if ($sheet->GetLastUpdate() > 0 && $sheet->GetStatus() != 'new' && $sheet->fields[56]->GetRealValue() > 0) {
		$links[internal_link('character_sheet', array('id'=>$pleb->GetID()))] = 'View Old Character Sheet';
	}*/
	$links[internal_link('atn_general', array('id'=>$pleb->GetID()), 'arena')] = 'View Role Playing Info';
	
	$links['http://tactician.thebhg.org/cg/stats/hunter.php?id=' . $pleb->GetID()] = 'View CG Statistics';
	$links['http://tactician.thebhg.org/kag/stats/hunter.php?id=' . $pleb->GetID()] = 'View KAG Statistics';

	roster_footer(true, $links);
}
?>
