<?php
include('header.php');
header('Content-Type: text/plain');

if (isset($_REQUEST['event'])) {
	$cgs = $ka->GetCGs();
	$cg = end($cgs);

	if ((time() < $cg->GetSignupStart()) || (time() > $cg->GetEnd())) {
		echo 'No CG or KAG is running with that event at present.';
	}
	else {
		$result = mysql_query('SELECT id FROM cg_events WHERE name LIKE "%' . addslashes($_REQUEST['event']) . '%" AND cg=' . $cg->GetID(), $db);
		if (strlen($_REQUEST['event']) >= 3 && $result && mysql_num_rows($result)) {
			while ($row = mysql_fetch_array($result)) {
				$event = $ka->GetEvent($row['id']);
				echo 'CG ' . roman($cg->GetID()) . ' ' . $event->GetName() . ': Runs from ' . date('j F Y', $event->GetStart()) . ' to ' . date('j F Y', $event->GetEnd()) . '.';
				if ((time() < $event->GetEnd()) && (time() >= $event->GetStart())) {
					echo ' Time remaining: ' . format_time($event->GetEnd() - time(), FT_SECOND) . '.';
				}
				echo "\n";
			}
		}
		else {
			echo 'No such event found.';
		}
	}
}
else {
	if (empty($_REQUEST['cg']) || $_REQUEST['cg'] === '') {
		$cgs = $ka->GetCGs();
		$cg = end($cgs);
	}
	elseif (intval($_REQUEST['cg']) || $_REQUEST['cg'] === '0') {
		$cg = $ka->GetCG($_REQUEST['cg']);
	}
	elseif (($roman = Numbers_Roman::toNumber($_REQUEST['cg'])) && ($roman > 1 || $_REQUEST['cg'] == 'i')) {
		$cg = $ka->GetCG($roman);
	}
	else {
		unset($cg);
	}
	
	if ($cg) {
		$cgid = $cg->GetID();

		if ($cg->GetSignupEnd() >= time() && $cg->getSignupStart() <= time()){
			$remain = $cg->GetSignupEnd() - time();
			echo 'Signups for CG ' . roman($cgid) . ' end in ' . format_time($remain, ($remain > '3600' ? FT_HOUR : FT_SECOND)) . '.';
		} else {
			$names = array();
			foreach ($cg->GetCadreTotals() as $kid=>$total) {
				$cadre = $roster->GetCadre($kid);
				$kname = $cadre->GetName();
				$names[] = $kname . ': ' . number_format($total);
			}

			$result = mysql_query("SELECT COUNT(DISTINCT event) AS events FROM cg_signups WHERE cg=$cgid AND state IN (1, 4)", $db);
			$events = count($cg->GetEvents());
			$marked = mysql_result($result, 0, 'events');
			echo 'Results for CG ' . roman($cgid) . ' ' . (($marked == $events) ? '(complete)' : "with $marked of $events events graded") . ': ' . implode(', ', $names) . '.';
		}
	}
	else {
		// Look up hunter information.
		$value = $_REQUEST['cg'];

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
			
			$kags = $ka->GetCGs();
			$kag = end($kags);
			
			echo 'CG ' . roman($kag->getID()) . ': ';
			
			$result = mysql_query('SELECT id FROM cg_events WHERE end >= '.time().' AND start <= '.time().' AND cg=' . $kag->GetID() . ' ORDER BY end ASC', $db);
			
			if ($result && mysql_num_rows($result)) {
				while ($info = mysql_fetch_assoc($result)){
					$event = $ka->getEvent($info['id']);
					$remain = $event->GetEnd() - time();
					echo '[' . $event->getName() . ' - ' . format_time($remain, ($remain > '3600' ? FT_HOUR : FT_SECOND)) . '] ';
				}
			}
			else
				echo 'No events are open.';
			
			echo "\n";
			
		} elseif (strtolower($value) == 'events'){
			
			$kags = $ka->GetCGs();
			$kag = end($kags);
			
			echo 'CG ' . roman($kag->getID()) . ': ';
			
			$result = mysql_query('SELECT id FROM cg_events WHERE cg=' . $kag->GetID() . ' ORDER BY end ASC', $db);
			
			if ($result && mysql_num_rows($result)) {
				while ($info = mysql_fetch_assoc($result)){
					$event = $ka->getEvent($info['id']);
					$remain = $event->GetStart();
					echo '[' . $event->getName() . ' - Starts: ' . date("F j, Y, g:i a", $remain) . '; Ends: ' . date("F j, Y, g:i a", $event->getEnd()) . '] ';
				}
			}
			else
				echo 'No events are open.';
			
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
					$result = mysql_query('SELECT person FROM cg_signups WHERE person=' . $pleb->GetID(), $db);
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
					$result = mysql_query('SELECT cadre FROM cg_signups WHERE person=' . $pleb->GetID() . ' GROUP BY cadre', $db);
					$cadres = array();
					while ($row = mysql_fetch_array($result)) {
						$cadre = $roster->GetCadre($row['cadre']);
						$cadres[$cadre->GetID()] = $cadre->GetName();
					}
					asort($cadres);
					$result = mysql_query('SELECT MIN(cg) AS first, MAX(cg) AS last, SUM(points) AS points, COUNT(DISTINCT id) AS events FROM cg_signups WHERE person=' . $pleb->GetID(), $db);
					$row = mysql_fetch_array($result);
					$hinfo = 'CG History for ' . $pleb->GetName() . ' (' . implode(', ', $cadres) . '): ';
					if ($row['first'] == $row['last']) {
						$hinfo .= 'CG ' . roman($row['first']);
					}
					else {
						$hinfo .= 'CG ' . roman($row['first']) . ' - CG ' . roman($row['last']);
					}
					$hinfo .= '; ' . number_format($row['points']) . ' points; ' . number_format($row['events']) . ' events; ' . number_format($row['points'] / $row['events'], 1) . ' points per event.';
					$info[] = $hinfo;
				}
				echo implode("\n", $info);
			}
		}
	}
}
?>
