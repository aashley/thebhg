<?php

 Class Commentator extends Arena {

     var $hc_id;
     var $hc_bhg_id;
     var $hc_xp;
     var $hc_creds;
     var $hc_medal;
     var $hc_start_date;
     var $hc_end_date;
     var $creds;
     var $xp;
     var $multiple;
     var $matches;

     function Commentator($bhg_id){
        Arena::Arena();

        $sql = "SELECT * FROM `arena_commentator` WHERE `bhg_id` = '$bhg_id'";
        $query = mysql_query($sql, $this->connect);

        if (mysql_num_rows($query) > 1){
	        $this->multiple = array();
	        while ($info = mysql_fetch_array($query)){
		        $this->multiple[] = "arena_irca_match.hc = '".$info['id']."'";
	        }
	        $this->multiple = '('.implode(' OR ', $this->multiple).')';
        } else {
	        $info = mysql_fetch_array($query);
	        $this->multiple = "arena_irca_match.hc = '".$info['id']."'";
        }
        
        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'hc_'.$key;
                $this->$key = stripslashes($value);
            }

        }
        
        $this->SecondBuild();

    }

    function GetID(){
	    return $this->hc_id;
    }
    
    function GetHunter(){
        return new Person($this->hc_bhg_id);
    }

    function GetStatus(){
        if ($this->hc_bhg_id){
		    if ($this->hc_end_date == 0){
	            return "Current ";
	        } elseif ($this->hc_end_date > 0) {
	            return "Retired ";
	        } 
        }else {
	        return false;
        }
    }
    
    function SecondBuild(){
	    $sql = "SELECT SUM(arena_irca_records.xp) as xp, SUM(arena_irca_records.credits) as credits FROM arena_irca_records, arena_irca_match WHERE "
	    	."arena_irca_match.id = arena_irca_records.match_id AND arena_irca_match.graded > 0 AND arena_irca_match.hc > 0 AND arena_irca_match.date_deleted = 0 AND ".$this->multiple."";

        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);
        
        $this->creds = $info['credits']+$this->hc_creds;
        $this->xp = $info['xp']+$this->hc_xp;
        $this->matches = mysql_num_rows($query);

    }

    function GetMatches(){
        return $this->matches;
    }

    function GetXP(){
        return $this->xp;
    }

    function GetCreds(){
        return $this->creds;
    }
    
    function GetMedals(){
	    return $this->hc_medal;
    }
    
    function EndTerm(){
	    $sql = "UPDATE `arena_commentator` SET `end_date` = '".time()."' WHERE `id` = '".$this->hc_id."'";
		
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
 }

?>