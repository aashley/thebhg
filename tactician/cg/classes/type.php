<?php
class CGType {

	var $db_table;
	var $db;
	var $id;
	var $name;
	var $abbr;
	var $desc;
	var $picture;
	var $questions;
	var $team;
	var $answers;
	var $date_deleted;
	var $fields = array();	

	function CGType($id, $db){
		
		$this->id = $id;
		$this->db = $db;
		$this->db_table = 'cg_types';
		$this->UpdateCache();
	}

	function UpdateCache(){
		$sql = "SELECT * FROM `".$this->db_table."` WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->db);
		$info = mysql_fetch_array($query);
		
		foreach ($info as $field=>$val){
			array_push($this->fields, $field);
			$this->$field = $val;
		}
	}

	function GetID(){
		return $this->id;
	}
	
	function GetName(){
		return stripslashes($this->name);
	}
	
	function GetAbbr(){
		return stripslashes($this->abbr);
	}
	
	function GetDesc(){
		return nl2br(stripslashes($this->desc));
	}
	
	function GetEdit(){
		return stripslashes($this->desc);
	}
	
	function HasImage(){
		return ($this->picture == 1);
	}
	
	function IsTeam(){
		return ($this->team == 1);
	}
	
	function GetQuestions(){
		return $this->questions;
	}
	
	function GetAnswers(){
		return $this->answers;
	}
	
	function Deleted($method = 'HUMAN'){
	    switch($method){
		    case 'HUMAN':
			    $date = getdate($this->date_deleted);
	        	$return = $date['mon'].'.'.$date['mday'].'.'.$date['year'].' at '.$date['hours'].':'.$date['minutes'].':'.$date['seconds'];
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
			$query = mysql_query($sql, $this->db);
		
			if ($query){
			    $this->UpdateCache();
		    } else {
			    $this->roster_error = 'Error from Database: '.mysql_error($this->db);
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
	    $query = mysql_query($sql, $this->db);
	    
	    if ($query){
		    $this->UpdateCache();
	    } else {
		    $error[] = 'Error from Database: '.mysql_error($this->db);
	    }
	    
	    $this->roster_error = implode('<br />', $error);
	    
	    $errors = count($error);
        return ($errors ? false : true);
    }
	
}
?>
