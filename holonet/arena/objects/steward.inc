<?php

 Class Steward extends Arena {

     var $stew_id;
     var $stew_bhg_id;
     var $stew_xp;
     var $stew_creds;
     var $stew_medal;
     var $stew_start_date;
     var $stew_end_date;
     var $creds;
     var $xp;

     function Steward($bhg_id){
        Arena::Arena();

        $sql = "SELECT * FROM `arena_stewards` WHERE `bhg_id` = '$bhg_id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'stew_'.$key;
                $this->$key = stripslashes($value);
            }

        }
        
        $this->SecondBuild();

    }

    function GetID(){
	    return $this->stew_id;
    }
    
    function GetHunter(){
        return new Person($this->stew_bhg_id);
    }

    function GetStatus(){
        if ($this->stew_bhg_id){
		    if ($this->stew_end_date == 0){
	            return "Current ";
	        } elseif ($this->stew_end_date > 0) {
	            return "Retired ";
	        } 
        }else {
	        return false;
        }
    }
    
    function SecondBuild(){
	    $sql = "SELECT SUM(arena_ladder_records.xp) as xp, SUM(arena_ladder_records.credits) as credits FROM arena_ladder_records, arena_ladder_match WHERE arena_ladder_match.accepted = 1 "
                ."AND arena_ladder_match.id = arena_ladder_records.match_id AND arena_ladder_match.match_id > 0 AND arena_ladder_match.steward > 0 AND arena_ladder_match.date_deleted = 0 AND arena_ladder_match.steward = '".$this->stew_id."'";

        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        $this->creds = $info['credits'];
        $this->xp = $info['xp'];

    }

    function GetMatches(){
        $sql = "SELECT * FROM `arena_ladder_match` WHERE `steward` = '".$this->stew_id."' AND `match_id` > 0 AND `date_deleted` = 0 AND `accepted` = 1";
        $query = mysql_query($sql, $this->connect);
        
        return mysql_num_rows($query);
    }

    function GetXP(){
        return $this->xp;
    }

    function GetCreds(){
        return $this->creds;
    }
    
    function GetMedals(){
	    return $this->stew_medal;
    }
    
    function EndTerm(){
	    $sql = "UPDATE `arena_stewards` SET `end_date` = '".time()."' WHERE `bhg_id` = '".$this->stew_bhg_id."'";
		
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
 }

?>