<?php
	include ("../setup.php");
	$gui_obj->setTitle("Run Race Admin");
	
	function repair ($repair_val, $reg_obj)
	{
		global $db_obj;
		global $gui_obj;
		global $podracer_obj;
		$pod_obj = $reg_obj->getPod();
		$repair_worked = 0;		
		for ($k = 1; $k <= 3; $k++)
		{
			if ($repair_worked != 1)
			{
				mt_srand ((double) microtime() * 1000000); 
				$can_repair = mt_rand (1,10);
				if ($can_repair <= $repair_val)
				{
					$gui_obj->addContent ("&nbsp;&nbsp;".$pod_obj->getName()."'s $k".date ("S", mktime (0, 0, 0, 0, $k, 0))." repair attempt was successful<br>");
					$reg_obj->addComments ($pod_obj->getName()."'s $k".date ("S", mktime (0, 0, 0, 0, $k, 0))." repair attempt was successful");
					$repair_worked = 1;
				}
				else
				{
					$gui_obj->addContent ("&nbsp;&nbsp;".$pod_obj->getName()."'s $k".date ("S", mktime (0, 0, 0, 0, $k, 0))." repair attempt was a failure<br>");
					$reg_obj->addComments ($pod_obj->getName()."'s $k".date ("S", mktime (0, 0, 0, 0, $k, 0))." repair attempt was a failure");
					$reg_obj->removeTotal_points (5);
				}
			}
		}
		if ($repair_worked != 1)
		{
			$gui_obj->addContent ("&nbsp;&nbsp;".$pod_obj->getName()." could not repair its damages and was forced to dropout of the race<br>");
			$reg_obj->addComments ($pod_obj->getName()." could not repair its damages and was forced to dropout of the race");
			$reg_obj->setDropout(1);
		}	
	}
  
  function Random_damage ($course)
  {
    global $podracer_obj;
    $acourse_obj = new Course ($course);
    $damage_array = $acourse_obj->getRandom_damage();
    $array_index = $podracer_obj->random (0, sizeof($damage_array));
    $array_index = (int)($array_index);
    if (strlen($damage_array [$array_index]) < 1)
    {
      $damage_array [($array_index - 1)];
    }
    else
    {
      return $damage_array [$array_index];
    }
  }
  
	if (!isset($PHP_AUTH_USER)) 
	{
		die(login_failed());
	} 
	else 
	{
		//Login object from the BHG roster
		$hunter_obj = new Login ($PHP_AUTH_USER, $PHP_AUTH_PW, $coder_id);
		if (($hunter_obj->IsValid()) && ($hunter_obj->getID() == 230))
		{
      if (isset($has_run_go))
      {
        $race_obj = new Race ($has_run_go);
        $race_obj->setHas_run(1);
      }
      elseif (isset($selected))
			{				
				$race_obj = new Race ($selected);
				$course_obj = $race_obj->getCourse();
				$registrations_array = $race_obj->listRace_registrations(1);
				$gui_obj->addContent ("Race ".$race_obj->getID().": ".$race_obj->getName()."<br>");
				$gui_obj->addContent (sizeof($registrations_array)." Pods Entered<br>");
				for ($i = 1; $i <= $race_obj->getLaps(); $i++)
				{
					$gui_obj->addContent ("Starting Lap $i of ".$race_obj->getLaps()."<br>");
					for ($j = 0; $j < sizeof ($registrations_array); $j++)
					{		
						$reg_obj = $registrations_array [$j];						
						if ($i == 1)
						{            
              $reg_obj->addComments ("Starting \"".$race_obj->getName());	
              $reg_obj->addComments ("There are ".sizeof($registrations_array)." competitors");	
							$reg_obj->setTotal_points(0);
						}
						$pod_obj = $reg_obj->getPod();
            $reg_obj->addComments ("Begining Lap $i");
				
						$traction_val = $course_obj->getTraction() + $pod_obj->getTraction(1) + ($podracer_obj->random (1,5) - 3);
						$reg_obj->addTotal_points ($traction_val);
						
						$turning_val = $course_obj->getTurning() + $pod_obj->getTurning(1) + ($podracer_obj->random (1,5) - 3);
						$reg_obj->addTotal_points (2 * $turning_val);
						
						$accel_val = $course_obj->getAcceleration() + $pod_obj->getAcceleration(1) + ($podracer_obj->random (1,5) - 3);
						$reg_obj->addTotal_points (2 * $accel_val);

						$top_speed_val = $course_obj->getTop_speed() + $pod_obj->getTop_speed(1) + ($podracer_obj->random (1,5) - 3);
						$reg_obj->addTotal_points (3 * $top_speed_val);
						
						$air_brake_val = $course_obj->getAir_brake() + $pod_obj->getAir_brake(1) + ($podracer_obj->random (1,5) - 3);
						$reg_obj->addTotal_points ($air_brake_val);
						
						$repair_val = $course_obj->getRepair() + $pod_obj->getRepair(1) + ($podracer_obj->random (1,5) - 3);
						$reg_obj->addTotal_points ($repair_val);
			
						$cooling_val = $course_obj->getCooling() + $pod_obj->getCooling(1) + ($podracer_obj->random (1,5) - 3);
						$reg_obj->addTotal_points ($cooling_val);
						
						if (($cooling_val <= 0) && ($reg_obj->getDropout() == 0))
						{
							$comments = $pod_obj->getName()." has begun to overheat";
							$reg_obj->addComments ($comments);
							$gui_obj->addContent ("&nbsp;&nbsp;".$comments."<br>");
							repair ($repair_val, $reg_obj);
						}						
						
						$random_damage = $podracer_obj->random (1,10);
						if (($random_damage == 1) && ($reg_obj->getDropout() == 0))
						{
              $comments = $pod_obj->getName()." was ".Random_damage($course_obj->getID())." and has taken damage";
							$reg_obj->addComments ($comments);
							$gui_obj->addContent ("&nbsp;&nbsp;".$comments."<br>");
							repair ($repair_val, $reg_obj);
						}

						if ((((($turning_val + $traction_val + $air_brake_val) / 3) <= 0) && ($top_speed_val >= 3)) && ($reg_obj->getDropout() == 0))
						{
							$random_control = $podracer_obj->random (1,2);
							if ($random_control == 1)
							{
								$gui_obj->addContent ("&nbsp;&nbsp;".$pod_obj->getName()." took a turn too fast<br>");
								$reg_obj->addComments ("Your pod took the turn too fast and lots control");
								repair ($repair_val, $reg_obj);
							}
						}
						$reg_obj->addComments ("Ending Lap $i with a time of ".$reg_obj->getTotal_points());
            unset ($reg_obj);
					}
					
					$registration_nodropout_array = $race_obj->listRace_registrations (0);
					for ($k = 0; $k < sizeof ($registration_nodropout_array); $k++)
					{
						$registration_nodropout_obj = $registration_nodropout_array [$k];
						$nodropout_pod_obj = $registration_nodropout_obj->getPod();
													
						$nodropout_total_points = $registration_nodropout_obj->getTotal_points;
						$subselect_result = $db_obj->query ("SELECT * FROM podracer_race_registrations WHERE race = ".$race_obj->getID()." AND dropout = 1 AND pod <> ".$pod_obj->getID()." AND (total_points > ".($my_total_points - 10)." AND total_points < ".($my_total_points + 10).")");
						while ($subselect_row = mysql_fetch_array ($subselect_result))
						{
							$other_reg_obj = new Race_registration ($subselect_row ["id"]);	
							$other_pod_obj = $other_reg_obj->getPod();						
							$rand_collide = $podracer_obj->random (1,40);
							if ($registration_nodropout_obj->getDropout() != 1)
							{
								if ($rand_collide >= 39)
								{
									$gui_obj->addContent ($nodropout_pod_obj->getName()." and ".$other_pod_obj->getName()." collided (".$nodropout_pod_obj->getName()." exploded)<br>");
									$registration_nodropout_obj->addComments ("During Lap $j, you collided with ".addslashes($other_pod_obj->getName()));
									$registration_nodropout_obj->addComments ("The collision caused your pod to explode");
									$registration_nodropout_obj->setDropout(1);
								}
								elseif (($rand_collide > 30) && ($rand_collide < 39))
								{ 
									$gui_obj->addContent ($nodropout_pod_obj->getName()." and ".$other_pod_obj->getName()." collided (".$nodropout_pod_obj->getName()." begining repair)<br>");
									$registration_nodropout_obj->addComments ("During Lap $j, you collided with ".addslashes($other_pod_obj->getName()));
									$registration_nodropout_obj->addComments ("The collision caused your pod to require repairs");
									repair ($repair_val, $registration_nodropout_obj);
								}
							}
							unset ($other_pod_obj);
							unset ($other_reg_obj);
						}
						unset ($nodropout_pod_obj);
						unset ($registration_nodropout_obj);
					}					
				}
				$gui_obj->addContent("<br>Final Scores<br>");
				$registration_final_array = $race_obj->listRace_registrations (1);
				$half_count = (int)(sizeof($registrations_array) / 2);
				for ($b = 0; $b < sizeof ($registration_final_array); $b++)
				{
					$final_reg_obj = $registration_final_array [$b];
					$final_pod_obj = $final_reg_obj->getPod();
					$final_team_obj = $final_pod_obj->getTeam();
					if (($half_count - $b) >= 0)
					{
						$divided_amount = (int)($race_obj->getBase_reward() / $half_count);
						$current_winnings = $divided_amount * ($half_count - ($b));
						if ($b == 0) { $current_winnings = $race_obj->getBase_reward(); }
					}
					else
					{
						$current_winnings = 0;
					}
					if ($current_winnings < 0) { $current_winnings = 0; }
					$current_winnings += (int)(($current_winnings/15) * ($race_obj->getSkill_level() - $final_pod_obj->getASL()));								
					$podracer_obj->createRace_result ($final_reg_obj->getID(), ($b + 1), $current_winnings);
					$final_team_obj->addCredits ($current_winnings);
					$gui_obj->addContent($final_reg_obj->getTotal_points().": ".$final_pod_obj->getName()." owned by ".$final_team_obj->getName()." won ".number_format($current_winnings)." credits (".($race_obj->getSkill_level() - $final_pod_obj->getASL())." ASL Difference)<br>");
					$final_reg_obj->addComments ("Finished with ".$final_reg_obj->getTotal_points()." points and won ".number_format($current_winnings)." credits");
					unset ($final_team_obj);
					unset ($final_pod_obj);
					unset ($final_reg_obj);
				}
        $gui_obj->addContent("<p><a href=\"".$base_url."admin/run_race.php?has_run_go=".$race_obj->getID()."\">Click here to set Has Run</a></p>\r\n");
			}
			else
			{
				$gui_obj->addContent("<form action=\"$PHP_SELF\" method=\"Post\">\r\n");	
				$gui_obj->addContent("<select name=\"selected\">\r\n");
				$races_array = $podracer_obj->listRaces();
				for ($i = 0; $i < sizeof ($races_array); $i++)
				{
					$race_obj = $races_array [$i];
					$gui_obj->addContent("<option value=\"".$race_obj->getID()."\">".$race_obj->getName()."</option>\r\n");
					unset($race_obj);
				}		
				$gui_obj->addContent("</select>\r\n");
				$gui_obj->addContent("<input type=\"Submit\" name=\"Select\" value=\"Select\">");
				$gui_obj->addContent("<input type=\"hidden\" name=\"type\" value=\"$type\">\r\n");
				$gui_obj->addContent("</form>\r\n");				
			}				
			$gui_obj->outputGui();
		} 
		else 
		{
			die(login_failed());
			echo "Run Race";
		}
	}
?>