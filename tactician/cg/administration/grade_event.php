<?php
include_once('header.php');

function CorrectBox($i, $q){
	return '<select name="grades['.$i.'][question]['.$q.']"><option value="1">Correct</option><option value="0">Incorrect</option>';
}

page_header('Grade Event');

if ($level == 3) {
	if ($_REQUEST['submit']) {		
		if ($_REQUEST['event']){
			$event = $ka->GetEvent($_REQUEST['event']);
			$right = array();
			$numbers = array();
			$grading = array();
					
			foreach ($_REQUEST['grades'] as $sid=>$info) {
				$signup = $ka->GetSignup($sid);
				$signup->SetState($info['state']);
				if ($info['state'] == 1 || $info['state'] == 4){
					$num_right = 0;
					foreach ($info['question'] as $rights){
						if ($rights){
							$num_right++;
						}
					}
					$right[$sid] = $num_right;
				} else {
					$signup = $ka->GetSignup($sid);
					$signup->SetRank(0);
				}
			}
				
			arsort($right);
			
			foreach ($right as $sid=>$number){
				$numbers[$number][] = $sid;
			}
			
			$data = array_flip($right);
			
			foreach ($numbers as $number=>$info){
				foreach ($info as $sid){
					$signup = $ka->GetSignup($sid);
					$grading[$number][$signup->GetSubmitted()][] = $sid;
				}
			}
			
			krsort($grading);
			
			$i = 1;
			
			foreach ($grading as $number=>$info){
				ksort($info);
				foreach ($info as $data){
					foreach ($data as $sid){
						$signup = $ka->GetSignup($sid);
						$signup->SetRank($i);
						$i++;
					}
				}
			}
		} else {
			
			if (isset($_REQUEST['team'])){
				$event = $ka->GetEvent($_REQUEST['team']);
				if ($event->isTeam()){
					foreach ($_REQUEST['signup']['points'] as $sid => $id){
						$signup = $ka->getSignup($sid);
						$signup->SetPoints($id);
						$signup->SetState(1);
					}
				}
			} else {
				foreach ($_REQUEST['signup'] as $sid=>$info) {
					$signup =& $ka->GetSignup($sid);
					$signup->SetState($info['state']);
					if ($info['state'] == 1 || $info['state'] == 4) {
						$signup->SetRank($info['rank']);
					}
				}
			}
		}
		echo 'Event graded.';
	}
	elseif ($_REQUEST['event']) {
		$event =& $ka->GetEvent($_REQUEST['event']);
		$signups =& $event->GetSignups();
		$cg = $event->GetCG();
		
		if ($event->IsTimed()){
			$type = $event->GetTypes();
				
			$form = new Form($PHP_SELF);
			
			$content = $event->GetContent();
			$answers = $content['answers'];
			$questions = $content['questions'];
			$total_answers = count($answers);
			$total_questions = count($questions);
			
			$form->AddSectionTitle($type->GetName());
			
			if ($type->HasImage()){
				$form->table->StartRow();
				$form->table->AddCell('<center><center><img src="/cg/event_images/'.$type->GetAbbr(). '-'. $cg->GetID() . '-' 
								. $event->GetID() . '.jpg">', 2);
				$form->table->EndRow();
				for ($i = 1; $i <= $total_answers; $i++) {
					$form->table->AddRow('Hunt Answers '.$i.'/'.$total_answers, stripslashes($answers[$i]));
				}
			} else {
				if ($total_questions == $total_answers){
					for ($i = 1; $i <= $total_answers; $i++) {
						$form->table->AddRow('Hunt Question '.$i.'/'.$total_questions, stripslashes($questions[$i]));
				        $form->table->AddRow('Hunt Answers '.$i.'/'.$total_answers, stripslashes($answers[$i]));
			        }
		        } else {
			        for ($i = 1; $i <= $total_questions; $i++) {
						$form->table->AddRow('Hunt Question '.$i.'/'.$total_questions, stripslashes($questions[$i]));
			        }
			        for ($i = 1; $i <= $total_answers; $i++) {
				        $form->table->AddRow('Hunt Answers '.$i.'/'.$total_answers, stripslashes($answers[$i]));
			        }
		        }
	        }	
	        
	        $form->EndForm();
	        
	        hr();
	        
	        $form = new Form($PHP_SELF);
			
			foreach ($signups as $sub){
				
				$hunter = $sub->GetPerson();
				$cadre = $sub->GetCadre();
				$sub_answers = $sub->GetContent();
				
				if ($event->isTeam() && $hunter->getID() != $cadre->getLeader()->getID())
					continue;
				
				$total_answers = count($sub_answers);
				
				$form->AddSectionTitle($hunter->GetName().' for '.$cadre->GetName());
				$form->table->AddRow('IP Address', $sub->GetIP());
				
				$form->StartSelect('Status', 'grades['.$sub->GetID().'][state]');
				$form->AddOption('1', 'Valid');
				$form->AddOption('2', 'DNP');
				$form->AddOption('3', 'No Effort');
				$form->AddOption('4', 'Rank w/Penalty');				
				$form->EndSelect();
				
				for ($i = 1; $i <= $total_answers; $i++) {
					$form->table->AddRow('Correct Answers '.$i.'/'.$total_answers, stripslashes($answers[$i]));
			        $form->table->AddRow('Hunt Answers '.$i.'/'.$total_answers, stripslashes($sub_answers[$i]).' '.CorrectBox($sub->GetID(), $i));
		        }
			}
			
			$form->AddHidden('event', $_REQUEST['event']);
			
	        $form->AddSubmitButton('submit', 'Submit Grades');
	        
			$form->EndForm();
		} else {
			$form = new Form($_SERVER['PHP_SELF']);
			$form->table->StartRow();
			if ($event->isTeam()){
				$form->table->AddHeader('Cadre');
				$form->table->AddHeader('Points');
			} else {
				$form->table->AddHeader('Name');
				$form->table->AddHeader('Status');
				$form->table->AddHeader('Rank');
			}
			$form->table->EndRow();
			$sups = array();
			
			if ($event->isTeam()){
				$form->AddHidden('team', $_REQUEST['event']);
			}
			
			foreach ($signups as $signup) {
				$pleb = $signup->GetPerson();
				$sups[$pleb->GetName()] = $signup;
			}
			ksort($sups);
			foreach ($sups as $signup) {
				$pleb = $signup->GetPerson();
				$cadre = $signup->GetCadre();
				
				if ($event->isTeam() && $pleb->getID() != $cadre->getLeader()->getID())
					continue;
				
				$form->table->StartRow();
				
				if ($event->isTeam()){
					$form->table->AddCell($cadre->getName());
					$form->table->AddCell('<input type="name" name="signup[' . $signup->GetID() . '][points]">' . ($signup->GetState() == 1 ? ' value="' . $signup->GetPoints() . '"' : ''));
				} else {
					$form->table->AddCell($pleb->GetName());
					$form->table->AddCell('<select name="signup[' . $signup->GetID() . '][state]" size="1"><option value="1"' . ($signup->GetState() == 1 ? ' selected="selected"' : '') . '>Use the rank given</option><option value="2"' . ($signup->GetState() == 2 ? ' selected="selected"' : '') . '>DNP</option><option value="3"' . ($signup->GetState() == 3 ? ' selected="selected"' : '') . '>No effort</option><option value="4"' . ($signup->GetState() == 4 ? ' selected="selected"' : '') . '>Use rank with penalty</option></select>');
					$form->table->AddCell('<input type="text" name="signup[' . $signup->GetID() . '][rank]" size="5"' . (($signup->GetState() == 1 || $signup->GetState() == 4) ? ' value="' . $signup->GetRank() . '"' : '') . ' />');
				}
				$form->table->EndRow();
			}
			$form->table->StartRow();
			$form->table->AddCell('<input type="submit" name="submit" value="Save Scores" />', 3);
			$form->table->EndRow();
			$form->EndForm();
	
			if ($event->isTeam()){
				echo "
				Notes:
				<ul>
					<li><b>Points</b>: This is the total amount of points issued to a cadre for their team submission. It is the average of the grader scores</li>
				";						
				echo "
				</ul>
				";

			} else {
				echo "
				Notes:
				<ul>
					<li><b>Status</b>: This allows you to select whether the hunter had a DNP, a no effort submission, or just a regular submission. If there was a DNP or no effort, then the rank is disregarded. If &quot;Use rank with penalty&quot; is selected, then the rank will be used in the same way as a regular submission, but the points given to the hunter will be reduced by the amount set for the CG (usually 5 points).</li>
					<li><b>Rank</b>: This is the rank of the participant in the event. First place would be 1, second place is 2, and so on. Ties can be entered as the same event. For example, say you had the following results:
				";
	
						$table = new Table('', true);
						$table->StartRow();
						$table->AddHeader('Name');
						$table->AddHeader('Score');
						$table->EndRow();
						$table->AddRow('Jernai', '40');
						$table->AddRow('Gravant', '50');
						$table->AddRow('Koral', '30');
						$table->AddRow('Ehart', '40');
						$table->AddRow('Coursca', '10');
						$table->EndTable();
						echo '<br />The ranks would be as follows:';
						$table = new Table('', true);
						$table->StartRow();
						$table->AddHeader('Name');
						$table->AddHeader('Rank');
						$table->EndRow();
						$table->AddRow('Gravant', '1');
						$table->AddRow('Jernai', '2');
						$table->AddRow('Ehart', '2');
						$table->AddRow('Koral', '4');
						$table->AddRow('Coursca', '5');
						$table->EndTable();
						
				echo "
					<br />This allows for easy recalculation of results in the event that there is a change in maximum or minimum score.</li>
				</ul>
				";
			}
		}
	}
	elseif ($_REQUEST['cg']) {
		$cg =& $ka->GetCG($_REQUEST['cg']);
		$events =& $cg->GetEvents();
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->StartSelect('Event:', 'event');
		foreach ($events as $event) {
			if ($event->IsTimed()){
				$type = $event->GetTypes();
				$name = $type->GetName();
			} else {
				$name = $event->GetName();
			}
			$form->AddOption($event->GetID(), ($event->isGraded() ? '[GRADED] ' : '') . $name);
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Next >>');
		$form->EndForm();
	}
	else {
		$cgs =& $ka->GetCGs();
		$form = new Form($_SERVER['PHP_SELF'], 'get');
		$form->StartSelect('CG:', 'cg');
		foreach (array_reverse($ka->GetCGs()) as $cg) {
			$form->AddOption($cg->GetID(), roman($cg->GetID()));
		}
		$form->EndSelect();
		$form->AddSubmitButton('', 'Next >>');
		$form->EndForm();
	}
}
else {
	echo 'You are not authorised to access this page.';
}

page_footer();
?>
