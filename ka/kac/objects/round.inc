<?php

class Rounds extends KA_1 {

	var $db_table;
	var $id;
	var $round_id;
	var $season;
	var $start;
	var $end;
	var $date_deleted;
	var $fields = array();	

	function Rounds($id){
		KA_1::KA_1();
		
		$this->id = $id;
		$this->db_table = 'kac_rounds';
		$this->UpdateCache();
	}

	function UpdateCache(){
		$sql = "SELECT * FROM `".$this->db_table."` WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		$info = mysql_fetch_array($query);
		
		foreach ($info as $field=>$val){
			array_push($this->fields, $field);
			$this->$field = $val;
		}
	}

	function GetID(){
		return $this->id;
	}
	
	function GetRoundID(){
		return $this->round_id;
	}
	
	function GetSeason(){
		return new KAC($this->season);
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
	
	function Deleted($method = 'HUMAN'){
	    switch($method){
		    case 'HUMAN':
			    $date = getdate($this->date_deleted);
	        	$return = date('j F Y \a\t G:i:s T', $this->$class);
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
			    foreach ($this->GetEvents() as $event) {
					if (!$event->DeleteHandler('DELETE')) {
						$error[] = 'Error deleting Event ('.$event->GetID().')';
					}
				}
		    break;
		    
		    case ('UNDELETE' || 'UN'):
				$time = 0;
				foreach ($this->GetEvents() as $event) {
					if (!$event->DeleteHandler('UN')) {
						$error[] = 'Error undeleting Event ('.$event->GetID().')';
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
    
    function AllEvents(){
	    $sql = "SELECT * FROM `kac_events` WHERE `round` = '".$this->id."' AND `graded` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $output = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $output[] = new Event($info['id']);
	    }
	    
	    return $output;
    }
    
    function GetEvents(){
	    $sql = "SELECT * FROM `kac_events` WHERE `round` = '".$this->id."' AND `date_deleted` = 0 AND `graded` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $output = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $output[] = new Event($info['id']);
	    }
	    
	    return $output;
    }
    
    function NormalEvents(){
	    $sql = "SELECT * FROM `kac_events` WHERE `round` = '".$this->id."' AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $output = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $output[] = new Event($info['id']);
	    }
	    
	    return $output;
    }
    
    function GetKabalPoints(){
	    $totals = array();
	    $output = array();
	    
	    foreach ($this->GradedEvents() as $event){
	    	$totals[] = $event->GetKabalPoints();
    	}
    	
    	foreach ($totals as $data){
	    	foreach ($data as $kabal=>$points){
		    	if (isset($output[$kabal])){
			    	$output[$kabal] += $points;
		    	} else {
			    	$output[$kabal] = $points;
		    	}
	    	}
    	}
    	
    	return $output;
    }
    
    function GetOpenEvents(){
	    $sql = "SELECT * FROM `kac_events` WHERE `start` <= UNIX_TIMESTAMP() AND `end` >= UNIX_TIMESTAMP() AND `round` = '".$this->id
	    		."' AND `date_deleted` = 0 AND `graded` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $output = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $output[] = new Event($info['id']);
	    }
	    
	    return $output;
    }
    
    function NeedGrading(){
	    $sql = "SELECT * FROM `kac_events` WHERE `end` <= UNIX_TIMESTAMP() AND `round` = '".$this->id
	    		."' AND `date_deleted` = 0 AND `graded` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $output = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $output[] = new Event($info['id']);
	    }
	    
	    return $output;
    }
    
    function Ungraded(){
	    $sql = "SELECT * FROM `kac_events` WHERE `round` = '".$this->id."' AND `date_deleted` = 0 AND `graded` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $output = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $output[] = new Event($info['id']);
	    }
	    
	    return $output;
    }
    
    function GradedEvents(){
	    $sql = "SELECT * FROM `kac_events` WHERE `round` = '".$this->id."' AND `date_deleted` = 0 AND `graded` = 1";
	    $query = mysql_query($sql, $this->connect);
	    $output = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $output[] = new Event($info['id']);
	    }
	    
	    return $output;
    }
    
    function NewEvent($type, $start, $end, $content){
	    $sql = "SELECT * FROM `kac_events` WHERE `type` = '$type' AND `round` = '".$this->id."' AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->connect);
	    
	    if (mysql_num_rows($query)){
		    $this->roster_error = 'You can not have 2 events of the same type in one round.';
		    return false;
	    } else {
	    
			$sql = "INSERT INTO `kac_events` (`type`, `start`, `end`, `content`, `round`) VALUES ('$type', '$start', '$end', '$content', '".$this->id."')";
			$query = mysql_query($sql, $this->connect);
			
			$this->roster_error = 'Error from Database: '.mysql_error($this->connect);
			
			return ($query ? true : false);   
			
		}
    }
	
}
?>
