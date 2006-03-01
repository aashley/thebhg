<?php

class Event extends KA_1 {

	var $db_table;
	var $id;
	var $round;
	var $type;
	var $start;
	var $end;
	var $content;
	var $graded;
	var $date_deleted;
	var $fields = array();	

	function Event($id){
		KA_1::KA_1();
		
		$this->id = $id;
		$this->db_table = 'kac_events';
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
	
	function GetRound(){
		return new Rounds($this->round);
	}
	
	function GetTypes(){
		return new Type($this->type);
	}
	
	function IsGraded(){
		return ($this->graded == 1);
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
			    foreach ($this->GetSubmissions() as $sub) {
					if (!$sub->DeleteHandler('DELETE')) {
						$error[] = 'Error deleting Submission ('.$sub->GetID().')';
					}
				}
		    break;
		    
		    case ('UNDELETE' || 'UN'):
				$time = 0;
				foreach ($this->GetSubmissions() as $sub) {
					if (!$sub->DeleteHandler('UN')) {
						$error[] = 'Error undeleting Submission ('.$sub->GetID().')';
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
    
    function GetSubmissions($by = '`score` DESC, `submitted` ASC'){
	    $sql = "SELECT * FROM `kac_submissions` WHERE `event` = '".$this->id."' AND `date_deleted` = 0 ORDER BY $by";
	    $query = mysql_query($sql, $this->connect);
	    $output = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $output[] = new Submissions($info['id']);
	    }
	    
	    return $output;
    }
    
    function GetSubmissionsByKabal($kabal){
	    $sql = "SELECT * FROM `kac_submissions` WHERE `event` = '".$this->id."' AND `date_deleted` = 0 AND `place` != 0 AND `kabal` = '$kabal'";
	    $query = mysql_query($sql, $this->connect);
	    $output = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $output[] = new Submissions($info['id']);
	    }
	    
	    return $output;
    }
    
    function GetKabalPoints(){
	    $sql = "SELECT SUM(`points`) as `total`, `kabal` FROM `kac_submissions` WHERE `event` = '".$this->id."' AND `date_deleted` = 0 AND `place` != 0 GROUP BY `kabal` ORDER BY `total` DESC";
	    $query = mysql_query($sql, $this->connect);
	    $kabals = array();
	    
	    while ($info = mysql_fetch_array($query)) {
			$kabals[$info['kabal']] = $info['total'];
		}
		
		arsort($kabals);
		
		return $kabals;
	}
    
    function GetContent(){
	    return unserialize(base64_decode($this->content));
    }

    function CanSubmit($bhg_id, $kabal, $exclude = false){
	    if ($this->IsGraded()){
		    $this->roster_error = 'This event has already been graded.';
		    return false;
	    } else {
		    if ($this->Dates('SYSTEM', 'start') <= time() && $this->Dates('SYSTEM', 'end') >= time()){
			    $sql = "SELECT * FROM `kac_submissions` WHERE `bhg_id` = '$bhg_id' AND `event` = '".$this->id."' AND `date_deleted` = 0";
			    $query = mysql_query($sql, $this->connect);
			    
			    if (mysql_num_rows($query) == 0){
				    $ladder = new Ladder();
				    if ($ladder->CanSubmit($kabal)){
					    return true;
				    } else {
					    $this->roster_error = 'Your Kabal has a Bye for this round or has been eliminated from this KAC.';
				    	return false;
			    	}
			    } else {
				    if (!$exclude){
				    	$this->roster_error = 'You have already submitted an answer for this event.';
			    	}
				    return false;
			    }
		    } else {
			    $this->roster_error = 'You are not here during the specified event times, hence, no go for this event.';
			    return false;
		    }
	    }
    }
    
    function Submit($bhg_id, $kabal, $submitted, $ip_address, $answer){
		$sql = "INSERT INTO `kac_submissions` (`bhg_id`, `kabal`, `event`, `submitted`, `ip_address`, `answer`) VALUES "
				."('$bhg_id', '$kabal', '".$this->id."', '$submitted', '$ip_address', '$answer')";
		$query = mysql_query($sql, $this->connect);
		
		if ($query){
		    $this->UpdateCache();
		    $person = new Person($bhg_id);
		    
		    $round = $this->GetRound();
		    $type = $this->GetTypes();
		    
		    $text = $person->GetName().", you have submitted the following answer to the ".$type->GetName()." event for Round ".$round->GetRoundID();
		    
            $answers = unserialize(base64_decode($answer));
            
            $count = 1;
            
            foreach ($answers as $value){
	            $text .= "\nAnswer ".$count."/".count($answers).": ".stripslashes($value);
            }

            $from = "ka@thebhg.org";
            $subject = "KAC Event Answered";

            $person->SendEmail($from, $subject, $text);
            
            mail('ka@thebhg.org', $subject, $text, "From: ka@thebhg.org\r\nReply-To: unanswered@thebhg.org\r\nX-Mailer: PHP/" . phpversion());
	    } else {
		    $this->roster_error = 'Error from Database: '.mysql_error($this->connect);
	    }
		
		return ($query ? true : false);   
    }
}
?>
