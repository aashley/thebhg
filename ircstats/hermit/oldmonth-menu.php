<?php
$menu = true;
$title = 'Old Months';
include('header.php');

echo '<b>Previous Months</b><br>';

$dir = opendir('/home/anya/public_html');
if ($dir) {
	$row = 0;
	while ($file = readdir($dir)) {
		if (substr($file, 0, 5) == 'pisg-' && substr($file, -4) == '.php') {
			$date = mktime(0, 0, 0, substr($file, 9, 2), 1, substr($file, 5, 4));
			$files[$date] = "<A HREF=\"../pisg-" . substr($file, 5, 6) . ".php\">" . date('F Y', $date) . '</A><BR>';
		}
	}
}
closedir($dir);
?>
<script language="JavaScript">
<!--
function toggleElement(id) {
	block = document.getElementById(id);
	menu = document.getElementById(id + "-menu");
	if (block.style.display == 'block') {
		block.style.display = 'none';
		menu.style.display = 'block';
	}
	else {
		block.style.display = 'block';
		menu.style.display = 'none';
	}
}

<?php
ksort($files);
foreach ($files as $date=>$link) {
	$month_number = date('Y', $date);
	$months[$month_number] .= $link;
}
krsort($months);
$first = true;
foreach ($months as $month_number=>$links) {
	$mdate = mktime(0, 0, 0, 1, 1, $month_number);
	echo 'document.writeln("<DIV ID=\"' . $month_number . '-menu\" STYLE=\"display: block\"><B><A HREF=\"#\" onClick=\"toggleElement(\'' . $month_number . '\'); return false;\">Year ' . $month_number . '</A></B><BR></DIV>");';
	echo 'document.writeln("<DIV ID=\"' . $month_number . '\" STYLE=\"display: none\"><BR><B><A HREF=\"#\" onClick=\"toggleElement(\'' . $month_number . '\'); return false;\">Year ' . $month_number . '</A></B><BR>' . str_replace('"', '\"', $links) . '<BR></DIV>");';
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
