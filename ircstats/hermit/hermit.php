<?php
set_time_limit(0);
$timers['Overall'][0] = time();

$db = mysql_connect('localhost', 'thebhg_lawngnome', 'thej3rchr0nicles');
mysql_select_db('thebhg_lawngnome', $db);

header('Content-Type: text/plain');

ini_set('include_path', ini_get('include_path') . ':/var/www/html/include');
include('roster.inc');
$roster = new Roster();

class pleb {
	var $id;
	var $nicks;
	var $words;
	var $online;
}

function find_nick($plebs, $nick) {
	$nick = trim($nick);
	foreach ($plebs as $key=>$pleb) {
		if (in_array($nick, $pleb->nicks) && $pleb->online == true) return $key;
	}
	return -1;
}

$timers['File load'][0] = time();
$lines = file($file);
$timers['File load'][1] = time();
$plebs = array();

$timers['Analysis'][0] = time();

echo 'Starting analysis';
foreach ($lines as $key=>$line) {
	unset($nick);
//	echo $line;
	if (($key % 500) == 0) {
		echo '.';
		if (connection_aborted()) exit;
	}
	$line = preg_replace('/^\[..:..\] /', '', $line);
	$line = str_replace(array("\r", "\r\n", "\n"), '', $line);
	if ($line{0} == '<') {
		$words = explode(' ', $line);
		$nick = str_replace(array('<', '>'), '', $words[0]);
		if (($key = find_nick($plebs, $nick)) != -1) $plebs[$key]->words += (count($words) - 1);
		else {
//			echo "Creating new pleb: $nick\n";
			$pleb = new pleb();
			$pleb->nicks = array($nick);
			$poss = $roster->SearchIRCNick($nick, true);
			if ($poss && count($poss) == 1) $pleb->id = $poss[0]->GetID();
			else {
				$poss = $roster->SearchIRCNick($nick, false);
				if ($poss && count($poss) == 1) $pleb->id = $poss[0]->GetID();
				else $pleb->id = 0;
			}
			$pleb->online = true;
			$pleb->words = count($words) - 1;
			$plebs[] = $pleb;
		}
	}
	elseif (strstr($line, ') left irc:')) {
		$words = explode(' ', $line);
		$nick = $words[0];
//		echo "Left IRC: $nick\n";
		if (($key = find_nick($plebs, $nick)) != -1) {
//			echo "Found old nick\n";
			$plebs[$key]->online = false;
		}
	}
	elseif (strstr($line, 'Nick change: ')) {
		$words = explode(' ', $line);
		$old_nick = $words[2];
		$nick = $words[4];
//		echo "Nick change ($old_nick, $nick)\n";
		if (($key = find_nick($plebs, $old_nick)) != -1) {
//			echo "Found old nick\n";
			$plebs[$key]->nicks[] = $nick;
		}
		else {
//			echo "Creating new pleb: $nick\n";
			$pleb = new pleb();
			$pleb->nicks = array($nick);
			$poss = $roster->SearchIRCNick($nick, true);
			if ($poss && count($poss) == 1) $pleb->id = $poss[0]->GetID();
			else {
				$poss = $roster->SearchIRCNick($nick, false);
				if ($poss && count($poss) == 1) $pleb->id = $poss[0]->GetID();
				else $pleb->id = 0;
			}
			$pleb->online = true;
			$pleb->words = 0;
			$plebs[] = $pleb;
		}
	}
}
$timers['Analysis'][1] = time();

//echo "\n";
$timers['Nick search'][0] = time();
$totals = array();
for ($i = 0; $i < count($plebs); $i++) {
	if ($plebs[$i]->id == 0) {
		foreach ($plebs[$i]->nicks as $nick) {
			$result = mysql_query("SELECT * FROM nicks WHERE nick='$nick'", $db);
			if ($result) {
				if (mysql_num_rows($result) == 1 && $plebs[$i]->id == 0) $plebs[$i]->id = mysql_result($result, 0, 'person');
				elseif (mysql_num_rows($result) == 0 && $plebs[$i]->id) mysql_query('INSERT INTO nicks (person, nick) VALUES (' . $plebs[$i]->id . ', "' . mysql_escape_string($nick) . '")', $db);
			}
			else {
				$result = mysql_query("SELECT * FROM nicks WHERE nick LIKE '%$nick%'", $db);
				if ($result) {
					if (mysql_num_rows($result) == 1 && $plebs[$i]->id == 0) $plebs[$i]->id = mysql_result($result, 0, 'person');
					elseif (mysql_num_rows($result) == 0 && $plebs[$i]->id) mysql_query('INSERT INTO nicks (person, nick) VALUES (' . $plebs[$i]->id . ', "' . mysql_escape_string($nick) . '")', $db);
				}
			}
		}
	}
//	echo $plebs[$i]->id;
	$totals[$plebs[$i]->id] += $plebs[$i]->words;
	if ($plebs[$i]->id) {
		$bhg_pleb = $roster->GetPerson($plebs[$i]->id);
//		echo ' (' . $bhg_pleb->GetName() . ')';
	}
//	echo ' [' . implode(', ', $plebs[$i]->nicks) . ']';
//	echo ' [' . print_r($plebs[$i]->nicks) . ']';
//	echo ' (Online: ' . ($plebs[$i]->online ? 'yes' : 'no') . ')';
//	echo ' ' . $plebs[$i]->words . " words\n";
}

ksort($totals);
$timers['Nick search'][1] = time();
echo <<<EOH

FINAL TABLE

Roster ID   Name                                                         Words
---------   ----                                                         -----

EOH;
foreach ($totals as $id=>$words) {
	if ($id) {
		$pleb = $roster->GetPerson($id);
		$name = $pleb->GetName();
		if ($input) {
			mysql_query("INSERT INTO irc_stats (person, date, words) VALUES ($id, $date, $words)", $db);
		}
	}
	else {
		$name = 'Unknown';
	}
	printf("%9u   %-55s %10u\n", $id, $name, $words);
}
$timers['Overall'][1] = time();

echo <<<EOH

TIMERS

Timer               Time
-----               ----

EOH;
foreach ($timers as $name=>$timer) {
	printf("%-16s %6u%s\n", $name, $timer[1] - $timer[0], 's');
}
?>
