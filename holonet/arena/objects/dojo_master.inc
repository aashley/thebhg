<?php

 Class Master extends Arena {

     var $dojo_id;
     var $dojo_bhg_id;
     var $dojo_xp;
     var $dojo_creds;
     var $dojo_medal;
     var $dojo_start_date;
     var $dojo_end_date;
     var $creds;
     var $xp;

     function Master($bhg_id){
        Arena::Arena();

        $sql = "SELECT * FROM `arena_dojo_masters` WHERE `bhg_id` = '$bhg_id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'dojo_'.$key;
                $this->$key = stripslashes($value);
            }

        }
        
        $this->SecondBuild();

    }

    function GetID(){
	    return $this->dojo_id;
    }
    
    function GetHunter(){
        return new Person($this->dojo_bhg_id);
    }

    function GetStatus(){
        if ($this->dojo_bhg_id){
		    if ($this->dojo_end_date == 0){
	            return "Current ";
	        } elseif ($this->dojo_end_date > 0) {
	            return "Retired ";
	        } 
        }else {
	        return false;
        }
    }
    
    function SecondBuild(){
	    $sql = "SELECT SUM(arena_ladder_records.xp) as xp, SUM(arena_ladder_records.credits) as credits FROM arena_ladder_records, arena_ladder_match WHERE arena_ladder_match.accepted = 1 "
                ."AND arena_ladder_match.id = arena_ladder_records.match_id AND arena_ladder_match.match_id > 0 AND arena_ladder_match.is_dojo > 0 AND arena_ladder_match.date_deleted = 0 AND arena_ladder_match.is_dojo = '".$this->dojo_id."'";

        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        $this->creds = $info['credits']+$this->dojo_creds;
        $this->xp = $info['xp']+$this->dojo_xp;

    }

    function GetMatches(){
        $sql = "SELECT * FROM `arena_ladder_match` WHERE `is_dojo` = '".$this->dojo_id."'";
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
	    return $this->dojo_medal;
    }
    
    function EndTerm(){
	    $sql = "UPDATE `arena_dojo_masters` SET `end_date` = '".time()."' WHERE `bhg_id` = '".$this->dojo_bhg_id."'";
		
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
 }

?>