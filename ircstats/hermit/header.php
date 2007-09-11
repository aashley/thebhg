<?php ob_start('ob_gzhandler'); ?>
<HTML>
<HEAD>
<BASE TARGET="main">
<TITLE>IRC Stats<?php if ($title) echo " :: $title"; ?></TITLE>
<STYLE TYPE="text/css">
<!--
BODY, TD {
	font-family: Trebuchet MS, Verdana, Arial, Helvetica, Sans-Serif;
	font-size: 10pt;
	color: white;
}
BODY {
	background: <?php if ($menu) echo '#202020 url("images/menu-bg.gif") no-repeat fixed 100% 90%'; else echo 'black url("images/main-bg.gif") no-repeat fixed 0% 90%'; ?>;
}
TD {
	background: black;
}
INPUT, SELECT {
	font-family: Trebuchet MS, Verdana, Arial, Helvetica, Sans-Serif;
	font-size: 10pt;
}
H1 {
	font-size: 14pt;
	font-weight: bold;
}
A {
	color: yellow;
	text-decoration: none;
}
A:HOVER {
	text-decoration: underline;
}
TH {
	font-size: 10pt;
	font-weight: normal;
	background: #202020;
}
TABLE {
	background: #202020;
	border: 0;
}
SPAN.DATE {
	color: #00ffff;
}
SPAN.NICK {
	color: #7fff7f;
}
SPAN.TS {
	color: #ff7f7f;
}
SPAN.REVERSE {
	background: white;
	color: black;
}
TD.ODD {
	background: #202020;
}
-->
</STYLE>
</HEAD>
<BODY>
<?php if (empty($menu)) { ?>
<H1>IRC Stats<?php if ($title) echo " :: $title"; ?></H1>
<BR>
<?php
}
$db = mysql_connect('localhost', 'thebhg', '1IHfHTsAmILMwpP');
mysql_select_db('ircstats', $db);

ini_set('include_path', ini_get('include_path') . ':/var/www/html/include');
include_once('roster.inc');
$roster = new Roster('!id-this-666');

if ($admin) {
	if (empty($_SERVER['PHP_AUTH_USER'])) forbidden();

	$login = new Login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
	if (!$login->IsValid()) forbidden();
	else {
		$div = $login->GetDivision();
		$pos = $login->GetPosition();
		if ($jer_only) {
			if ($login->GetID() != 666 && $login->GetID() != 94 && $pos->GetID() != 2 && $pos->GetID() != 4) {
				echo 'You are not authorised to play with this.';
				exit;
			}
		}
		else {
			if ($div->GetID() != 10 && $div->GetID() != 9 && $login->GetID() != 666 && $login->GetID() != 11) {
				echo 'You are not authorised to play with this.';
				exit;
			}
		}
	}
}

function calculate_credits($words) {
	return ($words * (7 + 1/7));
}

function date_field($prefix, $show_time = false, $end_time = false) {
	echo "<INPUT TYPE=\"text\" NAME=\"{$prefix}_day\" SIZE=3 VALUE=\"" . date('j') . '" onFocus="if (this.value == \'' . date('j') . '\') this.value = \'\'" onBlur="if (this.value == \'\') this.value = \'' . date('j') . "'\">&nbsp;<SELECT NAME=\"{$prefix}_month\">";
	for ($i = 1; $i <= 12; $i++) {
		echo "<OPTION VALUE=\"$i\"" . ($i == date('m') ? ' SELECTED' : '') . '>' . date('F', mktime(0, 0, 0, $i)) . '</OPTION>';
	}
	echo "</SELECT>&nbsp;<INPUT TYPE=\"text\" NAME=\"{$prefix}_year\" SIZE=5 VALUE=\"" . date('Y') . '" onFocus="if (this.value == \'' . date('Y') . '\') this.value = \'\'" onBlur="if (this.value == \'\') this.value = \'' . date('Y') . "'\">";
	if ($show_time) {
		if ($end_time) {
			$hr = '23';
			$min = '59';
		}
		else {
			$hr = '0';
			$min = '00';
		}
		echo " at <input type=\"text\" name=\"{$prefix}_hour\" value=\"$hr\" size=3 onFocus=\"if (this.value == '$hr') this.value = ''\" onBlur=\"if (this.value == '') this.value = '$hr'\">:<input type=\"text\" name=\"{$prefix}_minute\" value=\"$min\" size=3 onFocus=\"if (this.value == '$min') this.value = ''\" onBlur=\"if (this.value == '') this.value = '$min'\">";
	}
}

function ymd2ts($day, $month, $year, $hour = 0, $minute = 0) {
	return mktime($hour, $minute, 0, $month, $day, $year);
}

function forbidden() {
	header('WWW-Authenticate: Basic Realm="IRC Stats"');
	header('HTTP/1.1 401 Forbidden');
	echo 'You are not authorised to access this page.';
	include('footer.php');
}

function auto_link($text) {
	$text = htmlentities($text);

	$open = false;
	while (strstr($text, "\002")) {
		if (!$open) $text = preg_replace("/\002/", '<b>', $text, 1);
		else $text = preg_replace("/\002/", '</b>', $text, 1);
		$open = !$open;
	}
	if ($open) $text .= '</b>';

	$text = preg_replace("/\003[0-9,]*?/", '', $text, 1);

	$open = false;
	while (strstr($text, "\x1f")) {
		if (!$open) $text = preg_replace("/\x1f/", '<u>', $text, 1);
		else $text = preg_replace("/\x1f/", '</u>', $text, 1);
		$open = !$open;
	}
	if ($open) $text .= '</u>';

	$open = false;
	while (strstr($text, "\x16")) {
		if (!$open) $text = preg_replace("/\x16/", '<span class="REVERSE">', $text, 1);
		else $text = preg_replace("/\x16/", '</span>', $text, 1);
		$open = !$open;
	}
	if ($open) $text .= '</span>';

	return preg_replace('"(http://[^[:space:]]*)"', '<A HREF="\\1" TARGET="_top">\\1</A>', $text);
}

function highlight_line($line) {
	$words = explode(' ', $line);
	if ($line{0} == '[') {
		echo '<span class="TS">' . htmlentities($words[0]) . '</span> ';
	}
	else {
		for ($i = count($words); $i > 0; $i--) {
			$words[$i] = $words[$i - 1];
		}
	}
	if ($words[1] == 'Action:') {
		echo htmlentities($words[1]) . ' <span class="NICK">' . htmlentities($words[2]) . '</span> ';
		echo auto_link(implode(' ', array_slice($words, 3)));
	}
	elseif ($words[1]{0} == '#' || $words[1] == 'Topic') {
		echo auto_link(implode(' ', array_slice($words, 1)));
	}
	elseif ($words[1] == 'Nick') {
		echo 'Nick change: <span class="NICK">' . htmlentities($words[3]) . '</span> -&gt; <span class="NICK">' . htmlentities($words[5]) . '</span>';
	}
	elseif ($words[1]{0} == '<') {
		echo '&lt;<span class="NICK">' . htmlentities(str_replace(array('<', '>'), '', $words[1])) . '</span>&gt; ';
		echo auto_link(implode(' ', array_slice($words, 2)));
	}
	else {
		echo '<span class="NICK">' . htmlentities($words[1]) . '</span> ';
		echo auto_link(implode(' ', array_slice($words, 2)));
	}
}
?>
