<?php

class Awards extends KA_1 {

	var $db_table;
	var $place;
	var $id;
	var $point_high;
	var $point_low;
	var $default_points;
	var $points;
	var $correct;
	var $credits;
	var $medal;
	var $date_deleted;
	var $fields = array();

	function Awards($id){
		KA_1::KA_1();
		
		$this->id = $id;
		$this->db_table = 'kac_awards';
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
	
	function GetPlace(){
		return $this->place;
	}
	
	function GetHigh(){
		return $this->point_high;
	}
	
	function GetLow(){
		return $this->point_low;
	}
	
	function UsesDefault(){
		return ($this->default_points == 1);
	}
	
	function GetPoints(){
		return $this->points;
	}
	
	function IsCorrect(){
		return ($this->correct == 1);
	}
	
	function HasMedal(){
		return ($this->medal > 0);
	}
	
	function GetMedal(){
		if ($this->HasMedal()){
			return new MedalGroup($this->medal);
		} else {
			return false;
		}
	}
	
	function GetCredits($method = 'HUMAN'){
	    switch($method){
		    case 'HUMAN':
		    	$return = number_format($this->credits);
		    break;
		    
		    case 'SYSTEM':
				$return = $this->credits;
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
    
}
?>
