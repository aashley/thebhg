<?php
$title = 'Meeting Menu';
$menu = true;
include('header.php');

echo "<B>Meetings</B><BR>";

$dir = opendir('/home/thebhg/domains/ircstats.thebhg.org/irc/meetings');
if ($dir) {
	$row = 0;
	while ($file = readdir($dir)) {
		if (substr($file, 0, 12) == 'meeting.log.') {
			$date = mktime(0, 0, 0, substr($file, -4, 2), substr($file, -2), substr($file, -8, 4));
			$files[$date] = "<A HREF=\"meeting.php?log=" . substr($file, -8) . "\">" . date('j M Y', $date) . '</A><BR>';
		}
	}
}
closedir($dir);
?>
<script language="JavaScript">
<!--
function toggleMonth(id) {
	block = document.getElementById(id);
	if (block.style.display == 'block') {
		block.style.display = 'none';
	}
	else {
		block.style.display = 'block';
	}
}

function toggleYear(id) {
	block = document.getElementById(id);
	if (block.style.display == "block") {
		block.style.display = "none";
	}
	else {
		block.style.display = "block";
	}
}

<?php
ksort($files);
foreach ($files as $date=>$link) {
	$year = date('Y', $date);
	$month = date('n', $date);
	$years[$year][$month] .= $link;
}
krsort($years);
$first = true;
foreach ($years as $year=>$months) {
	echo 'document.writeln("<B><A HREF=\"#\" onClick=\"toggleYear(\'' . $year . '\'); return false;\">' . $year . '</A></B><BR><DIV ID=\"' . $year . '\" STYLE=\"display: none; padding-left: 1em\">");';
	foreach ($months as $month=>$links) {
		$date = mktime(0, 0, 0, $month);
		echo 'document.writeln("<B><A HREF=\"#\" onClick=\"toggleMonth(\'' . $year . '-' . $month . '\'); return false;\">' . date('F', $date). '</A></B><BR>");';
		echo 'document.writeln("<DIV ID=\"' . $year . '-' . $month . '\" STYLE=\"display: none; padding-left: 1em\">' . str_replace('"', '\"', $links) . '</DIV>");';
	}
	echo 'document.writeln("</DIV>");';
}
?>
// -->
</script>
<noscript>
<?php
krsort($files);
echo implode("\n", $files);

echo "</NOSCRIPT><HR>\n<A HREF=\"menu.php\" TARGET=\"menu\">Back</A><BR>\n";

include('footer.php');
?>
