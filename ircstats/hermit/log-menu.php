<?php
$title = 'Administration Menu';
$menu = true;
$admin = true;
include('header.php');
?>
<b>Logs</b><br>
<a href="searchtime.php">Search</a><br>
<hr>
<?php
$dir = opendir('/home/anya/eggdrop/logs/bhg');
if ($dir) {
	while ($file = readdir($dir)) {
		if (substr($file, 0, 8) == 'bhg.log.') {
			$date = mktime(0, 0, 0, substr($file, -4, 2), substr($file, -2), substr($file, -8, 4));
			$files[$date] = "<A HREF=\"log.php?log=" . substr($file, -8) . "\">" . date('j M Y', $date) . '</A><BR>';
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
	$month_number = date('Y', $date) * 12 + (date('m', $date) - 1);
	$months[$month_number] .= $link;
}
krsort($months);
$first = true;
foreach ($months as $month_number=>$links) {
	$year = floor($month_number / 12);
	$month = ($month_number % 12) + 1;
	$mdate = mktime(0, 0, 0, $month, 1, $year);
	echo 'document.writeln("<DIV ID=\"' . $month_number . '-menu\" STYLE=\"display: block\"><B><A HREF=\"#\" onClick=\"toggleElement(\'' . $month_number . '\'); return false;\">' . date('M Y', $mdate) . '</A></B><BR></DIV>");';
	echo 'document.writeln("<DIV ID=\"' . $month_number . '\" STYLE=\"display: none\"><BR><B><A HREF=\"#\" onClick=\"toggleElement(\'' . $month_number . '\'); return false;\">' . date('M Y', $mdate) . '</A></B><BR>' . str_replace('"', '\"', $links) . '<BR></DIV>");';
}
?>
// -->
</script>
<noscript>
<?php
krsort($files);
echo implode('', $files);
echo '</noscript><hr><a href="menu.php" target="menu">Back</a><br>';
include('footer.php');
?>
