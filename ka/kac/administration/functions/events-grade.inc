<?php

function CorrectBox($i, $q){
	return '<select name="grades['.$i.'][question]['.$q.']"><option value="1">Correct</option><option value="0">Incorrect</option>';
}

function output(){
	global $ka, $user, $mb, $judicator, $roster;
	
	if ($ka->IsEvent($_REQUEST['id'])){
	
		$event = new Event($_REQUEST['id']);

		if ($event->IsGraded()){
			echo 'This event has already been graded.';
		} else {
			$round = $event->GetRound();
			$kac = $round->GetSeason();
			$type = $event->GetTypes();
				
			if ($_REQUEST['submit']){
			
				$ladder = new Ladder($kac->GetSeasonID());
				
				$combat = $ladder->CombatKabals($round->GetRoundID());
				
				$errors = array();
				$kabals = array();
				$submissions = array();
				$finishers = array();
				$pesants = array();
				
				foreach ($_REQUEST['grades'] as $sub=>$data){
					$submission = new Submissions($sub);
					$kabal = $submission->GetKabal();
					
					if ($data['valid'] == 1){
						$total = count($data['question']);
						$score = 0;
						foreach ($data['question'] as $question){
							$score += $question;
						}
						$correct = round($score/$total);
						
						if ($correct){
							if (!$submission->SetPiece('correct', 1)){
								$errors[] = $submission->Error();
							}
						}
						
						if (!$submission->SetPiece('score', $score)){
							$errors[] = $submission->Error();
						}
						
					} elseif ($data['valid'] <= 0){
						if (!$submission->SetPiece('date_deleted', time())){
							$errors[] = $submission->Error();
						}
					}
				}
				
				foreach ($event->GetSubmissions() as $sub){
					$kabal = $sub->GetKabal();
					
					if (count($kabals[$kabal->GetID()]) < $kac->GetKabalCount() && $sub->IsCorrect()){
						$kabals[$kabal->GetID()][$sub->Dates('SYSTEM', 'submitted')] = $sub->GetID();
					} else {
						$submissions[$kabal->GetID()][$sub->Dates('SYSTEM', 'submitted')] = $sub->GetID();
					}
				}
				
				foreach ($combat as $bracket=>$data){
					foreach ($data as $kabal){
						if (isset($kabals[$kabal])){
							foreach ($kabals[$kabal] as $date=>$sub){
								$finishers[$bracket][$date] = $sub;							
							}
						}
						if (isset($submissions[$kabal])){
							foreach ($submissions[$kabal] as $date=>$sub){
								$pesants[$bracket][$date] = $sub;			
							}
						}
					}
				}
				
				foreach ($finishers as $bracket=>$data){
					ksort($data);
					$fin[$bracket] = $data;
				}
				
				$finishers = $fin;
				
				foreach ($pesants as $bracket=>$data){
					ksort($data);
					$pes[$bracket] = $data;
				}
				
				$pesants = $pes;
				
				foreach ($finishers as $bracket=>$data){
					if (count($data)+1 < $kac->GetMaximum()){
						$repetitions = $kac->GetMaximum()-count($data)-1;
						for ($i = 1; $i <= $repetitions; $i++){
							if (is_array($pesants[$bracket])){
								$shift = array_shift($pesants[$bracket]);
								if (isset($shift)){
									$finishers[$bracket][] = $shift;
								}
							}
						}
					}
				}
				
				$places = array();
				
				foreach ($finishers as $bracket=>$complete){
					$places[$bracket] = $kac->GetMinimum();
				}
				
				foreach ($finishers as $bracket=>$complete){
					foreach ($complete as $sub){
						$submissions = new Submissions($sub);
						
						if ($places[$bracket] <= $kac->GetMaximum()){
							if (!$submissions->SetPiece('place', $places[$bracket])){
								$errors[] = $submissions->Error();
							}
						}
						
						$places[$bracket]++;
					}
				}
				
				foreach ($pesants as $bracket=>$complete){
					foreach ($complete as $sub){
						$submissions = new Submissions($sub);
						
						if (!$submissions->SetPiece('place', -1)){
							$errors[] = $submissions->Error();
						}
						
						$places[$bracket]++;
					}
				}
				
				foreach ($event->GetSubmissions() as $sub){
					if ($sub->GetPlace() > -1){
						$award = $ka->GetAward($sub->GetPlace(), 0);
					} else {
						$award = $ka->GetAward($sub->GetPlace(), $sub->GetCorrect());
					}					
					
					$hunter = $sub->GetHunter();
					
					if ($award->UsesDefault()){
						$points = $kac->GetMaximum()-$sub->GetPlace();
					} else {
						$points = $award->GetPoints();
					}
					
					if (!$sub->SetPiece('points', $points)){
						$errors[] = $event->Error();
					}					
				}
				
				if (!$event->SetPiece('graded', 1)){
					$errors[] = $event->Error();
				}
				
				if (!count($round->Ungraded())){
				
					$round = $event->GetRound();
					
					$totals = $round->GetKabalPoints();
					
					$discrim = array();
					
					foreach ($combat as $bracket=>$data){
						
						if ($totals[$data[0]] == $totals[$data[1]]){
							if (count($event->GetSubmissionsByKabal($data[0])) == count($event->GetSubmissionsByKabal($data[1]))){
								foreach($event->GetSubmissionsByKabal($data[0]) as $sub){
									$discrim[$sub->GetPlace()] = $data[0];
								}
								if (isset($discrim[1])){
									$kabal = $data[0];
								} else {
									$kabal = $data[1];
								}
							} elseif (count($event->GetSubmissionsByKabal($data[0])) > count($event->GetSubmissionsByKabal($data[1]))){
								$kabal = $data[1];
							} else {
								$kabal = $data[0];
							}
						} elseif ($totals[$data[0]] > $totals[$data[1]]){
							$kabal = $data[0];
						} else {
							$kabal = $data[1];
						}
						
						if (!isset($kabal)){
							$rand = array_rand($data);
							$kabal = $data[$rand];
						}
						if (!$ladder->Win($kabal, $round->GetRoundID(), $bracket)){
							$errors[] = $ladder->Error();
						}						
					}					
				}
				
				if (!$ladder->NewRound()){
					$errors[] = $ladder->Error();
				}
				
				if (count($errors)){
					echo implode('<br />', $errors);
				} else {
					echo 'Grading completed.';
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
				
				
				
				if ($type->HasImage()){
					$form->table->StartRow();
					$form->table->AddCell('<center><img src="/kac/event_images/'.$type->GetAbbr(). '-'. $round->GetID() . '-' 
								. $kac->GetID() . '.jpg">', 2);
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
		        
		        $form = new Form($_SERVER['PHP_SELF']);
				$form->AddHidden('id', $_REQUEST['id']);
				foreach ($event->GetSubmissions() as $sub){
				
					$hunter = $sub->GetHunter();
					$kabal = $sub->GetKabal();
					$sub_answers = $sub->GetAnswers();
					
					$total_answers = count($sub_answers);
					
					$form->AddSectionTitle($hunter->GetName().' for '.$kabal->GetName());
					$form->table->AddRow('IP Address', $sub->GetIPAddress());
					
					$form->StartSelect('Status', 'grades['.$sub->GetID().'][valid]');
					$form->AddOption('1', 'Valid');
					$form->AddOption('-1', 'Invalid');
					$form->AddOption('0', 'No Effort');
					$form->EndSelect();
					
					for ($i = 1; $i <= $total_answers; $i++) {
						$form->table->AddRow('Correct Answers '.$i.'/'.$total_answers, stripslashes($answers[$i]));
				        $form->table->AddRow('Hunt Answers '.$i.'/'.$total_answers, stripslashes($sub_answers[$i]).' '.CorrectBox($sub->GetID(), $i));
			        }
				}		
				
		        $form->AddSubmitButton('submit', 'Submit Grades');
		        
				$form->EndForm();
			}
		}
		
	} else {
		$kabal = $user->GetDivision();
	
		$events = array();
		
		foreach ($ka->GetSeasons() as $kac){
			foreach ($kac->GetRounds() as $round){
				foreach ($round->NeedGrading() as $event){
					$events[] = $event;
				}
			}
		}
		
		if (count($events)){
			
			$table = new Table('', true);
				
			$table->StartRow();
			$table->AddHeader('Events to grade', 2);
			$table->EndRow();
			
			$table->AddRow('Ends', 'Event');
			
			foreach ($events as $event){
				$type = $event->GetTypes();
				$round = $event->GetRound();
				$table->AddRow($event->Dates('HUMAN', 'end'), '<a href="'.$_SERVER['PHP_SELF'].'?function=events&flag=grade&id='.$event->GetID().'">Round '
						.$round->GetRoundID().' '.$type->GetName().'</a>');
			}
			
			$table->EndRow();
			$table->EndTable();
		} else {
			echo 'There are no events to grade.';
		}
	}		
		
}

?>