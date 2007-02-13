<?php
$title = '#bhg Log Search';
$admin = true;
include('header.php');

if (empty($_POST['start_day'])) {
?>
<H1>Search</H1><BR>
<FORM NAME="searchtime" METHOD="POST" ACTION="<?php echo $PHP_SELF; ?>">
<TABLE CELLSPACING=1 CELLPADDING=2>
<TR><TD>Start Time:</TD><TD><?php date_field('start', true); ?></TD></TR>
<TR><TD COLSPAN="2">&nbsp;</TD></TR>
<TR><TD>End Time:</TD><TD><?php date_field('end', true, true); ?></TD></TR>
<TR><TD COLSPAN="2">&nbsp;</TD></TR>
<TR><TD>Nick(s):</TD><TD><INPUT TYPE="text" NAME="nicks" SIZE="40"><BR><SMALL>Leave blank to search for all nicks, multiple nicks must be separated by spaces.</SMALL><BR><INPUT TYPE="checkbox" NAME="nick_regex" VALUE="on"> Enable regular expressions</TD></TR>
<TR><TD COLSPAN="2">&nbsp;</TD></TR>
<TR><TD>Text:</TD><TD><INPUT TYPE="text" NAME="text" SIZE="40"><BR><SMALL>Leave blank to search for all lines, otherwise enter some text to search for.</SMALL><BR><INPUT TYPE="checkbox" NAME="text_regex" VALUE="on"> Enable regular expressions</TD></TR>
<TR><TD COLSPAN="2">&nbsp;</TD></TR>
<TR><TD>Show Date:</TD><TD><INPUT TYPE="checkbox" NAME="show_date" VALUE="on" CHECKED><BR><SMALL>Puts the date of the line before the line itself.</SMALL></TD></TR>
<?php if ($div->GetID() == 10 || $login->GetID() == 666) { ?>
<TR><TD>Show ONOTICES:</TD><TD><INPUT TYPE="checkbox" NAME="onotice" VALUE="on"><BR><SMALL>Shows all ONOTICES made by ops.</SMALL></TD></TR>
<?php } ?>
<TR><TD COLSPAN="2"><DIV ALIGN="right"><INPUT TYPE="submit" VALUE="Search">&nbsp;&nbsp;<INPUT TYPE="reset"></TD></TR>
</TABLE>
</FORM>
<?php
}
else {
	import_request_variables('p');

	// Mangle the input into a nice, usable format.
	if ($div->GetID() != 10 && $login->GetID() != 666) {
		$onotice = false;
	}
	$start = ymd2ts($start_day, $start_month, $start_year, $start_hour, $start_minute);
	$end = ymd2ts($end_day, $end_month, $end_year, $end_hour, $end_minute);
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
	$odd = true;
	echo '<table cellspacing=0 cellpadding=2>';
	for ($i = $start; $i <= $end; $i += 86400) {
		// Load the file.
		$log = @file('/home/thebhg/domains/ircstats.thebhg.org/irc/bhg/bhg.log.' . date('Ymd', $i));
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
						if (preg_match('/^\[.....\] -/', $line) && !$onotice) {
							continue;
						}
						echo '<tr valign="top"><td';
						if ($odd) {
							$odd = false;
							echo ' class="ODD"';
						}
						else $odd = true;
						echo '><tt>';
						if (isset($show_date)) {
							echo '<span class="DATE">' . date('Y-m-d', $linetime) . '</span>: ';
						}
						highlight_line($line);
						echo '</tt></td></tr>';
					}
				}
			}
		}
	}
	echo "</table>\n";
}
?>
