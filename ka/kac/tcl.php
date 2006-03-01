<?php
include('header.php');
header('Content-Type: text/plain');

if (isset($_REQUEST['event'])) {
	$kacs = $ka->GetSeasons();
	$kac = end($kacs);
	
	if ((time() < $kac->Dates('SYSTEM', 'start') || (time() > $kac->Dates('SYSTEM', 'end')))) {
		echo "<begin>\nNo KAC is running at present.\n<end>";
	}
	else {
		$type = $ka->KACEvent($_REQUEST['event']);
		
		echo "<begin>\n";
		
		if (is_object($type)){
			$events = $kac->EventByType($type->GetID());
			if (count($events)){
				echo "KAC ".roman($kac->GetID());
				foreach ($events as $event){
					echo "\n";
					$round = $event->GetRound();
					echo 'Round '.$round->GetRoundID().' '.$type->GetName().' ('.$type->GetAbbr().'): Runs from '.date('j F Y', 
						$event->Dates('SYSTEM', 'start')).' to '.date('j F Y', $event->Dates('SYSTEM', 'end')).'.';
					if ((time() > $event->Dates('SYSTEM', 'start') && (time() < $event->Dates('SYSTEM', 'end')))){
						echo ' Time remaining: ' . format_time($event->Dates('SYSTEM', 'end') - time(), FT_SECOND) . '.';
					}
				}
			} else {
				echo 'Event not running during this KAC.';
			}
		} else {
			echo 'No such event found.';
		}
		
		echo "\n<end>";
	}
}
else {
	if (empty($_REQUEST['kac']) || $_REQUEST['kac'] === '') {
		$kacs = $ka->GetSeasons();
		$kac = end($kacs);
	}
	elseif (intval($_REQUEST['kac']) || $_REQUEST['kac'] === '0') {
		$kac = $ka->GetKAC($_REQUEST['kac']);
	}
	elseif (($roman = Numbers_Roman::toNumber($_REQUEST['kac'])) && ($roman > 1 || $_REQUEST['kac'] == 'i')) {
		$kac = $ka->GetKAC($roman);
	}
	else {
		unset($kac);
	}
	
	if (is_object($kac)) {
		$kacid = $kac->GetID();

		$names = array();
		foreach ($kac->GetKabalTotals() as $kid=>$total) {
			$kabal = $roster->GetKabal($kid);
			$kname = $kabal->GetName();
			$names[] = $kname . ': ' . number_format($total);
		}
		$marked = 0;
		$events = 0;
		
		if (!count($names)){
			$names[] = 'No Results';
		}
		
		foreach ($kac->GetRounds() as $round){
			$events += count($round->NormalEvents());
			$marked += count($round->GetEvents());
		}

		$unmark = $events-$marked;
		
		echo "<begin>\nResults for KAC " . roman($kacid) . ' ' . (($marked == 0) ? '(complete)' : "with $unmark of $events events graded") . ': ' . implode(', ', $names) . ".\n<end>\n";
	}
	else {
		// Look up hunter information.
		$value = $_REQUEST['kac'];

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
		
		$plebs = array();

		if (is_numeric($value)) {
			$plebs[] = $roster->GetPerson($value);
			$test = $plebs[0]->Error();
			if ($test > '') {
				array_pop($plebs);
			}
		}
		else {
			$plebs = $roster->SearchPosition($value);
			if (!$plebs) {
				if (strlen($value) < 3) {
					exit;
				}
				$plebs = $roster->SearchName($value);
				if (!$plebs) {
					$plebs = $roster->SearchIRCNick($value);
				}
			}
		}
		
		$new_plebs = array();
		
		foreach ($plebs as $pleb) {
			$stat = $ka->Stats($pleb->GetID());
					
			$stat['person'] = $pleb;
			
			if (count($stat['events'])){
				$new_plebs[] = $stat;
			}
		}
		
		$plebs = $new_plebs;
		
		if (count($plebs) > 3) {
			echo "<begin>\nMore than three hunters match the name given.\n<end>\n";
		}
		elseif (count($plebs) == 0) {
			echo "<begin>\nNo hunters match the criteria given.\n<end>\n";
		}
		else {
			$info = array();
			foreach ($plebs as $stat) {
				
				$kabals = array();
				
				foreach ($stat['kabals'] as $kabal){
					$kabal = new Division($kabal);
					$kabals[] = $kabal->GetName();
				}
				
				$hinfo = 'KAC History for '.$stat['person']->GetName().' ('.implode(', ', $kabals).'): ';
				
				$season_data = $stat['season'];
				asort($season_data);
				$first = new KAC(array_shift($season_data));
				
				$season_data = $stat['season'];			
				arsort($season_data);			
				$last = new KAC(array_shift($season_data));
				
				if ($first->GetID() == $last->GetID()){
					$hinfo .= 'KAC '.roman($last->GetID());
				} else {
					$hinfo .= 'KAC '.roman($first->GetID()).' - '.roman($last->GetID());
				}
				
				$hinfo .= '; ' . number_format($stat['points']) . ' points; ' . number_format(count($stat['events'])) . ' events; ';
				$dnp_result = mysql_query('SELECT COUNT(DISTINCT id) AS dnps FROM kag_signups WHERE state=2 AND person=' . $pleb->GetID(), $db);
				$hinfo .= number_format($stat['points'] / count($stat['events']), 1) . ' points per event.';
				$info[] = $hinfo;
			}
			echo "<begin>\n" . implode("\n", $info) . "\n<end>\n";
		}
	}
}
?>
