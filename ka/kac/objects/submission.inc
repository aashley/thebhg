<?php

class Submissions extends KA_1 {

	var $db_table;
	var $id;
	var $bhg_id;
	var $kabal;
	var $event;
	var $submitted;
	var $ip_address;
	var $score;
	var $place;
	var $correct;
	var $answer;
	var $points;
	var $date_deleted;
	var $fields = array();

	function Submissions($id){
		KA_1::KA_1();
		
		$this->id = $id;
		$this->db_table = 'kac_submissions';
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
	
	function GetIPAddress(){
		return $this->ip_address;
	}
	
	function GetHunter(){
		return new Person($this->bhg_id);
	}
	
	function GetKabal(){
		return new Division($this->kabal);
	}
	
	function GetEvent(){
		return new Event($this->event);
	}

	function GetPlace(){
		return $this->place;
	}
	
	function GetScore(){
		return $this->score;
	}
	
	function GetPoints(){
		return $this->points;
	}
	
	function IsGraded(){
		return ($this->GetPlace() != 0);
	}
	
	function IsCorrect(){
		return ($this->correct == 1);
	}
	
	function GetCorrect(){
		return $this->correct;
	}
	
	function GetAwards(){
		if ($this->IsGraded()){
			return $this->GetAward($this->place);
		} else {
			return false;
		}
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
	
	function Dates($method = 'HUMAN', $class = 'submitted'){
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
	
	function DeleteHandler($method = 'DELETE'){
		$error = array();
	    switch($method){
		    case 'DELETE':
			    $time = time();
		    break;
		    
		    case ('UNDELETE' || 'UN'):
				$time = 0;
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
    
    function GetAnswers(){
	    return unserialize(base64_decode($this->answer));
    }
    
}
?>
