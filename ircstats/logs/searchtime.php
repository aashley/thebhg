<?php include('auth.php'); ob_start('ob_gzhandler'); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html/loose.dtd">
<HTML>
<HEAD>
<BASE TARGET="main">
<STYLE TYPE="text/css">
<!--
BODY, PRE {
	background: white;
	color: black;
	font-family: Courier New, Courier, Monospace;
	font-size: 10pt;
}
TR {
	vertical-align: top;
}
SMALL {
	font-size: 8pt;
}
H1 {
	font-size: 16pt;
	font-weight: bold;
}
-->
</STYLE>
</HEAD>
<BODY>
<?php
if (empty($start)) {
?>
<H1>Search</H1><BR>
<FORM NAME="searchtime" METHOD="POST" ACTION="<?php echo $PHP_SELF; ?>">
<TABLE BORDER="0">
<TR><TD>Start Time:</TD><TD><INPUT TYPE="text" NAME="start" SIZE="25"></TD></TR>
<TR><TD COLSPAN="2">&nbsp;</TD></TR>
<TR><TD>End Time:</TD><TD><INPUT TYPE="text" NAME="end" SIZE="25"></TD></TR>
<TR><TD COLSPAN="2">&nbsp;</TD></TR>
<TR><TD>Nick(s):</TD><TD><INPUT TYPE="text" NAME="nicks" SIZE="40"><BR><SMALL>Leave blank to search for all nicks, multiple nicks must be separated by spaces.</SMALL><BR><INPUT TYPE="checkbox" NAME="nick_regex" VALUE="on"> Enable regular expressions</TD></TR>
<TR><TD COLSPAN="2">&nbsp;</TD></TR>
<TR><TD>Text:</TD><TD><INPUT TYPE="text" NAME="text" SIZE="40"><BR><SMALL>Leave blank to search for all lines, otherwise enter some text to search for.</SMALL><BR><INPUT TYPE="checkbox" NAME="text_regex" VALUE="on"> Enable regular expressions</TD></TR>
<TR><TD COLSPAN="2">&nbsp;</TD></TR>
<TR><TD>Show Date:</TD><TD><INPUT TYPE="checkbox" NAME="show_date" VALUE="on" CHECKED><BR><SMALL>Puts the date of the line before the line itself.</SMALL></TD></TR>
<TR><TD COLSPAN="2">&nbsp;</TD></TR>
<TR><TD COLSPAN="2"><DIV ALIGN="right"><INPUT TYPE="submit" VALUE="Search">&nbsp;&nbsp;<INPUT TYPE="reset"></TD></TR>
</TABLE>
</FORM>
<?php
}
else {
	echo "<PRE>\n";
	// Mangle the input into a nice, usable format.
	$start = strtotime($start);
	$end = strtotime($end);
	if (strlen($nicks)) {
		$nicks = explode(' ', $nicks);
		for ($i = 0; $i < count($nicks); $i++) {
			if (isset($nick_regex)) {
				$nicks[$i] = preg_quote('<') . $nicks[$i] . preg_quote('>');
			}
			else {
				$nicks[$i] = preg_quote('<' . $nicks[$i] . '>');
			}
		}
	}
	else {
		unset($nicks);
	}
	if (empty($text_regex)) {
		$text = preg_quote($text);
	}
	for ($i = $start; $i <= $end; $i += 86400) {
		// Load the file.
		$log = @file('/home/anya/eggdrop/logs/bhg/bhg.log.' . date('Ymd', $i));
		if (!$log) {
			continue;
		}
		foreach ($log as $line) {
			// Check the time.
			$today = getdate($i);
			$linetime = mktime(substr($line, 1, 2), substr($line, 4, 2), 0, $today['mon'], $today['mday'], $today['year']);
			if ($linetime >= $start && $linetime <= $end) {
				// Check the nick.
				if (empty($nicks) || preg_match('/(' . implode('|', $nicks) . ')/i', $line)) {
					// Check the text.
					if (strlen($text) == 0 || preg_match("/$text/i", $line)) {
						if (isset($show_date)) {
							echo date('Y-m-d', $linetime) . ': ';
						}
						echo htmlspecialchars($line);
					}
				}
			}
		}
	}
	echo "</PRE>\n";
}
?>
</BODY>
</HTML>
<?php
header('Content-Length: ' . ob_get_length());
ob_end_flush();
exit;
?>
