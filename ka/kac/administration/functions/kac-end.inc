<?php

function output(){
	global $ka, $medal_groups, $mb, $judicator, $roster;
	
	if ($_REQUEST['submit']) {
		
		if ($_REQUEST['kac']){
			$kac = new KAC($_REQUEST['kac']);
			
			$ladder = new Ladder($kac->GetSeasonID());
			
			if ($kac->Dates('SYSTEM', 'end') < time()){
			
				if ($kac->IsGraded()){
					echo 'This season has already been graded.';
				} else {
				
					if ($ladder->CurrentRound() < 4){
						echo 'Ladder not ready. Can\'t end season with ungraded events';
					} else {
						$awards = array();
						
						// Transfer any current Cups to Medallions.
						$sql = 'UPDATE mb_awarded_medals SET medal=70 WHERE medal=69';
						mysql_query($sql, $roster->roster_db);
						
						foreach ($kac->GetRounds() as $round){
							foreach ($round->GradedEvents() as $event){		
								foreach ($event->GetSubmissions() as $sub){
									if ($sub->GetPlace() > -1){
										$award = $ka->GetAward($sub->GetPlace(), 0);
									} else {
										$award = $ka->GetAward($sub->GetPlace(), $sub->GetCorrect());
									}					
									
									$hunter = $sub->GetHunter();
									$credits = $award->GetCredits('SYSTEM');
									
									if (isset($awards[$hunter->GetID()])){
										$awards[$hunter->GetID()]['credits'] += $credits;
										if ($award->HasMedal()){
											$awards[$hunter->GetID()]['medals'][] = $award->GetMedal();
										}
									} else {
										$awards[$hunter->GetID()]['person'] = $hunter;
										$awards[$hunter->GetID()]['kabal'] = $sub->GetKabal();
										$awards[$hunter->GetID()]['credits'] = $credits;
										if ($award->HasMedal()){
											$awards[$hunter->GetID()]['medals'][] = $award->GetMedal();
										}
									}
											
									if ($credits){					
										$person = $roster->GetPerson($hunter->GetID());
										$person->AddCredits($credits, 'Kabal Authority Cup');
									}
									
									if ($award->HasMedal()){	
										$medal = $award->GetMedal();
										$type = $event->GetTypes();
										$mb->AwardMedal($hunter, $judicator, next_medal($mb, $hunter, $medal->GetID()), 'first place in Round ' . $round->GetID() . ' ' . $type->GetName() . ' in KAC ' 
												. roman($kac->GetID()), 0);
									}				
								}
							}
						}
			
						$winner = new Division ($ladder->Champion($ladder->CurrentRound()));
						
						$winner = $winner->GetID();
						
						// Output the results.
						$table = new Table('', true);
						$table->StartRow();
						$table->AddHeader('All credits and medals have been awarded.', 5);
						$table->EndRow();
						$table->StartRow();
						$table->AddHeader('Name');
						$table->AddHeader('Kabal');
						$table->AddHeader('Credits');
						$table->AddHeader('Medals');
						$table->AddHeader('Kabal Authority Cup');
						$table->EndRow();
						
						foreach ($awards as $person=>$award) {
							
							$table->StartRow();
							$table->AddCell($award['person']->GetName());
							$table->AddCell($award['kabal']->GetName());
							$table->AddCell('<div style="text-align: right">' . number_format($award['credits']) . '</div>');
							$medals = array();
							
							if (is_array($award['medals'])){
								foreach ($award['medals'] as $medal){
									$medals[$medal->GetID()]['name'] = $medal->GetName();
									if (isset($medals[$medal->GetID()]['number'])){
										$medals[$medal->GetID()]['number']++;
									} else {
										$medals[$medal->GetID()]['number'] = 1;
									}
								}
								
								$medal_piece = '';
								$medal_array = array();
								
								foreach ($medals as $data){
									$medal_array[] = $data['name'].': x'.$data['number'];
								}
							} else {
								$medal_piece = 'None';
							}						
							
							if (count($medal_array)){
								$medal_piece = implode(', ', $medal_array);
							}
							
							$table->AddCell($medal_piece);
							$table->AddCell($winner == $award['kabal']->GetID() ? 'Yes' : 'No');
							$table->EndRow();
				
							if ($winner == $award['kabal']->GetID()) {	
								$mb->AwardMedal($award['person'], $judicator, next_medal($mb, $award['person'], $medal_groups['kac']), $award['kabal']->GetName() . ' coming first in KAC ' . roman($_REQUEST['kac']));
								echo $mb->Error();
							}
							
						}
						
						$table->EndTable();
						
						hr();
						
						if ($kac->SetPiece('graded', 1)){
							echo 'KAC graded successfully';
						} else {
							echo $kac->Error();
						}
						
					}	
				}
			} else {
				echo 'Season still going on';
			}
			
		} else {
			echo 'Missing required season.';
		}
				
	} else {
		$form = new Form($_SERVER['PHP_SELF']);
		
		$seasons = array();
		
		foreach ($ka->GetSeasons() as $type){
			if ($type->Dates('SYSTEM', 'end') < time()){
				if (!$type->IsGraded()){
					$seasons[] = $type;
				}
			}
		}
		
		if (count($seasons)){
		
			$form->StartSelect('Select KAC', 'kac');
			foreach ($seasons as $type){
				$form->AddOption($type->GetID(), 'Season '.roman($type->GetID()));
			}
			$form->EndSelect();
			
			$form->AddSubmitButton('submit', 'End Season');
		} else {
			echo 'No seasons to grade.';
		}
		$form->EndForm();
	}
	
}

?>