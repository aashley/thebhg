<?php
$title = 'Overall Stats';
include('header.php');

if (empty($_POST['start_day'])) {
	echo <<<EOF
<FORM NAME="overall" ACTION="$PHP_SELF" METHOD="post">
<TABLE CELLSPACING=1 CELLPADDING=1>
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
<TR><TH>Interval:</TH><TD>
<SELECT NAME="interval">
<OPTION VALUE="1">Daily</OPTION>
<OPTION VALUE="7">Weekly</OPTION>
<OPTION VALUE="14">Fortnightly</OPTION>
</SELECT>
</TD></TR>
<TR><TD COLSPAN=2><DIV ALIGN="right"><INPUT TYPE="submit" VALUE="Go!"></DIV></TD></TR>
</TABLE>
</FORM>
EOF;
}
else {
	import_request_variables('p');
	
	echo '<A HREF="#graph">Jump to the graph</A>';
	echo '<TABLE CELLSPACING=1 CELLPADDING=2><TR><TH>Date</TH><TH>Words</TH></TR>';
	$start_ts = ymd2ts($start_day, $start_month, $start_year);
	$end_ts = ymd2ts($end_day, $end_month, $end_year);
	$int = $interval * 86400;
	$words = array();
	for ($i = $start_ts; $i <= $end_ts; $i += $int) {
		$start_int = $i;
		$end_int = ($i + $int - 1);
		$result = mysql_query("SELECT SUM(words) AS words FROM irc_stats WHERE date BETWEEN $start_int AND $end_int", $db);
		if ($result && mysql_num_rows($result)) {
			$day_words = mysql_result($result, 0, 'words');
			$words[date('Y-m-d', $i)] = $day_words;
			echo '<TR><TD>' . date('j M Y', $i) . '</TD><TD><DIV ALIGN="right">' . ($day_words ? number_format($day_words) : '0') . '</DIV></TD></TR>';
		}
	}
	echo '<TR><TH>Total</TH><TH><DIV ALIGN="right">' . number_format(array_sum($words)) . '</DIV></TH></TR>';
	echo '</TABLE>';
	echo '<BR><A NAME="graph"></A><IMG SRC="overall-chart.php?start=' . urlencode($start_ts) . '&amp;end=' . urlencode($end_ts) . '&amp;interval=' . $interval . '">';
}

include('footer.php');
?>
