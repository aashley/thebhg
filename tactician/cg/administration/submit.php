<?php
include_once('header.php');

page_header('Submit For Event');

if ($level <= 3) {
	
	if ($_REQUEST['event']){
		$event = $ka->GetEvent($_REQUEST['event']);
		
		$proceed = false;
		$events = array();
		
		if ($event){			
			if ($event->IsTimed()){
				$CG = $event->GetCG();
				if ($CG->GetStart() < time() && $CG->GetEnd() > time()){
					if ($event->GetStart() < time() && $event->GetEnd() > time()){
						foreach ($CG->GetHunterSignups($user->GetID()) as $signup){
							$even = $signup->GetEvent();
							$events[$even->GetID()] = $signup->GetID();
						}
						if (isset($events[$event->GetID()])){
							$signup_id = $events[$event->GetID()];
							$proceed = true;
						} else {
							echo 'You are not signed up for this event.';
						}
					} else {
						echo 'This event is over or has not started.';
					}
				} else {
					echo 'This CG is over or has not started.';
				}
			} else {
				echo 'Not a timed event. Cannot proceed.';
			}			
		} else {
			echo 'Invalid Event';
		}
		
		if ($proceed){
			
			if ($_REQUEST['submit']){
			
				if ($_REQUEST['signup']){
					$signup = $ka->GetSignup($_REQUEST['signup']);
				
					if ($signup->Submit($_SERVER['REMOTE_ADDR'], $ka->ConditionContent($_REQUEST['answer']))){
						echo 'Answer Submitted Successfully';
					} else {
						echo "Error submitting answer";
					}
				} else {
					echo 'Signup required.';
				}
				
			} else {
				$type = $event->GetTypes();
				
				echo "<div><h2>".$type->getName()." Description</h2><p>".$type->GetDesc()."</p></div>";
				
				$form = new Form($PHP_SELF);
				
				$content = $event->GetContent();
				$answers = $content['answers'];
				$questions = $content['questions'];
				$total_answers = count($answers);
				$total_questions = count($questions);
				
				$form->AddSectionTitle($type->GetName());
				
				$form->AddHidden('event', $_REQUEST['event']);
				$form->AddHidden('signup', $signup_id);
				
				if ($type->HasImage()){
					$form->table->StartRow();
					$form->table->AddCell('<center><img src="/CG/hunt_images/'.$type->GetAbbr(). '-'. $CG->GetID() . '-' 
								. $event->GetID() . '.jpg">', 2);
					$form->table->EndRow();
					for ($i = 1; $i <= $total_answers; $i++) {
						$form->AddTextBox('Hunt Answer '.$i.'/'.$total_answers, 'answer['.$i.']', '', 70);
					}
				} else {
					if ($total_questions == $total_answers){
						for ($i = 1; $i <= $total_answers; $i++) {
							$form->table->AddRow('Hunt Question '.$i.'/'.$total_questions, stripslashes($questions[$i]));
					        $form->AddTextBox('Hunt Answer '.$i.'/'.$total_answers, 'answer['.$i.']', '', 70);
				        }
			        } else {
				        for ($i = 1; $i <= $total_questions; $i++) {
							$form->table->AddRow('Hunt Question '.$i.'/'.$total_questions, stripslashes($questions[$i]));
				        }
				        for ($i = 1; $i <= $total_answers; $i++) {
					        $form->AddTextBox('Hunt Answer '.$i.'/'.$total_answers, 'answer['.$i.']', '', 70);
				        }
			        }
		        }			
				
		        $form->AddSubmitButton('submit', 'Submit Answer');
		        
				$form->EndForm();
			}
			
		}
		
	} else {
	
		$events = array();
echo 'active CGs:';
print_r($ka->GetActiveCGs());
		if (is_array($ka->GetActiveCGs())){
			foreach ($ka->GetActiveCGs() as $CG){
				if (is_array($CG->GetHunterSignups($user->GetID()))){
					foreach ($CG->GetHunterSignups($user->GetID()) as $signup){
						if (!$signup->GetSubmitted()){
							$cadre = $signup->GetCadre();
							$event = $signup->GetEvent();
							if ($event->IsTimed()){
								if ($event->GetStart() < time() && $event->GetEnd() > time()){
									$events[] = $event;
								}
							}
						}
					}
				}
			}
		}
			
		if (count($events)){
			
			$table = new Table('', true);
				
			$table->StartRow();
			$table->AddHeader('Events you can Submit for - '.$user->GetName().' of '.$cadre->GetName(), 2);
			$table->EndRow();
			
			$table->AddRow('Ends', 'Event');
			
			foreach ($events as $event){
				$type = $event->GetTypes();
				$table->AddRow(date('j F Y \a\t G:i:s T', $event->GetEnd()), '<a href="'.$PHP_SELF.'?event='.$event->GetID().'">'.$type->GetName().'</a>');
			}
			
			$table->EndRow();
			$table->EndTable();
		} else {
			echo 'There are no events for you to submit for.';
		}		
	}	
}
else {
	echo 'You are not authorised to access this page.';
}

page_footer();
?>
