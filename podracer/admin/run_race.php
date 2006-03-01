<?php

	include "../header.php";
	$gui->setTitle("Run Race Admin");
	$output = array();
	$race = new Race ($_REQUEST['selected']);
	function repair ($repair_val, $reg, $part = 0)	{
		global $gui, $podracer, $store, $output, $race;
		$pod = $reg->getPod();
		$repair_worked = 0;
		for ($k = 1; $k <= 3; $k++) {
			if ($repair_worked != 1) {
				$can_repair = $podracer->random(0,10);
				if ($can_repair <= 5)	{
					$output[] = "&nbsp;&nbsp;".$pod->getName()."'s $k".date ("S", mktime (0, 0, 0, 0, $k, 0))." repair attempt was successful<br /><br>";
					$store[$reg->GetID()][] = $pod->getName()."'s $k".date ("S", mktime (0, 0, 0, 0, $k, 0))." repair attempt was successful<br />";
					$repair_worked = 1;
				} else {
					$output[] = "&nbsp;&nbsp;".$pod->getName()."'s $k".date ("S", mktime (0, 0, 0, 0, $k, 0))." repair attempt was a failure<br>";
					$store[$reg->GetID()][] = $pod->getName()."'s $k".date ("S", mktime (0, 0, 0, 0, $k, 0))." repair attempt was a failure";
					$reg->addTotalpoints (5);
				}
			}
		}
		if ($repair_worked != 1) {
			$output[] = "&nbsp;&nbsp;".$pod->getName()." could not repair its damages and was forced to dropout of the race<br /><br>";
			$store[$reg->GetID()][] = $pod->getName()." could not repair its damages and was forced to dropout of the race<br />";
			
			$go = true;
			
			if ($podracer->random(0,100) <= 75){
				$go = false;
				if ($race->GetSkillLevel() >= 25){
					$pod->delete();
					$pre = $pod->getName()."'s ";
					switch ($type){
						case 0: 
							$pre .= 'craft, suffering from the damages, had multiple system failure before it could land, and was destroyed on the track.<br />';
						break;
						
						case 1:
							$pre .= 'cooling systems were destroyed, and as the craft was landing, it was destroyed.<br />';
						break;
						
						case 2:
							$pre .= 'steering systems could not pull the pod back on track, and it crashed into the surroundings, exploding.<br />';
						break;
					}
					$store[$reg->GetID()][] = $pre;
					$output[] = "&nbsp;&nbsp;".$pre.'<br />';
					foreach ($pod->listParts() as $part){
						$part->delete();
					}
				} else {
					if (count($pod->listparts())){
						foreach ($pod->listParts() as $part){
							$part->delete();
						}
						$store[$reg->GetID()][] = $pod->getName()."'s podracer's damage caused it to crash. The pilot saved the hull itself, but all modifications were damaged.<br />";
						$output[] = "&nbsp;&nbsp;".$pod->getName()."'s podracer's damage caused it to crash. The pilot saved the hull itself, but all modifications were damaged.<br /><br />";
					}
				}
			}
			
			if ($go){
				if (count($pod->listparts())){
					if ($podracer->random(1,100) <= 33){
						$parts = $pod->ListParts();
						$part = array_rand($pod->ListParts());
						$parts[$part]->delete();
						$act = $parts[$part]->GetPart();
						$store[$reg->GetID()][] = $pod->getName()."'s ".$act->GetName()." was severly damaged in the race and is no longer useable.<br />";
						$output[] = "&nbsp;&nbsp;".$pod->getName()."'s ".$act->GetName()." was severly damaged in the race and is no longer useable.<br /><br />";
					}
				}
			}
			$reg->setDropout(1);
		}	
	}
  
  function Randomdamage ($course)
  {
    global $podracer;
    $acourse = new Course ($course);
    $damage = $acourse->getRandomDamage();
    if (is_array($damage) && count($damage)){
    	return $damage[array_rand($damage)];
	} else {
		return 'hit with something';
	}
  }

	$hunter = new Login_HTTP($coder_id);
		if (in_array($hunter->getID(), $admin))
		{
      if (isset($_REQUEST['selected']))	{				
				
				if (!$race->GetHasRun()){
					$course = $race->getCourse();
					$registrations = $race->listRaceRegistrations(1);
					$output[] = "<b>".$race->getName()."</b><br>";
					$output[] = sizeof($registrations)." Pods Entered<br>";
					$store = array();
					$weapons = array();
					foreach ($race->listRaceRegistrations(1) as $reg){
						$pod = $reg->getPod();
						$team = $pod->GetTeam();
						if ($pod->GetASL() > ($race->GetSkillLevel() + 25)){
							$fee = $race->GetCost() * .5;
							$fees = $pod->GetASL() - ($race->GetSkillLevel() + 25);
							if ($fees > $fee){
								$fee = $fees;
							}
							$store[$reg->GetID()][] = "Race officials inspect your pod ".$pod->GetName()." before the race and discover illegal modifications!"
							."<br />The officials disqualify the ".$pod->GetName()."for its excessive modifications and fines your team "
							.number_format($fee)." Imperial Credits!<br /><br />";	
							$reg->setDropout(1);
							$team->RemoveCredits($fee);	
						}
									
						if ($pod->GetWeaponry()){
							$weapons[$reg->GetID()] = $podracer->random(1,100);
						}
					}
										
					$use = array();
					
					foreach ($weapons as $id=>$fate){
						if (($fate <= 44) && ($reg->GetDropout() == 0)){
							$reg = new raceregistration($id);
							$team = $reg->GetTeam();
							$pod = $reg->GetPod();
							$rand = $podracer->random(100, 500);
							$fine = $rand*1000;
							$store[$reg->GetID()][] = "Race officials inspect your pod ".$pod->GetName()." before the race and discover illegal weapon placements!"
								."<br />The officials disqualify the ".$pod->GetName().", remove the illegal weapons, and fine your team "
									.number_format($fine)." Imperial Credits!<br /><br />";
							$output[] = "Race officials inspect the ".$pod->GetName()." before the race and discover illegal weapon placements!"
								."<br />The officials disqualify ".$pod->GetName().", remove the illegal weapons, and fine ".$team->GetName()." "
									.number_format($fine)." Imperial Credits!<br /><br />";
							$reg->setDropout(1);
							$team->RemoveCredits($fine);
						} else {
							$use[$id] = $podracer->random(4,12);
						}
					}
					
					for ($i = 1; $i <= $race->getLaps(); $i++){
						$output[] = "Starting Lap $i of ".$race->getLaps()."<br>";
							foreach ($registrations as $reg){
								if ($reg->GetDropout() == 0){
								if ($i == 1){
					              $store[$reg->GetID()][] = "Starting \"".$race->getName()."\"";
					              $store[$reg->GetID()][] = "There are ".sizeof($registrations)." competitors";	
					              $reg->SetTotalPoints(0);
								}
								$pod = $reg->getPod();
				            	$store[$reg->GetID()][] = "Begining Lap $i";
				            	$trmod = 0;
				            	$comod = 0;
				            	$acmod = 0;
				            	$tsmod = 0;
				            	$tumod = 0;
				            	$abmod = 0;
				            	$rpmod = 0;
				            	
				            	if (count($use)){
					            	$rand = $podracer->random(0,9);
					            	
					            	if (($rand == 3) && ($reg->GetDropout() == 0)){					
						            	if (!in_array($reg->GetID(), array_keys($use))){
											$cr = array_rand($use);
											$regs = new RaceRegistration($cr);
											if ($regs->getDropout() == 0){
												$ship = $regs->GetPod();
								            	$damage = $use[$cr];
								            	$str = $ship->GetName()."'s weapons damage your ";
								            	$damg = $ship->GetName()."'s weapons damage ".$pod->GetName()."'s ";
												switch ($podracer->random(1, 7)){
													case 1:
													$effect = "traction";
													$trmod = $damage;
													break;
													
													case 2:
													$effect = "cooling";
													$comod = $damage;
													break;
													
													case 3:
													$effect = "acceleration";
													$acmod = $damage;
													break;
													
													case 4:
													$effect = "speed";
													$tsmod = $damage;
													break;
													
													case 5:
													$effect = "turning";
													$tumod = $damage;
													break;
													
													case 6:
													$effect = "air break";
													$abmod = $damage;
													break;
													
													case 7:
													$effect = "repair";
													$rpmod = $damage;
												}
												$str .= $effect;
												$damg .= $effect;
												$damg .= " systems for ".$damage." points of damage!<br />";
												$str .= " systems for ".$damage." points of damage!<br /><br />";
												$reg->addTotalPoints(40);
												$output[] = $damg;
												$store[$reg->GetID()][] = $str;
											}
										}
									}
								}
				            	
				            	$course_run = $podracer->random(320,340);
				            	$tract = $course->GetTraction() + $trmod - $pod->GetTraction(1) + $podracer->random((-1 * $pod->GetTraction(1)), $pod->GetTraction(1)); //The course's traction difficulty zonks your own -
				            	$cooling = $course->getCooling() + $comod - $pod->getCooling(1) + $podracer->random((-1 * $pod->GetCooling(1)), $pod->GetCooling(1)); //The course's heat is zonked by your cooling -
				            	$accel = $pod->GetAcceleration(1) - $acmod - $course->GetAcceleration() + $podracer->random((-1 * $pod->GetAcceleration(1)), $pod->GetAcceleration(1)); //The course's difficulty on accel zonks your accel +
				            	$accel -= $cooling; //Your acceleration is reduced by the course's heat -
				            	$top_speed = $pod->GetTopSpeed(1) - $tsmod - $course->GetTopSpeed() + $podracer->random((-1 * $pod->GetTopSpeed(1)), $pod->GetTopSpeed(1)); //The course's difficulty on top speed zonks your top speed. +
				            	$ts = $top_speed;
				            	$turning = $course->GetTurning() + $tumod + $tract - $pod->GetTurning(1) + $podracer->random((-1 * $pod->GetTurning(1)), $pod->GetTurning(1)); //The course's difficulty on turning zonks your turning -
				   				$accel -= $turning; //Your accel is zonked by turning
				   				$top_speed -= $turning; //Your top speed is zonked by turning
				   				$air_break = $course->getAirBrake() + $abmod + $tract - $pod->GetAirBrake(1) + $podracer->random((-1 * $pod->GetAirBrake(1)), $pod->GetAirBrake(1)); //The course's requirement of the airbreak is zonked by your breaks. -
				   				$accel -= $air_break;
				   				$top_speed -= $air_break;
				   				$repair = $pod->GetRepair(1) - $rpmod - $course->GetRepair() + $podracer->random((-1 * $pod->GetRepair(1)), $pod->GetRepair(1)); //The course's requirement of repair tests yours. +
				   				$top_speed += $repair;
				   				$accel += $repair;
				            	$speed = $course_run - $top_speed - $accel;
	
								$reg->addTotalpoints ($speed);
								
								if (($cooling > $podracer->random(1,3)) && ($reg->getDropout() == 0))
								{
									$comments = $pod->getName()." has begun to overheat";
									$store[$reg->GetID()][] = $comments;
									$output[] = "&nbsp;&nbsp;".$comments."<br>";
									repair ($cooling, $reg, 1);
								}						
								
								$high = $course->GetRepair();
								if ($high < 0){
									$high *= -1;
								}
								
								$random_damage = $podracer->random (-5,3);
								if (($random_damage >= 0) && ($reg->getDropout() == 0))
								{
		              				$comments = $pod->getName()." was ".RandomDamage($course->getID())." and has taken damage";
									$store[$reg->GetID()][] = $comments;
									$output[] = "&nbsp;&nbsp;".$comments."<br>";
									repair ($repair, $reg);
								}
		
								$control = (($turning + $tract + $air_break) / 3);
								
								if (($control > $ts) && ($reg->getDropout() == 0))	{
										$output[] = "&nbsp;&nbsp;".$pod->getName()." took a turn too fast<br>";
										$store[$reg->GetID()][] = "Your pod took the turn too fast and lost control";
										repair ($turning, $reg, 2);
								}
								
								$minutes = round(abs($speed)/60, 2);
								$time = str_replace('.', ':', $minutes);
								
								$store[$reg->GetID()][] = "Ending Lap $i with a laptime of ".$time;
		            unset ($reg);
							}
							
							$regs = $race->listRaceregistrations (0);
							foreach ($regs as $reg){
								$pod = $reg->getPod();		
								$total_points = $reg->getTotalPoints();
								if ($total_points >= 40){
								$rura = $podracer->RuRa($pod, $race, $total_points);
									foreach ($rura as $other_reg){
										$other_pod = $other_reg->getPod();						
										$rand_collide = $podracer->random (1,100);
										if ($reg->getDropout() != 1)
										{
											if ($rand_collide == 30)
											{
												$output[] = $pod->getName()." and ".$other_pod->getName()." collided (".$pod->getName()." exploded)<br>";
												$store[$reg->GetID()][] = "During Lap $j, you collided with ".addslashes($other_pod->getName());
												$store[$reg->GetID()][] = "The collision caused your pod to explode";
													$pod->delete();
													$part_array = $pod->listParts();
									  				foreach ($pod->ListParts() as $part) {
									  					$part_type = $part->getPart();
									  					$part->delete();
									  				}
													$reg->setDropout(1);
											}
											elseif (($rand_collide > 63) && ($rand_collide < 65))
											{ 
												$output[] = $pod->getName()." and ".$other_pod->getName()." collided (".$pod->getName()." begining repair)<br>";
												$store[$reg->GetID()][] = "During Lap $j, you collided with ".addslashes($other_pod->getName());
												$store[$reg->GetID()][] = "The collision caused your pod to require repairs";
												repair($repair, $reg);
											}
										}						
										unset ($other_pod);
										unset ($other_reg);
									}
								}
								unset ($pod);
								unset ($reg);
							}
							
						}
							
					}
					
					$output[] = "<br>Final Scores<br>";
					$regs = $race->listRaceRegistrations(1);
					$sort = array();
					foreach ($regs as $reg){
						$sort[$reg->GetID()] = $reg->GetTotalPoints();
					}
					$podracer->FirePilots($race->GetID());
					asort($sort);
					reset($sort);
					$place = 1;
					$base = $race->GetBaseReward();
					foreach ($sort as $reg=>$points){
						$reg = new RaceRegistration($reg);
						$pod = $reg->getPod();
						$team = $pod->getTeam();
						if ($place == 1){
							switch (count($sort)){
								case 0:
									$mult = 0;
								break;
								
								case 1:
									$mult = 1;
								break;
								
								case 2:
									$mult = .75;
								break;
								
								case 3:
									$mult = .65;
								break;
								
								default:
									$mult = .65;
								break;
							}
							$winner_pod = $reg;
							$odds = $reg->GetHouseOdds();
							foreach ($podracer->ListBet($race->GetID()) as $bet){
								$bpod = $bet->GetPod();
								if ($bpod->GetID() == $pod->GetID()){
									$p = $bet->GetBHGID();
									$who = $podracer->FindTeamMember($p->GetID());
									$person = $roster->GetPerson($p->GetID());
									$person->makeSale (($bet->GetAmount() * $odds), 'Lyarna Podracer Circuit', 'Bet Payout Voucher');
								}
								$bet->Delete();
							}							
						} elseif ($place == 2){
							$mult = .25;
						} elseif ($place == 3) {
							$mult = .10;
						} else {
							$mult = .01;
						}		
						
						$winnings = $base*$mult;			
						$podracer->createRaceresult ($reg->getID(), $place, $winnings);
						$team->addCredits ($winnings);
						
						$minutes = round($reg->getTotalPoints()/60, 2);
						$time = str_replace('.', ':', $minutes);
						
						$output[] = $time." - ".$pod->getName()." owned by ".$team->getName()." won ".number_format($winnings)." credits<br>";
						$store[$reg->GetID()][] = "Placed ".$place." with a time of ".$time." points, winning ".number_format($winnings)." credits";
						unset ($team);
						unset ($pod);
						unset ($reg);
						$place++;
					}
					
					foreach ($podracer->ListBet($race->GetID()) as $bet){
						$bet->Delete();
					}
					
					foreach ($store as $id=>$value){
						$reg = new RaceRegistration($id);
						$reg->WriteRace($value);
					}
	        		$race->setHasrun(1);
	        		$output = implode('', $output);
					$gui->addContent ($output);
					
	        		$news->PostNews('Results: '.$race->GetName(), $output, 2650);
				}
			}
			else
			{
				$races = $podracer->listUpcomingRaces();
				if (count($races)){
					$gui->addContent("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"Post\">\r\n");	
					$gui->addContent("<select name=\"selected\">\r\n");
					foreach ($races as $race){ 
						$gui->addContent("<option value=\"".$race->getID()."\">".$race->getName()."</option>\r\n");
					}		
					$gui->addContent("</select>\r\n");
					$gui->addContent("<input type=\"Submit\" name=\"Select\" value=\"Select\">");
					$gui->addContent("<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">\r\n");
					$gui->addContent("</form>\r\n");				
				} else {
					$gui->addContent("No Pending Races");	
				}	
			}				
			$gui->outputGui();
		} 
		else 
		{
			die(login_failed());
			echo "Run Race";
		}
?>