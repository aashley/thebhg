<?php
ini_set('include_path', ini_get('include_path') . ':/var/www/html/include');
include_once('roster.inc');
$roster = new Roster();

if (empty($_POST['id'])) {
	$title = 'Person-Specific Stats';
	include('header.php');

	echo <<<EOF
<FORM NAME="person" ACTION="$PHP_SELF" METHOD="post">
<TABLE CELLSPACING=1 CELLPADDING=1>
<TR><TH>Person:</TH><TD><SELECT NAME="id">
EOF;
	$divisions = $roster->GetDivisions();
	foreach ($divisions as $div) {
		if ($div->GetID() == 0 || $div->GetID() == 16) continue;
		$plebs = $div->GetMembers();
		foreach ($plebs as $pleb) {
			$divs[$div->GetName()][$pleb->GetName()] = '<OPTION VALUE="' . $pleb->GetID() . '">' . $div->GetName() . ': ' . $pleb->GetName() . '</OPTION>';
		}
	}
	ksort($divs);
	foreach ($divs as $div) {
		ksort($div);
		echo implode("\n", $div);
	}
	echo <<<EOF
</SELECT></TD></TR>
<TR><TH>Start Date:</TH><TD>
EOF;
	date_field('start');
	echo <<<EOF
</TD></TR>
<TR><TH>End Date:</TH><TD>
EOF;
	date_field('end');
	echo <<<EOF
</TD></TR>
<TR><TD COLSPAN=2><DIV ALIGN="right"><INPUT TYPE="submit" VALUE="Go!"></DIV></TD></TR>
</TABLE>
</FORM>
EOF;
}
else {
	import_request_variables('p');
	
	$pleb = $roster->GetPerson($id);
	$title = 'Person-Specific Stats :: ' . $pleb->GetName();
	include('header.php');
	
	echo '<A HREF="#graph">Jump to the graph</A>';
	echo '<TABLE CELLSPACING=1 CELLPADDING=2><TR><TH>Date</TH><TH>Words</TH><TH>Credits</TH></TR>';
	$start_ts = ymd2ts($start_day, $start_month, $start_year);
	$end_ts = ymd2ts($end_day, $end_month, $end_year);
	$words = array();
	for ($i = $start_ts; $i <= $end_ts; $i += 86400) {
		$result = mysql_query("SELECT SUM(words) AS words FROM irc_stats WHERE person=$id AND date BETWEEN UNIX_TIMESTAMP(\"" . date('Y-m-d', $i) . '") AND UNIX_TIMESTAMP("' . date('Y-m-d', $i) . '")+86399 AND words>0', $db);
		if ($result && mysql_num_rows($result)) {
			$day_words = mysql_result($result, 0, 'words');
			$words[date('Y-m-d', $i)] = $day_words;
			echo '<TR><TD>' . date('j M Y', $i) . '</TD><TD><DIV ALIGN="right">' . ($day_words ? number_format($day_words) : '0') . '</DIV></TD><TD><DIV ALIGN="right">' . number_format(calculate_credits($day_words)) . '</DIV></TD></TR>';
		}
		else $words[date('Y-m-d', $i)] = '0';
	}
	echo '<TR><TH>Total</TH><TH><DIV ALIGN="right">' . number_format(array_sum($words)) . '</DIV></TH><TH><DIV ALIGN="right">' . number_format(calculate_credits(array_sum($words))) . '</DIV></TH></TR>';
	echo '</TABLE>';
	echo '<BR><A NAME="graph"></A><IMG SRC="person-chart.php?start=' . urlencode($start_ts) . '&amp;end=' . urlencode($end_ts) . '&amp;id=' . $id . '">';
}

include('footer.php');
?>
