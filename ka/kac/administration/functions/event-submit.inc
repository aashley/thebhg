<?php

function output(){
	global $ka, $user;
	
	if ($ka->IsEvent($_REQUEST['id'])){
	
		$event = new Event($_REQUEST['id']);
		
		$round = $event->GetRound();
		$kac = $round->GetSeason();
		
		$kabal_check = $ka->Stats($user->GetID(), $round->GetID(), $kac->GetID());
					
		if (count($kabal_check['kabals'])){
			$value = $kabal_check['kabals'][0];
		} else {
			$kabal = $user->GetDivision();
			$value = $kabal->GetID();
		}
		
		if ($event->CanSubmit($user->GetID(), $value)){
			$kabal = new Division($value);
			
			if ($_REQUEST['submit']){
			
				if ($event->Submit($user->GetID(), $kabal->GetID(), time(), $_SERVER['REMOTE_ADDR'], $ka->ConditionContent($_REQUEST['answer']))){
					echo 'Answer Submitted Successfully';
				} else {
					echo $event->Error();
				}
				
			} else {
				$type = $event->GetTypes();
				
				$form = new Form($_SERVER['PHP_SELF']);
				
				$content = $event->GetContent();
				$answers = $content['answers'];
				$questions = $content['questions'];
				$total_answers = count($answers);
				$total_questions = count($questions);
				
				$form->AddSectionTitle($type->GetName().': Round '.$round->GetRoundID());
				
				$form->AddHidden('id', $_REQUEST['id']);
				
				if ($type->HasImage()){
					$form->table->StartRow();
					$form->table->AddCell('<center><img src="http://ka.thebhg.org/kac/event_images/'.$type->GetAbbr() . '-' 
								. $kac->GetID() . '.jpg">', 2);
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
			
		} else {			
			echo $event->Error();
		}
		
	} else {
		echo 'This is not a valid event id.';
	}		
		
}

?>