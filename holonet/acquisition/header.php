<?php
include('cover.php');

$prefix = 'aq_';

function admin_header() {
	issue_header();
}

function admin_footer($user) {
	echo '</td><td style="border-left: solid 1px black">Administration&nbsp;Menu<small>';
	
	if (is_global_admin($user)) {
		echo '<br><br><b>Issue&nbsp;Administration</b><br>';
		echo '<br><a href="' . internal_link('issue', array('year'=>date('Y'), 'week'=>date('W'))) . '">View&nbsp;Next&nbsp;Issue</a>';
		echo '<br><a href="' . internal_link('admin_email_issue') . '">E-mail&nbsp;an&nbsp;Issue</a>';
		
		echo '<br><br><b>Column&nbsp;Administration</b><br>';
		echo '<br><a href="' . internal_link('admin_add_column') . '">Add&nbsp;Column</a>';
		echo '<br><a href="' . internal_link('admin_edit_column') . '">Edit&nbsp;Column</a>';
	}

	echo '<br><br><b>Article&nbsp;Administration</b><br>';
	echo '<br><a href="' . internal_link('admin_add_article') . '">Add&nbsp;Article</a>';
	echo '<br><a href="' . internal_link('admin_edit_article') . '">Edit&nbsp;Article</a>';
	if (is_global_admin($user)) {
		echo '<br><a href="' . internal_link('admin_delete_article') . '">Delete&nbsp;Article</a>';
	}

	if (is_global_admin($user)) {
		echo '<br><br><b>FAQ&nbsp;Section&nbsp;Administration</b><br>';
		echo '<br><a href="' . internal_link('admin_add_faq_section') . '">Add&nbsp;FAQ&nbsp;Section</a>';
		echo '<br><a href="' . internal_link('admin_edit_faq_section') . '">Edit&nbsp;FAQ&nbsp;Section</a>';
		echo '<br><a href="' . internal_link('admin_delete_faq_section') . '">Delete&nbsp;FAQ&nbsp;Section</a>';

		echo '<br><br><b>FAQ&nbsp;Administration</b><br>';
		echo '<br><a href="' . internal_link('admin_add_faq') . '">Add&nbsp;FAQ</a>';
		echo '<br><a href="' . internal_link('admin_edit_faq') . '">Edit&nbsp;FAQ</a>';
		echo '<br><a href="' . internal_link('admin_delete_faq') . '">Delete&nbsp;FAQ</a>';
	}

	echo '</small></td></tr></table>';
}

function issue_header() {
	echo '<table border=0 width="100%"><tr valign="top"><td width="90%">';
}

function issue_footer($year, $week, $title = '') {
	global $roster, $db;

	echo '</td><td style="border-left: solid 1px black">';
	if ($title == '') {
		echo str_replace(' ', '&nbsp;', 'Issue ' . $year . '-' . $week);
	}
	else {
		echo str_replace(' ', '&nbsp;', $title);
	}
	echo '<small>';

	$dates = get_dates($year, $week);

	// Commission reports.
	echo '<br><br><b>Commission Reports</b><br>';
	for ($i = 1; $i <= 9; $i++) {
		$pos = $roster->GetPosition($i);
		$cc_result = mysql_query('SELECT id FROM hn_reports WHERE position=' . $i . ' AND time ' . $dates['between'] . ' ORDER BY time ASC', $roster->roster_db);
		if ($cc_result && mysql_num_rows($cc_result)) {
			for ($j = 1; $j <= mysql_num_rows($cc_result); $j++) {
				$row = mysql_fetch_array($cc_result);
				echo '<br><a href="' . internal_link('report', array('year'=>$year, 'week'=>$week, 'id'=>$row['id'])) . '">' . str_replace(' ', '&nbsp;', $pos->GetName() . ' Report');
				if (mysql_num_rows($cc_result) > 1) {
					echo '&nbsp;#' . $j;
				}
				echo '</a>';
			}
		}
	}

	// Kabal reports.
	echo '<br><br><b>Kabal Reports</b><br>';
	$kabals = $roster->GetKabals();
	foreach ($kabals as $kabal) {
		$kr_result = mysql_query('SELECT id FROM hn_reports WHERE position=11 AND division=' . $kabal->GetID() . ' AND time ' . $dates['between'] . ' ORDER BY time ASC', $roster->roster_db);
		if ($kr_result && mysql_num_rows($kr_result)) {
			for ($j = 1; $j <= mysql_num_rows($kr_result); $j++) {
				$row = mysql_fetch_array($kr_result);
				echo '<br><a href="' . internal_link('report', array('year'=>$year, 'week'=>$week, 'id'=>$row['id'])) . '">' . str_replace(' ', '&nbsp;', $kabal->GetName() . ' Kabal Report');
				if (mysql_num_rows($kr_result) > 1) {
					echo '&nbsp;#' . $j;
				}
				echo '</a>';
			}
		}
	}
	
	// Wing reports.
	echo '<br><br><b>Wing Reports</b><br>';
	$wings = $roster->GetWings();
	foreach ($wings as $wing) {
		$kr_result = mysql_query('SELECT id FROM hn_reports WHERE position=10 AND division=' . $wing->GetID() . ' AND time ' . $dates['between'] . ' ORDER BY time ASC', $roster->roster_db);
		if ($kr_result && mysql_num_rows($kr_result)) {
			for ($j = 1; $j <= mysql_num_rows($kr_result); $j++) {
				$row = mysql_fetch_array($kr_result);
				echo '<br><a href="' . internal_link('report', array('year'=>$year, 'week'=>$week, 'id'=>$row['id'])) . '">' . str_replace(' ', '&nbsp;', $wing->GetName() . ' Report');
				if (mysql_num_rows($kr_result) > 1) {
					echo '&nbsp;#' . $j;
				}
				echo '</a>';
			}
		}
	}

	// One-off articles.
	$art_result = mysql_query('SELECT id, title FROM aq_articles WHERE time ' . $dates['between'] . ' AND `column`=0 ORDER BY title ASC', $db);
	if ($art_result && mysql_num_rows($art_result)) {
		echo '<br><br><b>Articles</b><br>';
		while ($art_row = mysql_fetch_array($art_result)) {
			echo '<br><a href="' . internal_link('article', array('year'=>$year, 'week'=>$week, 'id'=>$art_row['id'])) . '">' . str_replace(' ', '&nbsp;', html_escape(stripslashes($art_row['title']))) . '</a>';
		}
	}

	// Regular columns.
	$art_result = mysql_query('SELECT aq_articles.id, aq_columns.name AS title FROM aq_articles, aq_columns WHERE aq_articles.time ' . $dates['between'] . ' AND aq_columns.id!=0 AND aq_articles.`column`=aq_columns.id ORDER BY aq_columns.title ASC', $db);
	if ($art_result && mysql_num_rows($art_result)) {
		echo '<br><br><b>Columns</b><br>';
		while ($art_row = mysql_fetch_array($art_result)) {
			echo '<br><a href="' . internal_link('article', array('year'=>$year, 'week'=>$week, 'id'=>$art_row['id'])) . '">' . str_replace(' ', '&nbsp;', html_escape(stripslashes($art_row['title']))) . '</a>';
		}
	}

	echo '</small></td></tr></table>';
}

function get_dates($year, $week) {
	$fdoy = mktime(0, 0, 0, 1, 1, $year);
	$fdoy_tm = getdate($fdoy);
	if ($fdoy_tm['wday'] == 1) {
		// The first day of the year is a Monday.
		$ret['start'] = $fdoy;
	}
	else {
		$ts = $fdoy;
		do {
			$ts -= 86400;
			$ts_tm = getdate($ts);
		} while ($ts_tm['wday'] != 1);
		$ret['start'] = $ts;
	}
	$ret['start'] += (604800 * ($week - 1));
	$ret['end'] = $ret['start'] + 604799;
	$ret['between'] = 'BETWEEN ' . $ret['start'] . ' AND ' . $ret['end'];
	return $ret;
}

function is_global_admin($user) {
	$pos = $user->GetPosition();
	return ($pos->GetID() == 5 || $user->GetID() == 666 || $user->GetID() == 94);
}

function get_columns($user) {
	global $db;

	if (!is_numeric($user)) {
		$user = $user->GetID();
	}
	$result = mysql_query('SELECT * FROM aq_columns WHERE author=' . $user . ' AND active=1 ORDER BY name ASC', $db);
	if ($result && mysql_num_rows($result)) {
		while ($row = mysql_fetch_array($result)) {
			$columns[$row['id']] = stripslashes($row['name']);
		}
		return $columns;
	}
	else {
		return false;
	}
}
?>
