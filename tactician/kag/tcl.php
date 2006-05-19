<?php
include('header.php');
header('Content-Type: text/plain');

if (isset($_REQUEST['event'])) {
	$kags = $ka->GetKAGs();
	$kag = end($kags);

	if ((time() < $kag->GetSignupStart()) || (time() > $kag->GetEnd())) {
		echo 'No KG is running at present.';
	}
	else {
		$result = mysql_query('SELECT id FROM kag_events WHERE name LIKE "%' . addslashes($_REQUEST['event']) . '%" AND kag=' . $kag->GetID(), $db);
		if (strlen($_REQUEST['event']) >= 3 && $result && mysql_num_rows($result)) {
			$event = $ka->GetEvent(mysql_result($result, 0, 'id'));
			echo 'KAG ' . roman($kag->GetID()) . ' ' . $event->GetName() . ': Runs from ' . date('j F Y', $event->GetStart()) . ' to ' . date('j F Y', $event->GetEnd()) . '.';
			if ((time() < $event->GetEnd()) && (time() >= $event->GetStart())) {
				echo ' Time remaining: ' . format_time($event->GetEnd() - time(), FT_SECOND) . '.';
			}
			echo "\n";
		}
		else {
			echo 'No such event found.';
		}
	}
}
else {
	if ($_REQUEST['kag'] === '0') {
		$kag = $ka->GetKAG(0);
	}
	elseif (intval($_REQUEST['kag'])) {
		$kag = $ka->GetKAG((int) $_REQUEST['kag']);
	}
	elseif (empty($_REQUEST['kag']) || $_REQUEST['kag'] === '') {
		$kags = $ka->GetKAGs();
		$kag = end($kags);
	}
	elseif (($roman = Numbers_Roman::toNumber($_REQUEST['kag'])) && ($roman > 1 || $_REQUEST['kag'] == 'i')) {
		$kag = $ka->GetKAG($roman);
	}
	else {
		unset($kag);
	}
	
	if ($kag) {
		$kagid = $kag->GetID();

		$names = array();
		foreach ($kag->GetKabalTotals() as $kid=>$total) {
			$kabal = $roster->GetKabal($kid);
			$kname = $kabal->GetName();
			$names[] = $kname . ': ' . number_format($total);
		}

		$result = mysql_query("SELECT COUNT(DISTINCT event) AS events FROM kag_signups WHERE kag=$kagid AND state IN (1, 4)", $db);
		$events = count($kag->GetEvents());
		$marked = mysql_result($result, 0, 'events');
		echo 'Results for KG ' . roman($kagid) . ' ' . (($marked == $events) ? '(complete)' : "with $marked of $events events graded") . ': ' . implode(', ', $names) . '.';
	}
	else {
		// Look up hunter information.
		$value = $_REQUEST['kag'];

		switch (strtolower($value)) {
			case 'god':
			case 'frood':
				$value = 94;
				break;
			case 'satan':
			case 'bofh':
				$value = 666;
				break;
			case 'graphics-god':
			case 'oxx':
				$value = 257;
				$oxx = true;
				break;
			case '421':
				$value = 3;
				break;
			case 'munky':
			case 'cock':
				$value = 370;
				break;
			case 'e':
			case 'evil':
				$value = 45;
				break;
			case 'tex':
				$value = 1281;
				break;
			case 'balls':
				$value = 168;
		}

		if (strtolower($value) == 'status'){
			$result = mysql_query('SELECT id FROM kag_events WHERE end >= '.time().' AND start <= '.time().' AND kag=' . $kag->GetID(), $db);
			
			echo 'KAG ' . roman($kag->getID()) . ': ';
			echo mysql_error($result);
			while ($info = mysql_fetch_assoc($result)){
				$event = $ka->getEvent($info['id']);
				echo '[' . $event->getName() . ' - ' . format_time($event->GetEnd() - time(), FT_SECOND) . '] ';
			}
			
			echo "\n";
					
		} else {
			$plebs = $roster->SearchPosition($value);
			if (!$plebs) {
				$plebs = $roster->SearchName($value);
				if (!$plebs) {
					$plebs = $roster->SearchIRCNick($value);
				}
			}
	
			if (is_array($plebs) && count($plebs) > 0) {
				foreach ($plebs as $pleb) {
					$div = $pleb->GetDivision();
					$result = mysql_query('SELECT person FROM kag_signups WHERE person=' . $pleb->GetID(), $db);
					if ($result && mysql_num_rows($result) && $div->GetID() != 16 && $div->GetID() != 0) {
						$new_plebs[] = $pleb;
					}
				}
			}
	
			$plebs = $new_plebs;
			
			if (count($plebs) > 3) {
				echo 'More than three hunters match the name given.';
			}
			elseif (count($plebs) == 0) {
				echo 'No hunters match the criteria given.';
			}
			else {
				$info = array();
				foreach ($plebs as $pleb) {
					$result = mysql_query('SELECT kabal FROM kag_signups WHERE person=' . $pleb->GetID() . ' GROUP BY kabal', $db);
					$kabals = array();
					while ($row = mysql_fetch_array($result)) {
						$kabal = $roster->GetKabal($row['kabal']);
						$kabals[$kabal->GetID()] = $kabal->GetName();
					}
					asort($kabals);
					$result = mysql_query('SELECT MIN(kag) AS first, MAX(kag) AS last, SUM(points) AS points, COUNT(DISTINCT id) AS events FROM kag_signups WHERE person=' . $pleb->GetID(), $db);
					$row = mysql_fetch_array($result);
					$hinfo = 'KG History for ' . $pleb->GetName() . ' (' . implode(', ', $kabals) . '): ';
					if ($row['first'] == $row['last']) {
						$hinfo .= 'KG ' . roman($row['first']);
					}
					else {
						$hinfo .= 'KG ' . roman($row['first']) . ' - KG ' . roman($row['last']);
					}
					$hinfo .= '; ' . number_format($row['points']) . ' points; ' . number_format($row['events']) . ' events; ';
					$dnp_result = mysql_query('SELECT COUNT(DISTINCT id) AS dnps FROM kag_signups WHERE state=2 AND person=' . $pleb->GetID(), $db);
					if ($dnp_result && mysql_num_rows($dnp_result)) {
						$dnps = mysql_result($dnp_result, 0, 'dnps');
						$hinfo .= number_format($dnps) . ' DNP' . ($dnps != 1 ? 's' : '') . '; ';
					}
					$hinfo .= number_format($row['points'] / $row['events'], 1) . ' points per event.';
					$info[] = $hinfo;
				}
				echo implode("\n", $info);
			}
		}
	}
}
?>
