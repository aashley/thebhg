<?php

include_once 'header.php';

/** Hunts **/
$sql = "SELECT `hunt_id`, `hunt_first` FROM `hunts` WHERE `hunt_division` = -1 AND `hunt_end_timestamp` <= $last_month_end AND `hunt_end_timestamp` >= $last_month_start";
$query = mysql_query($sql, $db);

while ($info = mysql_fetch_assoc($query)){
	
	$grade = "SELECT `grades` FROM `hunt_grades` WHERE `hunt_id` = '" . $info['hunt_id'] . "'";
	$send = mysql_query($grade, $db);
	
	while ($data = mysql_fetch_assoc($send)){
		
		$grades = unserialize(base64_decode(stripslashes($data['grades'])));
		$buffer = array();
		$posi   = array();

		foreach ($grades as $id => $datum){
			if ($datum['status']){
				$get = "SELECT `submission_person` FROM `hunt_submissions` WHERE `submission_id` = '" . $datum['id'] . "'";
				$result = mysql_query($get, $db);
				$person = mysql_result($result, 0, "submission_person");
				
				diagnose($person, 'KA Hunt: ' . $info['hunt_id'], 'Effort Answer');
				
				if (array_sum($datum['question'])){
					diagnose($person, 'KA Hunt: ' . $info['hunt_id'], 'Correct Answer');
				}
					
				if ($info['hunt_first']){
					$buffer[$person] = array_sum($datum['question']);
					$posi[$person] = $id;
				}
			}
		}
		
		if (count($buffer)){
			arsort($buffer);
			$highs = array_values($buffer);
			
			$high = $highs[0];
			
			foreach ($posi as $person => $ta){
				if ($buffer[$person] == $high){
					diagnose($person, 'KA Hunt: ' . $info['hunt_id'], 'First Place');
					break;
				}
			}
		}
	}
}

/** OMs **/
$sql = "SELECT * FROM `answers` WHERE `time` >= $last_month_start AND `time` <= $last_month_end ORDER BY `time` ASC";
$query = mysql_query($sql, $om);

while ($info = mysql_fetch_assoc($query)){
	$first = false;
	if ($info['correct'] != 2){
		diagnose($info['person'], 'OM #' . $info['mission'], 'Effort Answer');
		
		if ($info['correct']){
			diagnose($info['person'], 'OM #' . $info['mission'], 'Correct Answer');
			
			if (!$first){
				diagnose($info['person'], 'OM #' . $info['mission'], 'First Place');
				$first = true;
			}
		}
	}
}

/** Output **/
page_header('Tactician Ladder for ' . date('M \'y', $last_month_start));

if (!isset($_REQUEST['details'])){

	echo '<div><h2>' . (isset($_REQUEST['months']) ? 'Season ' : '') . 'Ladder Rankings For ' . date('M \'y', $last_month_start) . (isset($_REQUEST['months']) ? ' - ' . date('M \'y', $last_month_end) : '');
	
	$pos = 1;
	$true = 1;
	
	arsort($ladder);
	
	if (isset($_REQUEST['kabal'])){
		if ($_REQUEST['kabal'] != -1){
			$dbbal = new Kabal($_REQUEST['kabal']);
			
			echo ' for ' . $dbbal->getName(). ' Kabal';
		}
	}
		
	echo ':</h2>';
	
	echo (isset($_REQUEST['bt']) ? 'Tactician ' . (isset($_REQUEST['months']) ? 'Season ' : '') . 'Ladder Rankings For ' . date('M \'y', $last_month_start) . (isset($_REQUEST['months']) ? ' - ' . date('M \'y', $last_month_end) : '') . '<br />[b]' : '<b>');
	
	foreach ($ladder as $person => $points){
		$person = new Person($person);
		$go = false;
		
		if (is_object($dbbal)){
			if ($person->getDivision()->getID() == $dbbal->getID()){
				$go = true;
			} else {
				$go = false;
			}
		} else {
			
			if (!in_array($person->getDivision()->getID(), array(16,11))){
				$go = true;
			}
				
		}
		
		if ($go){
			echo (isset($_REQUEST['globalrank']) ? $pos : $true) . '. ' . $person->IDLine(0) . ' with ' . (isset($_REQUEST['bt']) ? '[i]' : '<i>') . 
				number_format($points) . (isset($_REQUEST['bt']) ? '[/i]' : '</i>') . ' points<br />';
			$true++;
		}
		$pos++;
		
		if ($true == (isset($_REQUEST['top']) ? $_REQUEST['top']+1 : 6)){
			echo (isset($_REQUEST['bt']) ? '[/b]' : '</b>') . '<br />';
			$hasecho = true;
		}
	}
	
	if (!isset($hasecho)){
		echo (isset($_REQUEST['bt']) ? '[/b]' : '</b>') . '<br />';
	}
	
	echo '</div>';
	
	$form = new Form('ladder.php');
	
	foreach ($_REQUEST as $id => $value){
		$form->addHidden($id, $value);
	}
	
	if (!isset($_REQUEST['kabal'])){
		$form->addHidden('kabal', -1);
	}
	
	$form->addSectionTitle('Extended Details');
	
	$form->table->startRow();
	$form->table->addCell('View a breakdown of all the points for this ladder breakdown.<hr noshade /><center><input type="submit" value="Extended Details" name="details" /><center>', 2);
	$form->table->endRow();
	
	$form->endForm();
	
} else {
	
	function display_data($person, $data){
		global $ladder;
		
		echo (isset($_REQUEST['bt']) ? '[b]' : '<b>') . (isset($_REQUEST['bt']) ? '[u]' : '<u>') .
		 $person->IDLine(0) .
		  (isset($_REQUEST['bt']) ? '[/b]' : '</b>') . (isset($_REQUEST['bt']) ? '[/u]' : '</u>') . ' - '. $ladder[$person->getID()] . ' Points <br />';
		foreach ($data as $event => $array){
			foreach ($array as $reason){
				echo str_repeat('&nbsp;', 4) . 'Received 1 point from ' . $event . ' for ' . $reason . '.<br />';
			}
		}
		echo '<p>';
	}
	
	echo '<div><h2>Tactician ' . (isset($_REQUEST['months']) ? 'Season ' : '') . 'Ladder (' . date('M \'y', $last_month_start) . (isset($_REQUEST['months']) ? ' - ' . date('M \'y', $last_month_end) : ''). ') Details';

	if (isset($_REQUEST['hunter'])){
		$person = new Person($_REQUEST['hunter']);
		echo ':</h2>';

		if (isset($_REQUEST['bt']))
			echo 'Tactician ' . (isset($_REQUEST['months']) ? 'Season ' : '') . 'Ladder (' . date('M \'y', $last_month_start) . (isset($_REQUEST['months']) ? ' - ' . date('M \'y', $last_month_end) : ''). ') Details:<br />';
		
		display_data($person, $diagnose[$person->getID()]);
	} elseif ($_REQUEST['kabal'] != -1){
		$dbbal = new Kabal($_REQUEST['kabal']);
		
		echo ' for ' . $dbbal->getName(). ' Kabal:</h2>';
		
		if (isset($_REQUEST['bt']))
			echo 'Tactician ' . (isset($_REQUEST['months']) ? 'Season ' : '') . 'Ladder (' . date('M \'y', $last_month_start) . (isset($_REQUEST['months']) ? ' - ' . date('M \'y', $last_month_end) : ''). ') Details for ' . $dbbal->getName(). ' Kabal:<br />';
		
		foreach ($dbbal->GetMembers() as $member){
			if (in_array($member->getID(), array_keys($diagnose))){
				display_data($member, $diagnose[$member->getID()]);
			}
		}
	} else {
		
		echo ':</h2>';
		
		if (isset($_REQUEST['bt']))
			echo 'Tactician ' . (isset($_REQUEST['months']) ? 'Season ' : '') . 'Ladder (' . date('M \'y', $last_month_start) . (isset($_REQUEST['months']) ? ' - ' . date('M \'y', $last_month_end) : ''). ') Details:<br />';
		
		foreach ($diagnose as $person => $data){
			$person = new Person($person);
			
			if (!in_array($person->getDivision()->getID(), array(16,11)))			
				display_data($person, $data);
		}
	}
	
	echo '</div>';
	
	$form = new Form('ladder.php');
	
	foreach ($_REQUEST as $id => $value){
		if ($id != 'details'){
			$form->addHidden($id, $value);
		}
	}
	
	if (!isset($_REQUEST['kabal'])){
		$form->addHidden('kabal', -1);
	}
	
	$form->addSectionTitle('Rank in Ladder');
	
	$form->table->startRow();
	$form->table->addCell('Put the details into a ranked ladder.<hr noshade /><center><input type="submit" value="View Ladder" name="ladder" /><center>', 2);
	$form->table->endRow();
	
	$form->endForm();
}

page_footer();

?>