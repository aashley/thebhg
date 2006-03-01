<?php

class Podracer extends Roster {

	var $connect;

    function Podracer() {   
		$this->connect = mysql_connect('localhost', 'thebhg_executor', 'ecd5786b');
			mysql_select_db('thebhg_executor', $this->connect);
    }

	function CreateTeam($name, $credits, $leader, $slogan, $url, $image) {
		$sql = "INSERT INTO `podracer_teams` (`name`, `credits`, `leader`, `slogan`, `url`, `image`) values ('".addslashes($name)."', '$credits', '$leader', '"
		.addslashes($slogan)."', '".addslashes($url)."', '".addslashes($image)."')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? new Team(mysql_insert_id($this->connect)) : false);
	}
	
	function CreateCategory($name) {
		$sql = "INSERT INTO `podracer_junkyard_categories` (`name`) values ('".addslashes($name)."')";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? mysql_insert_id($this->connect) : false);
	}
	
	function EditCateory($id, $name){
		$sql = "UPDATE `podracer_junkyard_categories` SET `name` = '".$name."' WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function DeleteCategory($id){
		$sql = "UPDATE `podracer_junkyard_categories` SET `date_deleted` = '".time()."' where `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function GetCategories(){
		$sql = "SELECT * FROM `podracer_junkyard_categories` WHERE `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		while ($info = mysql_fetch_assoc($query)){
			$return[$info['id']] = str_replace("\\", "", $info['name']);
		}
		return $return;
	}
	
	function CreateTeamMember($bhg_id, $team) {
		$sql = "INSERT INTO `podracer_team_members` (`bhg_id`, `team`) values ('$bhg_id', '$team')";
		$result = mysql_query($sql, $this->connect);
		
		return ($query ? new TeamMember(mysql_insert_id($this->connect)) : false);
	}
	
	function FindTeamMember($bhg_id) {
		$sql = "SELECT `id` FROM `podracer_team_members` WHERE `bhg_id` = '$bhg_id' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		if (mysql_num_rows($query) > 0) {
			$info = mysql_fetch_array($query);
			return new TeamMember($info['id']);
		} else {
			return 0;
		}
	}
	
	function FindByReg($time) {
		$sql = "SELECT `id` FROM `podracer_races` WHERE `reg_date` = '$time' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		if (mysql_num_rows($query) > 0) {
			$info = mysql_fetch_array($query);
			return new Race($info['id']);
		} else {
			return new Race(0);
		}
	}
	
	function FindByRun($time) {
		$sql = "SELECT `id` FROM `podracer_races` WHERE `date` = '$time' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		if (mysql_num_rows($query) > 0) {
			$info = mysql_fetch_array($query);
			return new Race($info['id']);
		} else {
			return new Race(0);
		}
	}

	function CreateRace($course, $name, $date, $reg_date, $base_reward, $pod_limit, $skill_level, $laps, $buyin) {
		$sql = "INSERT INTO `podracer_races` (`course`, `name`, `date`, `reg_date`, `base_reward`, `pod_limit`, `skill_level`, `laps`, `buyin`) values ('$course', '".addslashes($name)."', '$date', '$reg_date', '$base_reward', '$pod_limit', '$skill_level', '$laps', '$buyin')";
		$query = mysql_query($sql, $this->connect);

		return ($query ? new Race(mysql_insert_id($this->connect)) : false);
	}
	
	function CreateRaceResult($reg, $place, $winnings) {
		$sql = "SELECT * FROM `podracer_race_results` WHERE `registration` = '$reg'";
		$query = mysql_query($sql, $this->connect);
		if (mysql_num_rows($query) > 0) {
			$sql = "DELETE FROM `podracer_race_results` WHERE `registration` = '$reg'";
			mysql_query($sql, $this->connect);
		}
			
		$sql = "INSERT INTO `podracer_race_results` (`registration`, `place`, `winnings`) values ('$reg', '$place', '$winnings')";
		$query = mysql_query($sql, $this->connect);

		return ($query ? new RaceResult(mysql_insert_id($this->connect)) : false);
	}
	
	function CreateRaceRegistration($race, $pod) {
		$sql = "INSERT INTO podracer_race_registrations (race, pod) values ($race, $pod)";
		$query = mysql_query($sql, $this->connect);

		return ($query ? new RaceRegistration(mysql_insert_id($this->connect)) : false);
	}
	
	function CreatePod($name, $cat, $sale, $num, $description, $cost, $traction, $turning, $acceleration, $top_speed, $air_brake, $cooling, $repair) {
		$sql = "INSERT INTO `podracer_pod_types` (`name`, `cat`, `forsale`, `num`, `description`, `cost`, `traction`, `turning`, `acceleration`, `top_speed`, `air_brake`, `cooling`".
		", `repair`) values ('".addslashes($name)."', '$cat', '$sale', '$num', '".addslashes($description)."', '$cost', '$traction', '$turning', '$acceleration', '$top_speed', '$air_brake', '$cooling', '$repair')";
		$query = mysql_query($sql, $this->connect);

		return ($query ? new Pod(mysql_insert_id($this->connect)) : false);
	}

	function CreatePartType($name, $updates, $description) {
		$sql = "INSERT INTO `podracer_part_types` (`name`, `updates`, `description`) values ('".addslashes($name)."', '".addslashes($updates)."','".addslashes($description)."')";
		$query = mysql_query($sql, $this->connect);

		return ($query ? new PartType(mysql_insert_id($this->connect)) : false);
	}
	
	function CreatePart($type, $sale, $name, $description, $cost, $limit, $increase) {
		$sql = "INSERT INTO `podracer_parts` (`type`, `forsale`, `name`, `description`, `cost`, `part_limit`, `increase`) values ('$type', '$sale', '".addslashes($name)."', '".addslashes($description)
		."', '$cost', '$limit', '".addslashes(serialize($increase))."')";
		$query = mysql_query($sql, $this->connect);

		return ($query ? new Part(mysql_insert_id($this->connect)) : false);
	}	
	
	function CreateOwnedPod($type, $team, $name) {
		$sql = "INSERT INTO `podracer_owned_pods` (`type`, `team`, `name`) values ('$type', '$team', '".addslashes($name)."')";
		$query = mysql_query($sql, $this->connect);

		return ($query ? new OwnedPod(mysql_insert_id($this->connect)) : false);
	}
	
	function CreateOwnedPart($part, $pod) {
		$sql = "INSERT INTO `podracer_owned_parts` (`part`, `pod`) values ('$part', '$pod')";
		$query = mysql_query($sql, $this->connect);

		return ($query ? new OwnedPart(mysql_insert_id($this->connect)) : false);
	}
	
	function CreateCourse($name, $description, $traction, $turning, $accel, $top_speed, $air_brake, $cooling, $repair) {
		$sql = "INSERT INTO `podracer_courses` (`name`, `description`, `traction`, `turning`, `acceleration`, `top_speed`, `air_brake`, `cooling`, `repair`) values ('".addslashes($name)."', '".addslashes($description)."', '$traction', '$turning', '$accel', '$top_speed', '$air_brake', '$cooling', '$repair')";
		$query = mysql_query($sql, $this->connect);

		return ($query ? new Course(mysql_insert_id($this->connect)) : false);
	}
	
	function CreateBet($bhg_id, $pod, $race, $amount, $voucher) {
		$sql = "INSERT INTO `podracer_bets` (`bhg_id`, `pod`, `race`, `amount`, `voucher`) values ('$bhg_id', '$pod', '$race', '$amount', '$voucher')";
		$query = mysql_query($sql, $this->connect);

		return ($query ? new Bet(mysql_insert_id($this->connect)) : false);
	}
	
	function FirePilots($race){
		$sql = "SELECT * FROM `podracer_parts` WHERE `type` = '14' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		$get = array();
		
		while ($info = mysql_fetch_assoc($query)){
			$get[] = $info['id'];
		}
		
		$sql = "SELECT * FROM `podracer_race_registrations` WHERE `race` = '$race' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);

		while ($info = mysql_fetch_assoc($query)){
			$sql = "UPDATE `podracer_owned_parts` SET `date_deleted` = '".time()."' WHERE `pod` = '".$info['pod']."' AND `part` IN (".implode(", ", $get).")";
			mysql_query($sql, $this->connect);
		}
	}
	
	function RuRa($pod, $race, $my_total_points) {		
  		$sql = "SELECT * FROM `podracer_race_registrations` WHERE `race` = ".$race->getID()." AND `dropout` = 1 AND `pod` <> ".$pod->getID()." AND (`total_points` > ".($my_total_points - 10)." AND `total_points` < ".($my_total_points + 10).")";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		while ($info = mysql_fetch_array($query)) {
			$return[] = new RaceRegistration($info['id']);
		}
		
		return $return;
	}
	
	function ListTeams() {		
  		$sql = "SELECT `id` FROM `podracer_teams` WHERE `date_deleted` = 0 ORDER BY `name` ASC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$return[] = new Team($info['id']);
		}
		
		return $return;
	}
	
	function ListTeamsMembers() {		
  		$sql = "SELECT `id` FROM `podracer_team_members` WHERE `date_deleted` = 0 ORDER BY `bhg_id` ASC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$return[] = new TeamMember($info['id']);
		}
		
		return $return;
	}

	function ListPods($cat = 0) {		
  		$sql = "SELECT `id` FROM `podracer_pod_types` WHERE ".($cat ? "`cat` = '$cat' AND " : "")."`date_deleted` = 0 ORDER BY `name` ASC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$return[] = new Pod($info['id']);
		}
		
		return $return;
	}
	
	function GetRaceReg($pod, $race) {		
  		$sql = "SELECT `id` FROM `podracer_race_registrations` WHERE `pod` = '".$pod->getID()."' AND `race` = '".$race->GetID()."'";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_array($query);
		
		return new RaceRegistration($info['id']);
	}
	
	function ListParts($cat = 0) {		
  		$sql = "SELECT `id` FROM `podracer_parts` WHERE ".($cat ? "`type` = '$cat' AND " : "")."`date_deleted` = 0 ORDER BY `type` ASC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$return[] = new Part($info['id']);
		}
		
		return $return;
	}
	
	function ListPartTypes() {		
  		$sql = "SELECT `id` FROM `podracer_part_types` WHERE `date_deleted` = 0 ORDER BY `name` ASC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$return[] = new PartType($info['id']);
		}
		
		return $return;
	}
	
	function ListCourses() {		
  		$sql = "SELECT `id` FROM `podracer_courses` WHERE `date_deleted` = 0 ORDER BY `name` ASC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$return[] = new Course($info['id']);
		}
		
		return $return;
	}
	
	function ListRaces() {		
  		$sql = "SELECT `id` FROM `podracer_races` WHERE `date_deleted` = 0 ORDER BY `id` ASC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$return[] = new Race($info['id']);
		}
		
		return $return;
	}
	
	function ListUpcomingRaces() {		
  		$sql = "SELECT `id` FROM `podracer_races` WHERE `date_deleted` = 0 AND `has_run` = 0 ORDER BY `date` ASC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$return[] = new Race($info['id']);
		}
		
		return $return;
	}
	
	function ListRaceRegistrations($show) {		
  		$sql = "SELECT `id` FROM `podracer_race_registrations` WHERE `date_deleted` = 0 ".($show ? 'AND `dropout` = 0' : '')." ORDER BY `id` ASC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$return[] = new RaceRegistration($info['id']);
		}
		
		return $return;
	}
	
	function NumTeamRegistrations($race, $teamd) {		
  		$sql = "SELECT `id` FROM `podracer_race_registrations` WHERE `race` = '$race' AND `date_deleted` = 0 AND `dropout` = 0 ORDER BY `id` ASC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$race = new RaceRegistration($info['id']);
			$team = $race->GetTeam();
			if (!in_array($team->GetID(), $return)){
				$return[$team->GetID()] = 0;
			}
			$return[$team->GetID()]++;
		}
		
		return $return[$teamd];
	}
	
	function ListRaceResults() {		
  		$sql = "SELECT `id` FROM `podracer_race_results` WHERE `date_deleted` = 0 ORDER BY `id` ASC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$return[] = new RaceResult($info['id']);
		}
		
		return $return;
	}
	
	function ListOwnedPods($type = 0) {		
  		$sql = "SELECT `id` FROM `podracer_owned_pods` WHERE ".($type ? "`type` = '$type' AND " : '')."`date_deleted` = 0 ORDER BY `id` ASC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$return[] = new OwnedPod($info['id']);
		}
		
		return $return;
	}
	
	function ListOwnedParts($type = 0) {		
  		$sql = "SELECT `id` FROM `podracer_owned_parts` WHERE ".($type ? "`part` = '$type' AND " : '')."`date_deleted` = 0 ORDER BY `id` ASC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$return[] = new OwnedPart($info['id']);
		}
		
		return $return;
	}
	
	function InTeam($bhg_id) {		
  		$sql = "SELECT * FROM `podracer_team_members` WHERE `date_deleted` = 0 AND `bhg_id` = '$bhg_id'";
		$query = mysql_query($sql, $this->connect);
		
		return mysql_num_rows($query);
	}
	
	function ListBets($bhg_id) {		
  		$sql = "SELECT `id` FROM `podracer_bets` WHERE `date_deleted` = 0 AND `bhg_id` = '$bhg_id' ORDER BY `id` ASC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$return[] = new Bet($info['id']);
		}
		
		return $return;
	}
	
	function ListBet($id = 0) {		
  		$sql = "SELECT `id` FROM `podracer_bets` WHERE `date_deleted` = 0 ".($id ? "AND `race` = '$id'" : "")." ORDER BY `id` ASC";
		$query = mysql_query($sql, $this->connect);
		$return = array();

		while ($info = mysql_fetch_array($query)) {
			$return[] = new Bet($info['id']);
		}
		
		return $return;
	}
	
	function Random($min, $max) {		
  		return mt_rand($min, $max);
	}
	
	function ReworkName($name) {
		$return = explode(" ", eregi_replace ("_", " ", $name));
		for ($i = 0; $i < sizeof($name_array); $i++) {
			$return[$i] = strtoupper(substr($return[$i], 0, 1)) . substr($return[$i], 1);
		}
		return join (" ", $return);
	}
	
	function Meter($number) {
		if ($number > 10){
			$number = 10;
		}
		if ($number < -10){
			$number = -10;
		}
		$string = "<table bgcolor=\"#FFFFFF\" width=\"120px\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr><td>\r\n";
		$string .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"3\" align=\"left\">\r\n";
		$string .= "  <tr bgcolor=\"#000000\">\r\n<img src='images/stats/end.png'>";
		if ($number < 0){
			$string .= str_repeat("<img src='images/stats/spacer.png'>", (10+$number));
			$string .= str_repeat("<img src='images/stats/redbar.png'>", (-1*$number));
			$string .= "<img src='images/stats/blackbar.png'>";
			$string .= str_repeat("<img src='images/stats/spacer.png'>", 10);
		} else {
			$string .= str_repeat("<img src='images/stats/spacer.png'>", 10);
			$string .= "<img src='images/stats/blackbar.png'>";
			$string .= str_repeat("<img src='images/stats/greenbar.png'>", $number);
			$string .= str_repeat("<img src='images/stats/spacer.png'>", (10-$number));						
		}
		$string .= "<img src='images/stats/end.png'></tr>\r\n";
		$string .= "</table>\r\n";
		$string .= "</td></tr></table>\r\n";
		return $string;
	}
	
	function pmeter($number) {
		if ($number > 25){
			$number = 25;
		}
		if ($number < -10){
			$number = -10;
		}
		$number = round($number);
		$string = "<table bgcolor=\"#FFFFFF\" width=\"120px\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr><td>\r\n";
		$string .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"3\" align=\"left\">\r\n";
		$string .= "  <tr bgcolor=\"#000000\">\r\n<img src='images/stats/end.png'>";
		if ($number < 0){
			$string .= str_repeat("<img src='images/stats/spacer.png'>", (10+$number));
			$string .= str_repeat("<img src='images/stats/redbar.png'>", (-1*$number));
			$string .= "<img src='images/stats/blackbar.png'>";
			$string .= str_repeat("<img src='images/stats/spacer.png'>", 25);
		} else {
			$string .= str_repeat("<img src='images/stats/spacer.png'>", 10);
			$string .= "<img src='images/stats/blackbar.png'>";
			$string .= str_repeat("<img src='images/stats/greenbar.png'>", $number);
			$string .= str_repeat("<img src='images/stats/spacer.png'>", (25-$number));						
		}
		$string .= "<img src='images/stats/end.png'></tr>\r\n";
		$string .= "</table>\r\n";
		$string .= "</td></tr></table>\r\n";
		return $string;
	}
}
?>