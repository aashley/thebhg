<?php
include_once('header.php');
page_header('KAG Hall of Fame');
$sql = "SELECT * FROM `kag_events` WHERE name ";
if (is_numeric($_REQUEST['event'])){
	$sql .= "= '' and type =".$_REQUEST['event'];
	$type = new KAGType($_REQUEST['event'], $db);
	$nme = $type->GetName();
} else {
	$sql .= 'LIKE "%' . addslashes($_REQUEST['event']) . '%"';
	$nme = htmlspecialchars($_REQUEST['event']);
}
$nme = ($nme ? '['.$nme.']' : '');
?>
			<div>
				<h2>KAG Hall of Fame :: Most Points Per Event <?=$nme?> (Hunter)</h2>
				<p>High scoring hunters have certain events they like to call home. The ability to totally control a single event over many KAGs rare one, and can establish a hunter as a god.</p>
			</div>
<?php

if ($_REQUEST['event']){

	$table = new Table();
	
	$maxima = GetKAGMaxima();
	$hunters = array();
	
	$query = mysql_query($sql, $db);
	$events = array();
	while ($info = mysql_fetch_assoc($query)){
		$events[] = $info['id'];
	}
	
	if ($_REQUEST['id']){
		$sql = "SELECT * FROM `kag_events` WHERE type = '".$_REQUEST['id']."'";
		$query = mysql_query($sql, $db);
		while ($info = mysql_fetch_assoc($query)){			
			$events[] = $info['id'];
		}
	}
	
	$events = implode(', ', $events);
	foreach (array_unique($maxima) as $points) {
		$kags = implode(', ', array_keys($maxima, $points));
		$sql = "SELECT person, SUM(points) AS points, COUNT(DISTINCT id) AS events, kag FROM kag_signups WHERE state > 0 AND event IN ($events) AND kag IN ($kags) GROUP BY person ORDER BY points DESC, events ASC LIMIT 10";
		$result = mysql_query($sql, $db);
		if ($result && mysql_num_rows($result))
			while ($row = mysql_fetch_array($result)) {
				if ($hunters[$row['person']]){
					$row['points'] = ScalePointsWithMaximum($points, $row['points'], $row['events']);
					$row['points'] += $hunters[$row['person']]['points'];
					$row['events'] += $hunters[$row['person']]['events'];
					$row['avg'] = $row['points']/$row['events'];
					$hunters[$row['person']] = $row;
				} else {
					$row['points'] = ScalePointsWithMaximum($points, $row['points'], $row['events']);
					$row['avg'] = $row['points']/$row['events'];
					$hunters[$row['person']] = $row;
				}
			}
	}
	
	usort($hunters, 'SortPointsDesc');
	
	if (count($hunters)){
		$table->StartRow();
		$table->AddHeader('');
		$table->AddHeader('Hunter');
		$table->AddHeader('Scaled Points');
		$table->AddHeader('Average Points');
		$table->AddHeader('Number of Events');
		$table->EndRow();
		
		if (count($hunters) >= 10){
			$tr = 10;
		} else {
			$tr = count($hunters);
		}
		
		for ($i = 0; $i < $tr; $i++) {
			$hunter =& $roster->GetPerson($hunters[$i]['person']);
			$table->StartRow();
			$table->AddCell('<div style="text-align: right">' . number_format($i + 1) . '</div>');
			$table->AddCell('<a href="../stats/hunter.php?id=' . $hunter->GetID() . '">' . htmlspecialchars($hunter->GetName()) . '</a>');
			$table->AddCell('<div style="text-align: right">' . number_format($hunters[$i]['points']) . '</div>');
			$table->AddCell('<div style="text-align: right">' . number_format($hunters[$i]['avg']) . '</div>');
			$table->AddCell('<div style="text-align: right">' . number_format($hunters[$i]['events']) . '</div>');
			$table->EndRow();
		}
	} else {
		$table->AddRow('No Event Data');
	}
	
	$table->EndTable();
	
} else {
	
	$table = new Table();
	$table->StartRow();
	$table->AddHeader('Select Event');
	$table->EndRow();
	$ids = array();
	$events = array();
	$result = mysql_query("SELECT * FROM kag_events WHERE name > '' AND type = 0 GROUP BY name ORDER BY name", $db);
	if ($result && mysql_num_rows($result)){
		while ($row = mysql_fetch_array($result)) {
			$query = mysql_fetch_assoc(mysql_query("SELECT * FROM kag_types WHERE name = '".$row['name']."'", $db));
			if ($query['name']){
				$id = $query['id'];
				$ids[] = $id;
			} else {
				$id = 0;
			}
			$events[$row['name']] = $id;
		}
	}
	
	$result = mysql_query("SELECT * FROM kag_events WHERE name = '' AND type > 0 GROUP BY type ORDER BY type", $db);
	if ($result && mysql_num_rows($result)){
		while ($row = mysql_fetch_array($result)) {
			if (!in_array($row['type'], $ids)){
				$type = new KAGType($row['type'], $db);
				$events[$type->GetName()] = $row['type'];
			}
		}
	}
	
	ksort($events);
	
	foreach ($events as $name=>$id) {
		$table->StartRow();
		$table->AddCell('<a href="event-single.php?event=' . $name . ($id ? '&id='.$id : '').'">' . htmlspecialchars($name) . '</a>');
		$table->EndRow();
	}
	
	$table->EndTable();
	
}

page_footer();
?>
