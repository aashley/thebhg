<?php

 Class Skipper extends Arena {

     var $skip_id;
     var $skip_bhg_id;
     var $skip_xp;
     var $skip_creds;
     var $skip_medal;
     var $skip_start_date;
     var $skip_end_date;
     var $creds;
     var $xp;

     function Skipper($bhg_id){
        Arena::Arena();

        $sql = "SELECT * FROM `arena_skippers` WHERE `bhg_id` = '$bhg_id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'skip_'.$key;
                $this->$key = stripslashes($value);
            }

        }
        
        $this->SecondBuild();

    }

    function GetID(){
	    return $this->skip_id;
    }
    
    function GetHunter(){
        return new Person($this->skip_bhg_id);
    }

    function GetStatus(){
        if ($this->skip_bhg_id){
		    if ($this->skip_end_date == 0){
	            return "Current ";
	        } elseif ($this->skip_end_date > 0) {
	            return "Retired ";
	        } 
        }else {
	        return false;
        }
    }
    
    function SecondBuild(){
	    $sql = "SELECT SUM(arena_starfield_records.xp) as xp, SUM(arena_starfield_records.credits) as credits FROM arena_starfield_records, arena_starfield_match WHERE arena_starfield_match.accepted = 1 "
                ."AND arena_starfield_match.id = arena_starfield_records.match_id AND arena_starfield_match.match_id > 0 AND arena_starfield_match.skipper > 0 AND arena_starfield_match.date_deleted = 0 AND arena_starfield_match.skipper = '".$this->skip_id."'";

        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        $this->creds = $info['credits']+$this->skip_creds;
        $this->xp = $info['xp']+$this->skip_xp;

    }

    function GetMatches(){
        $sql = "SELECT * FROM `arena_starfield_match` WHERE `skipper` = '".$this->skip_id."' AND `match_id` > 0 AND `date_deleted` = 0 AND `accepted` = 1";
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
	    return $this->skip_medal;
    }
    
    function EndTerm(){
	    $sql = "UPDATE `arena_skippers` SET `end_date` = '".time()."' WHERE `bhg_id` = '".$this->skip_bhg_id."'";
		
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
 }

?>