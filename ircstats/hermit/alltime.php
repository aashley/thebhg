<?php
$title = 'All-Time Stats';
include('header.php');

$result = mysql_query("SELECT person, SUM(words) AS words FROM irc_stats GROUP BY person ORDER BY words DESC LIMIT 100", $db);
if ($result && mysql_num_rows($result)) {
	echo '<TABLE CELLSPACING=1 CELLPADDING=2><TR><TH>&nbsp;</TH><TH>Name</TH><TH>Words</TH><TH>Credits</TH></TR>';
	$i = 0;
	while ($row = mysql_fetch_array($result)) {
		$pleb = $roster->GetPerson($row['person']);
		$day_words = $row['words'];
		echo '<TR><TD>' . (++$i) . '</TD><TD><A HREF="http://holonet.thebhg.org/index.php?module=roster&amp;page=hunter&amp;id=' . $row['person'] . '">' . $pleb->GetName() . '</A></TD><TD><DIV ALIGN="right">' . ($day_words ? number_format($day_words) : '0') . '</DIV></TD><TD><DIV ALIGN="right">' . number_format(calculate_credits($day_words)) . '</DIV></TD></TR>';
	}
	echo '</TABLE>';
}
else echo 'No matching records found.';

include('footer.php');
?>
