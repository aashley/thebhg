<?php

	/***************************************
	* Citadel Class
	* This is the main class that includes
	* all of the subclasses. It also contains
	* functions to create a new object of any
	* type and to list an array of objects of
	* any type.
	***************************************/
	
	include_once ("db.inc");
	include_once ("gui.inc");
	include_once ("course.inc");
	include_once ("owned_part.inc");
	include_once ("part.inc");
	include_once ("owned_pod.inc");
	include_once ("pod.inc");
	include_once ("race.inc");
	include_once ("race_registration.inc");
	include_once ("race_result.inc");
	include_once ("team.inc");
	include_once ("team_member.inc");
	include_once ("bet.inc");
	
	$db_obj = new DB ("conquest_podracer", "localhost", "conquest", "jedi1");
	
	class Podracer
	{
		function createTeam ($name, $credits, $leader, $slogan, $url)
		{
			global $db_obj;
			$insert_sql = "INSERT INTO podracer_teams (name, credits, leader, slogan, url, image, image_type) values ('$name', $credits, $leader, '$slogan', '$url', '', '')";
			$insert_result = $db_obj->query($insert_sql);
			$team_obj = new Team (mysql_insert_id ($db_obj->getDbconnection()));
			if ($insert_result)
				return $team_obj;
			else
				return 0;
		}
		
		function createTeam_member ($bhg_id, $team)
		{
			global $db_obj;
			$insert_sql = "INSERT INTO podracer_team_members (bhg_id, team) values ($bhg_id, $team)";
			$insert_result = $db_obj->query($insert_sql);
			$team_member_obj = new Team_member (mysql_insert_id ($db_obj->getDbconnection()));
			if ($insert_result)
				return $team_member_obj;
			else
				return 0;
		}
		
		function findTeam_member ($bhg_id)
		{
			global $db_obj;
			$find_result = $db_obj->query("SELECT id FROM podracer_team_members WHERE bhg_id = $bhg_id");
			if (mysql_num_rows($find_result) > 0)
			{
				$find_row = mysql_fetch_array ($find_result);
				$team_member_obj = new Team_member ($find_row["id"]);
				return $team_member_obj;
			}
			else
				return 0;
		}
    
		function createRace ($course, $name, $date, $reg_date, $base_reward, $pod_limit, $skill_level, $laps, $buyin)
		{
			global $db_obj;
			$insert_sql = "INSERT INTO podracer_races (course, name, date, reg_date, base_reward, pod_limit, skill_level, laps, buyin) values ($course, '$name', '$date', '$reg_date', $base_reward, $pod_limit, $skill_level, $laps, $buyin)";
			$insert_result = $db_obj->query($insert_sql);
			$race_obj = new Race (mysql_insert_id ($db_obj->getDbconnection()));
			if ($insert_result)
				return $race_obj;
			else
				return 0;
		}
		
		function createRace_result ($reg, $place, $winnings)
		{
			global $db_obj;
			$check_result = $db_obj->query ("SELECT COUNT(*) AS num FROM podracer_race_results WHERE registration = $reg");
			if (mysql_result ($check_result, 0, "num") > 0)
				$delete_result = $db_obj->query ("DELETE FROM podracer_race_results WHERE registration = $reg");
			$insert_sql = "INSERT INTO podracer_race_results (registration, place, winnings) values ($reg, $place, $winnings)";
			$insert_result = $db_obj->query($insert_sql);
			$race_result_obj = new Race_result (mysql_insert_id ($db_obj->getDbconnection()));
			if ($insert_result)
				return $race_result_obj;
			else
				return 0;
		}
		
		function createRace_registration ($race, $pod)
		{
			global $db_obj;
			$insert_sql = "INSERT INTO podracer_race_registrations (race, pod) values ($race, $pod)";
			$insert_result = $db_obj->query($insert_sql);
			$race_registration_obj = new Race_registration (mysql_insert_id ($db_obj->getDbconnection()));
			if ($insert_result)
				return $race_registration_obj;
			else
				return 0;
		}
		
		function createPod ($name, $description, $cost, $traction, $turning, $acceleration, $top_speed, $air_brake, $cooling, $repair)
		{
			global $db_obj;
			$insert_sql = "INSERT INTO podracer_pod_types (name, description, cost, traction, turning, acceleration, top_speed, air_brake, cooling, repair) values ('$name', '$description', $cost, $traction, $turning, $acceleration, $top_speed, $air_brake, $cooling, $repair)";
			$insert_result = $db_obj->query($insert_sql);
			$pod_type_obj = new Pod (mysql_insert_id ($db_obj->getDbconnection()));
			if ($insert_result)
				return $pod_type_obj;
			else
				return 0;
		}

		function createPart ($type, $name, $description, $cost, $limit, $increase)
		{
			global $db_obj;
			$insert_sql = "INSERT INTO podracer_parts (type, name, description, cost, part_limit, increase) values ('$type', '$name', '$description', $cost, $limit, $increase)";
			$insert_result = $db_obj->query($insert_sql);
			$part_obj = new Part (mysql_insert_id ($db_obj->getDbconnection()));
			if ($insert_result)
				return $part_obj;
			else
				return 0;
		}	
		
		function createOwned_pod ($type, $team, $name)
		{
			global $db_obj;
			$insert_sql = "INSERT INTO podracer_owned_pods (type, team, name) values ($type, $team, '$name')";
			$insert_result = $db_obj->query($insert_sql);
			$owned_pod_obj = new Owned_pod (mysql_insert_id ($db_obj->getDbconnection()));
			if ($insert_result)
				return $owned_pod_obj;
			else
				return 0;
		}
		
		function createOwned_part ($part, $pod)
		{
			global $db_obj;
			$insert_sql = "INSERT INTO podracer_owned_parts (part, pod) values ($part, $pod)";
			$insert_result = $db_obj->query($insert_sql);
			$owned_part_obj = new Owned_part (mysql_insert_id ($db_obj->getDbconnection()));
			if ($insert_result)
				return $owned_part_obj;
			else
				return 0;
		}
		
		function createCourse ($name, $description, $traction, $turning, $accel, $top_speed, $air_brake, $cooling, $repair)
		{
			global $db_obj;
			$insert_sql = "INSERT INTO podracer_courses (name, description, traction, turning, acceleration, top_speed, air_brake, cooling, repair) values ('$name', '$description', $traction, $turning, $accel, $top_speed, $air_brake, $cooling, $repair)";
			$insert_result = $db_obj->query($insert_sql);
			$course_obj = new Course (mysql_insert_id ($db_obj->getDbconnection()));
			if ($insert_result)
				return $course_obj;
			else
				return 0;
		}
		
		function createBet ($bhg_id, $pod, $race, $amount)
		{
			global $db_obj;
			$insert_sql = "INSERT INTO podracer_bets (bhg_id, pod, race, amount) values ($bhg_id, $pod, $race, $amount)";
			$insert_result = $db_obj->query($insert_sql);
			$bet_obj = new Bet (mysql_insert_id ($db_obj->getDbconnection()));
			if ($insert_result)
				return $bet_obj;
			else
				return 0;
		}
		
		function listTeams ()
		{
			global $db_obj;
      $teams_array = array ();
			$teams_result = $db_obj->query ("SELECT id FROM podracer_teams ORDER BY name ASC");
			while ($teams_row = mysql_fetch_array ($teams_result))
				$teams_array [] = new Team ($teams_row["id"]);
			return $teams_array;
		}
		

		function listTeam_members ()
		{
			global $db_obj;      
      $teams_array = array ();
			$teams_result = $db_obj->query ("SELECT id FROM podracer_team_members ORDER BY bhg_id ASC");
			while ($teams_row = mysql_fetch_array ($teams_result))
			  $teams_array [] = new Team_member ($teams_row["id"]);
			return $teams_array;
		}
		
		function listPods ()
		{
			global $db_obj;
      $pods_array = array ();
			$pods_result = $db_obj->query ("SELECT id FROM podracer_pod_types ORDER BY name ASC");
			while ($pods_row = mysql_fetch_array ($pods_result))
				$pods_array [] = new Pod ($pods_row["id"]);
			return $pods_array;
		}
		
		function listParts ()
		{
			global $db_obj;
      $part_array = array ();
			$part_result = $db_obj->query ("SELECT id FROM podracer_parts ORDER BY type ASC");
			while ($part_row = mysql_fetch_array ($part_result))
				$part_array [] = new Part ($part_row["id"]);
			return $part_array;
		}
		
		function listCourses ()
		{
			global $db_obj;
      $course_array = array ();
			$course_result = $db_obj->query ("SELECT id FROM podracer_courses ORDER BY name ASC");
			while ($course_row = mysql_fetch_array ($course_result))
				$course_array [] = new Course ($course_row["id"]);
			return $course_array;
		}
		
		function listRaces ()
		{
			global $db_obj;
      $race_array = array ();
			$race_result = $db_obj->query ("SELECT id FROM podracer_races ORDER BY id ASC");
			while ($race_row = mysql_fetch_array ($race_result))
				$race_array [] = new Race ($race_row["id"]);
			return $race_array;
		}
		
		function listUpcomingRaces ()
		{
			global $db_obj;
      $race_array = array ();
			$race_result = $db_obj->query ("SELECT id FROM podracer_races WHERE has_run = 0 ORDER BY date ASC");		
			while ($race_row = mysql_fetch_array ($race_result))
				$race_array [] = new Race ($race_row["id"]);
			return $race_array;
		}
		
		function listRace_registrations ($show_dropouts)
		{
			global $db_obj;
      $race_array = array ();
			if ($show_dropouts == 1)
				$race_result = $db_obj->query ("SELECT id FROM podracer_race_registrations ORDER BY id ASC");
			else
				$race_result = $db_obj->query ("SELECT id FROM podracer_race_registrations WHERE dropout = 0 ORDER BY id ASC");
			while ($race_row = mysql_fetch_array ($race_result))
				$race_array [] = new Race_registration ($race_row["id"]);
			return $race_array;
		}
		
		function listRace_results ()
		{
			global $db_obj;
      $race_array = array ();
			$race_result = $db_obj->query ("SELECT id FROM podracer_race_results ORDER BY id ASC");
			while ($race_row = mysql_fetch_array ($race_result))
				$race_array [] = new Race_result ($race_row["id"]);
			return $race_array;
		}
		
		function listOwned_pods ()
		{
			global $db_obj;
      $pod_array = array ();
			$pod_result = $db_obj->query ("SELECT id FROM podracer_owned_pods ORDER BY id ASC");
			while ($pod_row = mysql_fetch_array ($pod_result))
				$pod_array [] = new Owned_pod ($pod_row["id"]);
			return $pod_array;
		}
		
		function listOwned_parts ()
		{
			global $db_obj;
      $part_array = array ();
			$part_result = $db_obj->query ("SELECT id FROM podracer_owned_parts ORDER BY id ASC");
			while ($part_row = mysql_fetch_array ($part_result))
				$part_array [] = new Owned_part ($part_row["id"]);
			return $part_array;
		}
		
		function listBets ($hunter_id)
		{
			global $db_obj;
      $bet_array = array ();
			$bet_result = $db_obj->query ("SELECT id FROM podracer_bets WHERE bhg_id = $hunter_id ORDER BY id ASC");
			while ($bet_row = mysql_fetch_array ($bet_result))
				$bet_array [] = new Bet ($bet_row["id"]);
			return $bet_array;
		}
		
		function random ($min, $max)
		{
			mt_srand ((double) microtime() * 1000000); 
			$random = mt_rand ($min,$max);
			return $random;
		}
		
		function rework_name ($name)
		{
			$name = eregi_replace ("_", " ", $name);
			$name_array = explode (" ", $name);
			for ($i = 0; $i < sizeof ($name_array); $i++)
				$name_array [$i] = strtoupper (substr($name_array [$i], 0, 1)) . substr($name_array [$i], 1);
			$name = join (" ", $name_array);
			return $name;
		}
		
		function meter ($number)
		{
			global $gui_obj;
			$string = "<table bgcolor=\"#FFFFFF\" width=\"120px\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr><td>\r\n";
			$string .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"3\" align=\"left\">\r\n";
			$string .= "  <tr bgcolor=\"#000000\">\r\n";
			for ($i = 0; $i < $number; $i++)
				$string .= "    <td><img src=\"".$base_url."images/spacer.gif\" width=\"1px\" height=\"4px\" /></td>\r\n";
			$string .= "  </tr>\r\n";
			$string .= "</table>\r\n";
			$string .= "</td></tr></table>\r\n";
			return $string;
		}
	}
?>
