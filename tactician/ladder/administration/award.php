<?php

include_once 'header.php';

page_header('Award for the Ladder');

if (!$GLOBALS['access']){
	echo 'You have no authority here.';
	page_footer();
	exit;
}

	if ($_REQUEST['submit']){
		
		$disable_rewards = true;
		$disable_medals = true;
		$disable_credits = false;
		
		$medals = array(1=>'XX', 2=>'XX', 3=>'XX');
		
		if (!is_array($_REQUEST['place'])){
			echo '<div><h2>Error</h2>Cannot process 0 rewards.</div>';
			page_footer();
		}
		
		echo '<div><h2>Reward Summary</h2>';
		
			if ($disable_rewards){
				echo '<b>All rewards disabled.</b><p>';
			} else {
				if ($disable_credits)
					echo '<b>Credit rewards disabled.</b><br />';
				
				if ($disable_medals)
					echo '<b>Medal rewards disabled.</b><br />';	
			}
		
		foreach ($_REQUEST['place'] as $pos => $reward){
			$pleb = new Person($_REQUEST['person'][$pos], 'tact-whats-that');
			if (!$disable_credits && !$disable_rewards && isset($_REQUEST['docredits'])){
				if ($pleb->AddCredits($reward, 'Tactician Ladder Rewards: ' . date('M \'y', $last_month_start))){
					echo 'Successfully awarded ';
				} else {
					echo 'Error awarding ';
				}
			} else {
				echo 'To ';
			}
			echo $pleb->IDline(0) . ' the sum of ' . number_format($reward) . ' ICs.<br />';
			
			
			if (in_array($pos, range(1,3))){
				
				if (is_numeric($medals[$pos])){
					$hasmed = true;
					$med = next_medal($pleb, $medals[$pos]);
				} else
					$hasmed = false;
					
				if (!$disable_medals && !$disable_rewards && isset($_REQUEST['domedals'])){
					if ($mb->AwardMedal($pleb, $judicator, $med, 'Tactician Ladder Rewards: ' . date('M \'y', $last_month_start))) {
						echo $med->getName() . ' successfully awarded to ' . $pleb->IDLine(0) . '<BR>';
					}
					else {
						echo 'Error adding medal to ' . $pleb->IDLine(0) . ': ' . $mb->Error() . '<BR>';
					}
				} else {
					
					echo $pleb->IDline(0) . ' would be awarded a ' . (!$hasmed ? 'Yet Unset Medal' : $med->getName()) . '.<br />';
				}
			}
			
			echo '<br />';
		}
		
		echo '</div>';
		
	} elseif ($_REQUEST['process']){
		$form = new Form($_SERVER['PHP_SELF']);
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
		
		$pos = 1;
		
		$default = array(1=>50000, 2=>35000, 3=>25000, 4=>15000, 5=>10000);
		
		arsort($ladder);
		
		foreach ($ladder as $person => $points){
			$person = new Person($person);

			if (in_array($person->getDivision()->getID(), array(16,11)))
				continue;
			
			$form->addTextBox('Credits for #' . $pos, 'place[' . $pos . ']', $default[$pos]);
			$form->addHidden('person['.$pos.']', $person->getID());
			
			$pos++;
			
			if ($pos == $_REQUEST['top']+1){
				break;
			}
		}

		$form->addCheckbox('Award Credits?', 'docredits', 1);
		$form->addCheckbox('Award Medals to Top 3?', 'domedals', 1);
		
		$form->addSubmitButton('submit', 'Submit Awards');
		$form->endForm();
	} else {
		$form = new Form($_SERVER['PHP_SELF']);
		$form->addSectionTitle('Tactician Ladder Awards');
		
		$form->addTextBox('Positions to Award: Top', 'top', 5, 5);
		
		$form->startSelect('Month', 'dm', date('m')-1);
		foreach (range(01,12) as $month){
			$form->addOption($month, date('F', mktime(0, 0, 0, $month, 1, 2000)));
		}
		$form->endSelect();
		
		$form->startSelect('Year', 'dy', date('y'));
		foreach (range('04', date('y')) as $year){
			$form->addOption($year, date('Y', mktime(0, 0, 0, 1, 1, $year)));
		}
		$form->endSelect();
		
		$form->addSubmitButton('process', 'Set Rewards');
		$form->endForm();
	}
	
	

page_footer();
?>