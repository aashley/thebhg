<?php
function divider() {
	return "\n\n                                   * * *\n\n";
}

function title() {
	return 'Administration :: E-mail an Issue';
}

function auth($pleb) {
	global $user, $roster;

	$user = $roster->GetPerson($pleb->GetID());
	return is_global_admin($user);
}

function output() {
	global $user, $page, $db, $roster;

	admin_header();

	if (isset($_REQUEST['issue'])) {
		$issue_arr = explode('-', $_REQUEST['issue']);
		$year = $issue_arr[0];
		$week = $issue_arr[1];
		$dates = get_dates($year, $week);

		// Construct the subject.
		$subject = 'Acquisition Issue ' . $_REQUEST['issue'];

		// Work out the from address.
		$x = $roster->SearchPosition(5);
		if (count($x)) {
			$from = $x[0]->GetEmail();
		}
		else {
			$from = 'unanswered@thebhg.org';
		}
		
		// Construct the to addresses.
		$divs = $roster->GetDivisions();
		foreach ($divs as $div) {
			if (substr($div->GetMailingList(), 0, 4) != 'none' && strstr($div->GetMailingList(), '@')) {
				$lists[] = $div->GetMailingList();
			}
		}
		$lists = array_unique($lists);
		sort($lists);

		// Construct the e-mail itself.
		$body = '';
		
		$cover_result = mysql_query('SELECT * FROM aq_articles WHERE time ' . $dates['between'] . ' AND cover=1 ORDER BY title ASC', $db);
		if ($cover_result && mysql_num_rows($cover_result)) {
			while ($cover_row = mysql_fetch_array($cover_result)) {
				$body .= 'Title: ' . stripslashes($cover_row['title']) . "\n";
				
				$author = $roster->GetPerson($cover_row['author']);
				$body .= 'Author: ' . $author->GetName() . "\n\n";

				$body .= wordwrap(stripslashes($cover_row['content']), 72);
				$body .= divider();
			}
		}

		$com_posids = array(1, 2, 3, 4, 5, 6, 29, 7, 8, 9);
		foreach ($com_posids as $i) {
			$pos = $roster->GetPosition($i);
			$cc_result = mysql_query('SELECT * FROM hn_reports WHERE position=' . $i . ' AND time ' . $dates['between'] . ' ORDER BY time ASC', $roster->roster_db);
			if ($cc_result && mysql_num_rows($cc_result)) {
				for ($j = 1; $j <= mysql_num_rows($cc_result); $j++) {
					$row = mysql_fetch_array($cc_result);
					$author = $roster->GetPerson($row['author']);
					$body .= $pos->GetName() . ' Report' . (mysql_num_rows($cc_result) > 1 ? ' #' . $j : '') . "\n";
					$body .= 'Author: ' . $author->GetName() . "\n";
					$body .= 'Date: ' . date('j F Y', $row['time']) . "\n\n";
					$body .= wordwrap(stripslashes($row['report']), 72);
					$body .= divider();
				}
			}
		}

		if (count($x)) {
			$pos = $x[0]->GetPosition();
			$rank = $x[0]->GetRank();
			$body .= $rank->GetName() . ' ' . $x[0]->GetName() . "\n" . $pos->GetName();
		}

		// Construct the e-mail headers.
		$headers = 'X-Sender: ' . $from . "\nReturn-Path: " . $from . "\nFrom: " . $from . "\nReply-To: " . $from . "\nX-Mailer: PHP/" . phpversion();
		
		// Send the e-mail.
		mail(implode(', ', $lists), $subject, $body, $headers);

		$table = new Table();
		$table->AddRow('To:', implode(', ', $lists));
		$table->AddRow('Subject:', $subject);
		$table->AddRow('Body:', '<pre>' . $body . '</pre>');
		$table->EndTable();

		echo 'E-mail sent.';
	}
	else {
		$cur_year = date('Y');
		$cur_week = date('W') - 1;
		if ($cur_week == 0) {
			$cur_year--;
			$cur_week = 52;
		}
		
		$form = new Form($page, 'get');
		$form->StartSelect('Issue:', 'issue', "$cur_year-$cur_week");
		$start = 1076860800;
		$current = get_dates(date('Y'), date('W'));
		for ($ts = $current['end'] + 1; $ts >= $start; $ts -= 604800) {
			$year = date('Y', $ts);
			$week = date('W', $ts) - 1;
			$issue = "$year-$week";
			$dates = get_dates($year, $week);
			$form->AddOption($issue, $issue . ' (' . date('j/n/Y', $dates['start']) . ' - ' . date('j/n/Y', $dates['end']) . ')');
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'E-mail Issue');
		$form->EndForm();
	}

	admin_footer($user);
}
?>
