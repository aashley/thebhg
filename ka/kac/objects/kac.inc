<?php

class KAC extends KA_1 {

	var $db_table;
	var $id;
	var $season_id;
	var $start;
	var $end;
	var $maximum;
	var $minimum;
	var $kabal_count;
	var $graded;
	var $date_deleted;
	var $fields = array();	

	function KAC($id){
		KA_1::KA_1();
		
		$this->id = $id;
		$this->db_table = 'kacs';
		$this->UpdateCache();
	}

	function UpdateCache(){
		$sql = "SELECT * FROM `".$this->db_table."` WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_array($query);
		
		if (is_array($info)){
			foreach ($info as $field=>$val){
				array_push($this->fields, $field);
				$this->$field = $val;
			}
		}
	}

	function GetID(){
		return $this->id;
	}
	
	function GetSeasonID(){
		return $this->season_id;
	}
	
	function Dates($method = 'HUMAN', $class = 'start'){
	    switch($method){
		    case 'HUMAN':
		    	if (isset($this->$class)){
				    $date = getdate($this->$class);
		        	$return = date('j F Y \a\t G:i:s T', $this->$class);
	        	} else {
		        	$this->roster_error = 'Unidentified date passed.';
					return false;
				}
		    break;
		    
		    case 'SYSTEM':
				if (isset($this->$class)){
		        	$return = $this->$class; 
	        	} else {
		        	$this->roster_error = 'Unidentified date passed.';
					return false;
				}
			break;
			
			default:
				$this->roster_error = 'Unidentified flag passed.';
				return false;
			break;
		}
		
        return $return;
    }

	function GetMaximum($frmt = false){
		return ($frmt ? ($this->maximum)-1 : $this->maximum);
	}

	function GetMinimum($frmt = false){
		return ($frmt ? ($this->minimum)-1 : $this->minimum);
	}
	
	function GetKabalCount(){
		return $this->kabal_count;
	}
	
	function IsGraded(){
		return ($this->graded == 1);
	}
	
	function Deleted($method = 'HUMAN'){
	    switch($method){
		    case 'HUMAN':
			    $date = getdate($this->date_deleted);
	        	$return = $return = date('j F Y \a\t G:i:s T', $this->$class);
		    break;
		    
		    case 'SYSTEM':
				$return = $this->date_deleted;
			break;
			
			case 'CHECK':
				$return = ($this->date_deleted == 0);
			break;
			
			default:
				$this->roster_error = 'Unidentified flag passed.';
				return false;
			break;
		}
		
        return $return;
    }

	function SetPiece($table, $value){
		if (in_array($table, $this->fields)){
			$sql = "UPDATE `".$this->db_table."` SET `$table` = '$value' WHERE `id` = '".$this->id."'";
			$query = mysql_query($sql, $this->connect);
		
			if ($query){
			    $this->UpdateCache();
		    } else {
			    $this->roster_error = 'Error from Database: '.mysql_error($this->connect);
		    }
		
			return ($query ? true : false);
		} else {
			$this->roster_error = 'Field ($table) does not exist.';
			return false;
		}
	}
	
	function DeleteHandler($method = 'DELETE'){
		$error = array();
	    switch($method){
		    case 'DELETE':
			    $time = time();
			    foreach ($this->GetRounds() as $round) {
					if (!$round->DeleteHandler('DELETE')) {
						$error[] = 'Error deleting Round ('.$round->GetID().')';
					}
				}
		    break;
		    
		    case ('UNDELETE' || 'UN'):
				$time = 0;
				foreach ($this->GetRounds() as $round) {
					if (!$round->DeleteHandler('UN')) {
						$error[] = 'Error undeleting Round ('.$round->GetID().')';
					}
				}
			break;
			
			default:
				$this->roster_error = 'Unidentified flag passed.';
				return false;
			break;
		}
		
	    $sql = "UPDATE `".$this->db_table."` SET `date_deleted` = '$time' WHERE `id` = '".$this->id."'";
	    $query = mysql_query($sql, $this->connect);
	    
	    if ($query){
		    $this->UpdateCache();
	    } else {
		    $error[] = 'Error from Database: '.mysql_error($this->connect);
	    }
	    
	    $this->roster_error = implode('<br />', $error);
	    
	    $errors = count($error);
        return ($errors ? false : true);
    }
    
    function AllRounds(){
	    $sql = "SELECT * FROM `kac_rounds` WHERE `season` = '".$this->id."'";
	    $query = mysql_query($sql, $this->connect);
	    $output = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $output[] = new Rounds($info['id']);
	    }
	    
	    return $output;
    }
    
    function RoundByID($id){
	    $sql = "SELECT * FROM `kac_rounds` WHERE `season` = '".$this->id."' AND `round_id` = '$id'";
	    $query = mysql_query($sql, $this->connect);
	    $info = mysql_fetch_array($query);
	    
	    return new Rounds($info['id']);;
    }
    
    function EventByType($id){
	    $return = array();
	    foreach ($this->GetRounds() as $rounds){
		    $round = $rounds->GetID();
			$sql = "SELECT * FROM `kac_events` WHERE `type` = '$id' AND `date_deleted` = '0' AND `round` = $round";
			$query = mysql_query($sql, $this->connect);
			$info = mysql_fetch_array($query);

			if ($id == $info['type']){
				$return[] = new Event($info['id']);
			}
		}
		return $return;
	}
    
    function ClosedRounds(){
	    $sql = "SELECT * FROM `kac_rounds` WHERE `end` <= UNIX_TIMESTAMP() AND `season` = '".$this->id."' AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $output = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $output[] = new Rounds($info['id']);
	    }
	    
	    return $output;
    }
    
    function OpenRounds(){
	    $sql = "SELECT * FROM `kac_rounds` WHERE `start` >= UNIX_TIMESTAMP() AND `season` = '".$this->id."' AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $output = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $output[] = new Rounds($info['id']);
	    }
	    
	    return $output;
    }
    
    function GetRounds(){
	    $sql = "SELECT * FROM `kac_rounds` WHERE `season` = '".$this->id."' AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $output = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $output[] = new Rounds($info['id']);
	    }
	    
	    return $output;
    }
    
    function GetOpenRounds(){
	    $sql = "SELECT * FROM `kac_rounds` WHERE `start` <= UNIX_TIMESTAMP() AND `end` >= UNIX_TIMESTAMP() AND `season` = '".$this->id
	    		."' AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $output = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $output[] = new Rounds($info['id']);
	    }
	    
	    return $output;
    }
    
    function KagInterface(){			
	    $sql = 'SELECT SUM(`points`) AS `total`, `kabal` FROM `kag_signups` WHERE `kag` = ' . $this->season_id . ' GROUP BY `kabal` ORDER BY `total` DESC';
		$query = mysql_query($sql, $this->connect);
		$kabals = array();
		
		while ($info = mysql_fetch_array($query)) {
			$kabals[$info['total']] = $info['kabal'];
		}
		
		$kabals = array_unique($kabals);
		
		arsort($kabals);
		
		return $kabals;
	}
	
	function GetHunterTotals($limit = 0){
		$person = array();
		
		if ($limit){
			$limit = "LIMIT ".$limit;
		} else {
			$limit = "";
		}
		
		$event = array();
		
		foreach ($this->GetRounds() as $round){
			foreach ($round->GradedEvents() as $events){
				$event[] = $events->GetID();
			}
		}
		if (count($event)){
			$sql = "SELECT SUM(`points`) as `total`, COUNT(DISTINCT id) AS `events`, `kabal`, `bhg_id` FROM `kac_submissions` WHERE `event` IN (".implode(', ', $event).") AND `date_deleted` = 0 AND `place` != 0 GROUP BY `bhg_id` ORDER BY `total` DESC $limit";
		    $query = mysql_query($sql, $this->connect);
	
		    echo mysql_error($this->connect);
		    
		    while ($info = mysql_fetch_array($query)) {
				$guy = new Person($info['bhg_id']);
				$kabal = new Kabal($info['kabal']);
				$season = new KAC($this->id);
				$person[$info['bhg_id']] = array('name'=>$guy->GetName(), 'person'=>$guy, 'season'=>$season, 'points'=>$info['total'], 'kabal'=>$kabal, 'events'=>$info['events'], 'ptsvt'=>round($info['total']/$info['events']));
			}
		
			return $person;
		} 
		
		return array();
	}
	
	function GetKabalTotals(){
		$kabals = array();
		
		foreach ($this->GetRounds() as $round){
			foreach ($round->GradedEvents() as $events){
				$event = $events->GetID();
			    $sql = "SELECT SUM(`points`) as `total`, `kabal` FROM `kac_submissions` WHERE `event` = '$event' AND `date_deleted` = 0 AND `place` != 0 GROUP BY `kabal` ORDER BY `total` DESC";
			    $query = mysql_query($sql, $this->connect);
			    
			    while ($info = mysql_fetch_array($query)) {
				    if (isset($kabals[$info['kabal']])){
					    $kabals[$info['kabal']] += $info['total'];
				    } else {
						$kabals[$info['kabal']] = $info['total'];
					}
				}
			}
		}
		
		$kabals = array_unique($kabals);
		
		arsort($kabals);
		
		return $kabals;
	}
	
	function NewRound($round_id, $start, $end){
		$sql = "INSERT INTO `kac_rounds` (`round_id`, `start`, `end`, `season`) VALUES ('$round_id', '$start', '$end', '".$this->id."')";
		$query = mysql_query($sql, $this->connect);
		
		$this->roster_error = 'Error from Database: '.mysql_error($this->connect);
		
		return ($query ? true : false);   
    }
}
?>
