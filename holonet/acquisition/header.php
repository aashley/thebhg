<?php
include('cover.php');

$prefix = 'aq_';

function admin_header() {
	issue_header();
}

function admin_footer($user) {
	
	if (is_global_admin($user)) {
		addMenu('Issue Administration',
				array('View Next Issue' => internal_link('issue', array('year'=>date('Y'), 'week'=>date('W'))),
					'E-mail an Issue' => internal_link('admin_email_issue'),
					));
		
		addMenu('Column Administration',
				array('Add Column' => internal_link('admin_add_column'),
					'Edit Column' => internal_link('admin_edit_column'),
					));
	}

	$items = array('Add Article' => internal_link('admin_add_article'),
		'Edit Article' => internal_link('admin_edit_article'));
	if (is_global_admin($user)) {
		$items['Delete Article'] = internal_link('admin_delete_article');
	}
	addMenu('Article Administration', $items);

	if (is_global_admin($user)) {
		addMenu('FAQ Section Administration',
				array('Add FAQ Section' => internal_link('admin_add_faq_section'),
					'Edit FAQ Section' => internal_link('admin_edit_faq_section'),
					'Delete FAQ Section' => internal_link('admin_delete_faq_section'),
					));

		addMenu('FAQ Administration',
				array('Add FAQ' => internal_link('admin_add_faq'),
					'Edit FAQ' => internal_link('admin_edit_faq'),
					'Delete FAQ' => internal_link('admin_delete_faq'),
					));
	}

}

function issue_header() {
}

function issue_footer($year, $week, $title = '') {
	global $roster, $db;

/*	if ($title == '') {
		echo '<a href="' . internal_link('issue', array('year'=>$year, 'week'=>$week)) . '">' . 'Issue ' . $year . '-' . $week . '</a>';
	}
	else {
		echo $title;
	}*/

	$dates = get_dates($year, $week);

	// Commission reports.
	$com_posids = array(1, 2, 3, 4, 5, 6, 29, 7, 8, 9);
	$cn_result = mysql_query('SELECT COUNT(*) AS rows FROM hn_reports WHERE position IN (' . implode(', ', $com_posids) . ') AND time ' . $dates['between'], $roster->roster_db);
	if ($cn_result && mysql_result($cn_result, 0, 'rows')) {
		$items = array();
		foreach ($com_posids as $i) {
			$pos = $roster->GetPosition($i);
			$cc_result = mysql_query('SELECT id FROM hn_reports WHERE position=' . $i . ' AND time ' . $dates['between'] . ' ORDER BY time ASC', $roster->roster_db);
			if ($cc_result && mysql_num_rows($cc_result)) {
				for ($j = 1; $j <= mysql_num_rows($cc_result); $j++) {
					$row = mysql_fetch_array($cc_result);
					$url = internal_link('report', array('year'=>$year, 'week'=>$week, 'id'=>$row['id']));
					$text = $pos->GetName() . ' Report';
					if (mysql_num_rows($cc_result) > 1) {
						$text .= '&nbsp;#' . $j;
					}
					$items[$text] = $url;
				}
			}
		}
		addMenu('Commission Reports', $items);
	}

	// Kabal reports.
	$kn_result = mysql_query('SELECT COUNT(*) AS rows FROM hn_reports WHERE position=11 AND time ' . $dates['between'], $roster->roster_db);
	if ($kn_result && mysql_result($kn_result, 0, 'rows')) {
		$kabals = $roster->GetKabals();
		$items = array();
		foreach ($kabals as $kabal) {
			$kr_result = mysql_query('SELECT id FROM hn_reports WHERE position=11 AND division=' . $kabal->GetID() . ' AND time ' . $dates['between'] . ' ORDER BY time ASC', $roster->roster_db);
			if ($kr_result && mysql_num_rows($kr_result)) {
				for ($j = 1; $j <= mysql_num_rows($kr_result); $j++) {
					$row = mysql_fetch_array($kr_result);
					$url = internal_link('report', array('year'=>$year, 'week'=>$week, 'id'=>$row['id']));
					$text = $kabal->GetName() . ' Kabal Report';
					if (mysql_num_rows($kr_result) > 1) {
						$text .= '&nbsp;#' . $j;
					}
					$items[$text] = $url;
				}
			}
		}
		addMenu('Kabal Reports', $items);
	}
	
	// Citadel reports.
	$kr_result = mysql_query('SELECT id FROM hn_reports WHERE position=10 AND time ' . $dates['between'] . ' ORDER BY time ASC', $roster->roster_db);
	if ($kr_result && mysql_num_rows($kr_result)) {
		$pos = $roster->GetPosition(10);
		$items = array();
		for ($j = 1; $j <= mysql_num_rows($kr_result); $j++) {
			$row = mysql_fetch_array($kr_result);
			$url = internal_link('report', array('year'=>$year, 'week'=>$week, 'id'=>$row['id']));
			$text = $pos->GetName() . ' Report';
			if (mysql_num_rows($kr_result) > 1) {
				$text .= '&nbsp;#' . $j;
			}
			$items[$text] = $url;
		}
		addMenu('Citadel Reports', $items);
	}

	// One-off articles.
	$art_result = mysql_query('SELECT id, title FROM aq_articles WHERE time ' . $dates['between'] . ' AND `column`=0 ORDER BY title ASC', $db);
	if ($art_result && mysql_num_rows($art_result)) {
		$items = array();
		while ($art_row = mysql_fetch_array($art_result)) {
			$items[html_escape(stripslashes($art_row['title']))] = internal_link('article', array('year'=>$year, 'week'=>$week, 'id'=>$art_row['id']));
		}
		addMenu('Articles', $items);
	}

	// Regular columns.
	$art_result = mysql_query('SELECT aq_articles.id, aq_columns.name AS title FROM aq_articles, aq_columns WHERE aq_articles.time ' . $dates['between'] . ' AND aq_columns.id!=0 AND aq_articles.`column`=aq_columns.id ORDER BY aq_columns.title ASC', $db);
	if ($art_result && mysql_num_rows($art_result)) {
		while ($art_row = mysql_fetch_array($art_result)) {
			$items[html_escape(stripslashes($art_row['title']))] = internal_link('article', array('year'=>$year, 'week'=>$week, 'id'=>$art_row['id']));
		}
		addMenu('Columns', $items);
	}

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
