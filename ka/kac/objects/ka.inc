<?php
class KA_1 extends BHGObject {
	
	var $connect;
	var $coder;

	function KA_1($coder = '') {
		$this->BHGObject($coder);
		$this->connect = mysql_connect('localhost', 'thebhg_ka', 'bhgkapass');
			mysql_select_db('thebhg_ka', $this->connect);
	}

	function GetSeasons() {
		$sql = 'SELECT * FROM `kacs` WHERE `date_deleted` = 0 ORDER BY `id`';
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$return[] = new KAC($info['id']);
		}
		
		return $return;
	}
	
	function AllSeasons() {
		$sql = 'SELECT * FROM `kacs` ORDER BY `id`';
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$return[] = new KAC($info['id']);
		}
		
		return $return;
	}
	
	function GetTypes() {
		$sql = 'SELECT * FROM `kac_types` WHERE `date_deleted` = 0 ORDER BY `name`';
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$return[] = new Type($info['id'], $this->db);
		}
		
		return $return;
	}
	
	function AllTypes() {
		$sql = 'SELECT * FROM `kac_types` ORDER BY `name`';
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$return[] = new Type($info['id'], $this->db);
		}
		
		return $return;
	}
	
	function AllAwards() {
		$sql = 'SELECT * FROM `kac_awards` ORDER BY `point_high`';
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$return[] = new Awards($info['id']);
		}
		
		return $return;
	}

	function GetKAC($id) {
		$kac = new KAC($id);
		$check = $kac->GetID();
		
		return ($kac->GetSeasonID() ? $kac : false);
	}

	function KACBySeason($id){
		$sql = "SELECT * FROM `kacs` WHERE `season_id` = '$id' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_array($query);
		
		if ($id == $info['season_id']){
			return new KAC($info['id']);
		} else {
			return false;
		}
	}
	
	function KACEvent($id){
		$sql = "SELECT * FROM `kac_types` WHERE (`name` = '".addslashes($id)."' OR `abbr` = '".addslashes($id)."') AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_array($query);
		
		if (mysql_num_rows($query)){
			$type = new Type($info['id']);
			return $type;
		} else {
			return false;
		}
	}
	
	function GetHunterTotals($limit = 0, $kabal = 0){
		$person = array();
		
		if ($limit){
			$limit = "LIMIT ".$limit;
		} else {
			$limit = "";
		}
		
		if ($kabal){
			$kabal = "AND `kabal` = '$kabal'";
		} else {
			$kabal = '';
		}
		
	    $sql = "SELECT SUM(`points`) as `total`, COUNT(DISTINCT id) AS `events`, `bhg_id` FROM `kac_submissions` WHERE `place` != 0 $kabal GROUP BY `bhg_id` ORDER BY `total` DESC $limit";
	    $query = mysql_query($sql, $this->connect);
	    
	    while ($info = mysql_fetch_array($query)) {
		    $guy = new Person($info['bhg_id']);
			$person[$info['bhg_id']] = array('name'=>$guy->GetName(), 'person'=>$guy, 'points'=>$info['total'], 'events'=>$info['events'], 'ptsvt'=>round($info['total']/$info['events']));
		}
		
		arsort($person);
		
		return $person;
	}
	
	function RoundBySeasonID($id, $season){
		$sql = "SELECT * FROM `kac_rounds` WHERE `season` = '$season' AND `round` = '$id' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_array($query);
		
		return new Rounds($info['id']);
	}
	
	function IsEvent($id){
		$sql = "SELECT * FROM `kac_events` WHERE `id` = '$id' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		
		return (mysql_num_rows($query));
	}
	
	function GetEvent($id) {		
		$event = new Event($id);
		$check = $event->GetID();
		
		return ($check ? $event : false);
	}

	function GetNextKAC() {
		$sql = "SELECT * FROM `kacs` WHERE `start` >= UNIX_TIMESTAMP() AND `date_deleted` = 0 ORDER BY `id` ASC LIMIT 1";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_array($query);
		
		return new KAC($info['id']);
	}
	
	function GetNextKACs() {
		$sql = "SELECT * FROM `kacs` WHERE `start` >= UNIX_TIMESTAMP() AND `date_deleted` = 0 ORDER BY `id` ASC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$return[] = new KAC($info['id']);
		}
		
		return $return;
	}
	
	function GetOpenKACs() {
		$sql = "SELECT * FROM `kacs` WHERE `start` <= UNIX_TIMESTAMP() AND `end` >= UNIX_TIMESTAMP() AND `date_deleted` = 0 ORDER BY `id` ASC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$return[] = new KAC($info['id']);
		}
		
		return $return;
	}
	
	function NewKAC($id, $start, $end, $maximum, $minimum, $kabal_count){
		$sql = "SELECT * FROM `kacs` WHERE `season_id` = '$id' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		
		if (mysql_num_rows($query)){
			$this->roster_error = 'There is already a KAC listed with this Season ID.';
			return false;
		}
		
		$sql = "INSERT INTO `kacs` (`season_id`, `start`, `end`, `maximum`, `minimum`, `kabal_count`) VALUES "
				."('$id', '$start', '$end', '$maximum', '$minimum', '$kabal_count')";
		$query = mysql_query($sql, $this->connect);
		
		if (!$query){
			$this->roster_error = 'Error from Database: '.mysql_error($this->connect);
		}
		
		return ($query ? true : false);
	}
	
	function NewEventType($name, $desc, $abbr, $picture, $questions, $answers){
		$sql = "INSERT INTO `kac_types` (`name`, `desc`, `abbr`, `picture`, `questions`, `answers`) VALUES "
				."('".addslashes($name)."', '".addslashes($desc)."', '".addslashes($abbr)."', '$picture', '$questions', '$answers')";
		$query = mysql_query($sql, $this->connect);
		
		if (!$query){
			$this->roster_error = 'Error from Database: '.mysql_error($this->connect);
		}
		
		return ($query ? true : false);
	}
	
	function NewAward($point_high, $point_low, $default_points, $points, $correct, $credits, $medal){
		$sql = "SELECT * FROM `kac_awards` WHERE `point_high` = '$point_high' AND `correct` = '$correct'";
		$query = mysql_query($sql, $this->connect);
		
		if (mysql_num_rows($query)){
			$this->roster_error = 'Adding this award would create an overlap! Ending award add process. Please change your High Point to continue.';
			return false;
		}
		
		$sql = "SELECT * FROM `kac_awards` WHERE `point_low` = '$point_low' AND `correct` = '$correct'";
		$query = mysql_query($sql, $this->connect);
		
		if (mysql_num_rows($query)){
			$this->roster_error = 'Adding this award would create an overlap! Ending award add process. Please change your Low Point to continue.';
			return false;
		}
		
		$sql = "INSERT INTO `kac_awards` (`point_high`, `point_low`, `default_points`, `points`, `correct`, `credits`, `medal`) VALUES "
				."('$point_high', '$point_low', '$default_points', '$points', '$correct', '$credits', '$medal')";
		$query = mysql_query($sql, $this->connect);
		
		if (!$query){
			$this->roster_error = 'Error from Database: '.mysql_error($this->connect);
		}
		
		return ($query ? true : false);
	}
	
	function WinningKabals(){
		$return = array();
        foreach ($this->GetSeasons() as $season){
	        $ladder = new Ladder($season->GetSeasonID());
	        $round = (count($season->GetRounds())+1);
	        if ($ladder->Champion($round)){
		        if (isset($return[$ladder->Champion($round)])){
			        $return[$ladder->Champion($round)]++;
		        } else {
			        $return[$ladder->Champion($round)] = 1;
		        }
	        }
        }
        
        return $return;
    }
	
	function GetKabals($season = 0, $round = 0, $kabal = 0, $deleted = 0, $both = 0){
		$kabals = array();
		
		$delimiter = array();
		
		if (!$both){
			$delimiter[] = "`date_deleted` = $deleted";
		}
		
		if ($kabal){
			$delimiter[] = "`kabal` = '$kabal'";
		}
		
		if (count($delimiter)){
			$addin = 'WHERE '.implode(' AND ', $delimiter);
		}
		
		$sql = "SELECT SUM(`points`) as `total`, `kabal`, `event` FROM `kac_submissions` $addin GROUP BY `kabal` ORDER BY `total` DESC";
		$query = mysql_query($sql, $this->connect);

		$round_check = $round;
		$season_check = $season;
		
	    while ($info = mysql_fetch_array($query)) {
		    $event = new Event($info['event']);
		    
		    $process = false;
		    
		    $round = $event->GetRound();
			if ($round_check){
				if ($round_check == $round->GetID()){
					$season = $round->GetSeason();	
					if ($season_check){
						if ($season_check == $season->GetID()){
							$process = true;
						}
					} else {
						$process = true;
					}
				}
				
			} else {
				$season = $round->GetSeason();	
				if ($season_check){
					if ($season_check == $season->GetID()){
						$process = true;
					}
				} else {
					$process = true;
				}
			}
			
			if ($process){
			    if (isset($kabals[$info['kabal']])){
				    $kabals[$info['kabal']] += $info['total'];
			    } else {
					$kabals[$info['kabal']] = $info['total'];
				}
			}
		}
		
		$kabals = array_unique($kabals);
		
		arsort($kabals);
		
		return $kabals;
	}
	
	function GetHunters($season = 0, $round = 0, $kabal = 0, $deleted = 0, $both = 0){
		$delimiter = array();
		$return = array();
		
		if ($kabal){
			$delimiter[] = "`kabal` = '$kabal'";
		}
		
		if (!$both){
			$delimiter[] = "`date_deleted` = $deleted";
		}
		
		$addin = implode(' AND ', $delimiter);
		
		$sql = "SELECT * FROM `kac_submissions` WHERE $addin";		
		$query = mysql_query($sql, $this->connect);
		
		$round_check = $round;
		$season_check = $season;
		
		while ($info = mysql_fetch_array($query)){
			$event = new Event($info['event']);
			
			$process = false;
			
			$round = $event->GetRound();
			if ($round_check){
				if ($round_check == $round->GetID()){
					$season = $round->GetSeason();	
					if ($season_check){
						if ($season_check == $season->GetID()){
							$process = true;
						}
					} else {
						$process = true;
					}
				}
				
			} else {
				$season = $round->GetSeason();	
				if ($season_check){
					if ($season_check == $season->GetID()){
						$process = true;
					}
				} else {
					$process = true;
				}
			}
			
			if ($process){
				$return[] = $info['bhg_id'];
			}
		}
		
		return array_unique($return);
	}
	
	function Stats($bhg_id, $season = 0, $round = 0, $kabal = 0, $deleted = 0, $both = 0){
		$delimiter = array();
		
		if ($kabal){
			$delimiter[] = "`kabal` = '$kabal'";
		}
		
		if (!$both){
			$delimiter[] = "`date_deleted` = $deleted";
		}
		
		$delimiter[] = "`bhg_id` = '$bhg_id'";
				
		$addin = implode(' AND ', $delimiter);
		
		$sql = "SELECT * FROM `kac_submissions` WHERE $addin";
		$query = mysql_query($sql, $this->connect);
		
		$points = 0;
		$credits = 0;
		$firsts = 0;
		$seconds = 0;
		$thirds = 0;
		$noefforts = 0;
		
		$seasons = array();
		$rounds = array();
		$kabals = array();
		$events = array();
		$places = array();
		$awards = array();
		$point = array();
		
		$round_check = $round;
		$season_check = $season;
		
		while ($info = mysql_fetch_array($query)){
			$event = new Event($info['event']);
			
			$process = false;
			
			$round = $event->GetRound();
			if ($round_check){
				if ($round_check == $round->GetID()){
					$season = $round->GetSeason();	
					if ($season_check){
						if ($season_check == $season->GetID()){
							$process = true;
						}
					} else {
						$process = true;
					}
				}
				
			} else {
				$season = $round->GetSeason();	
				if ($season_check){
					if ($season_check == $season->GetID()){
						$process = true;
					}
				} else {
					$process = true;
				}
			}
			
			if ($process){
				$rounds[] = $round->GetID();
				$seasons[] = $season->GetID();
				$events[] = $event->GetID();
				$places[] = $info['place'];
				
				if ($info['dated_deleted']){
					$noefforts++;
				}
				
				if ($info['place'] == 1){
					$firsts++;
				} elseif ($info['place'] == 2){
					$seconds++;
				} elseif ($info['place'] == 3){
					$thirds++;
				}
				
				if ($info['place'] > -1){
					$award = $this->GetAward($info['place'], 0);
				} else {
					$award = $this->GetAward($info['place'], $info['correct']);
				}		
				
				$awards[] = $award->GetID();			
		
				if (is_object($award)){
					$credits += $award->GetCredits('SYSTEM');
				}
				$points += $info['points'];
				
				$point[] = $info['points'];
				
				$kabals[] = $info['kabal'];
			}
		}
		
		return array('events'=>array_unique($events), 'round'=>array_unique($rounds), 'season'=>array_unique($seasons), 'places'=>$places, 
				'kabals'=>array_unique($kabals), 'points'=>$points, 'credits'=>$credits, '1'=>$firsts, '2'=>$seconds, '3'=>$thirds, 'awards'=>$awards,
				'point'=>$point, 'no_effort'=>$noefforts);
	}
	
	function GetAward($place, $correct){
		$sql = "SELECT * FROM `kac_awards` WHERE `point_high` >= '$place' AND `point_low` <= '$place' AND `correct` = '$correct' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_array($query);
		
		if (mysql_num_rows($query)){
			return new Awards($info['id']);
		} else {
			return false;
		}
	}
	
	function ConditionContent($string){
	    return base64_encode(serialize($string));
    }
    
}
?>
