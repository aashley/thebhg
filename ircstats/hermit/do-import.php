<?php
include_once 'import-defs.php';

function import($file, $date) {
	global $roster, $db;
	$timers['Overall'][0] = time();

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
					else {
						$poss = $roster->SearchName($nick, false);
						if ($poss && count($poss) == 1) $pleb->id = $poss[0]->GetID();
						else {
							$result = mysql_query("SELECT person FROM nicks WHERE nick = '" . mysql_escape_string($nick) . "'", $db);
							if ($result && mysql_num_rows($result) > 0) $pleb->id = mysql_result($result, 0, 'person');
							else $pleb->id = 0;
						}
					}
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
		if ($plebs[$i]->id != 0) {
			foreach ($plebs[$i]->nicks as $nick) {
				mysql_query('REPLACE INTO nicks (person, nick) VALUES (' . $plebs[$i]->id . ", '" . mysql_escape_string($nick) . "')", $db);
			}
		}
	//	echo $plebs[$i]->id;
		if (!isset($totals[$plebs[$i]->id])) $totals[$plebs[$i]->id] = 0;
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
	$values = array();
	foreach ($totals as $id=>$words) {
		if ($id) {
			$pleb = $roster->GetPerson($id);
			$name = $pleb->GetName();
			$values[] = "($id, $date, $words)";
		}
		else {
			$name = 'Unknown';
		}
		printf("%9u   %-55s %10u\n", $id, $name, $words);
	}
	mysql_query('REPLACE INTO irc_stats (person, date, words) VALUES '.implode(', ', $values), $db);
	$timers['Overall'][1] = time();

	echo <<<EOH

TIMERS

Timer               Time
-----               ----

EOH;
	foreach ($timers as $name=>$timer) {
		printf("%-16s %6u%s\n", $name, $timer[1] - $timer[0], 's');
	}
}
?>
