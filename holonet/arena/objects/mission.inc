<?php

 Class MissionMaster extends Arena {

     var $mm_id;
     var $mm_bhg_id;
     var $mm_start_date;
     var $mm_end_date;

     function MissionMaster($bhg_id){
        Arena::Arena();

        $sql = "SELECT * FROM `arena_mission` WHERE `bhg_id` = '$bhg_id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'mm_'.$key;
                $this->$key = stripslashes($value);
            }

        }

        $this->SecondBuild();
        
    }

    function GetHunter(){
        return new ROHunter($this->mm_bhg_id);
    }

    function GetStatus(){
        if ($this->mm_bhg_id){
		    if ($this->mm_end_date == 0){
	            return "Current ";
	        } elseif ($this->mm_end_date > 0) {
	            return "Retired ";
	        } 
        }else {
	        return false;
        }
    }
    
    function SecondBuild(){
        $sql = "SELECT SUM(arena_ro_hunters.xp) as xp, SUM(arena_ro_hunters.creds) as credits, FROM arena_ro_hunters, arena_ro WHERE arena_ro.id = arena_ro_hunters.run_on"
                ." AND arena_ro.mbid > 0 AND arena_ro.date_deleted = 0 AND arena_ro.mm = '".$this->mm_id."'";

        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);
        
        echo mysql_error($this->connect);

        $this->creds = $info['credits'];
        $this->xp = $info['xp'];
        
    }

    function GetROs(){
        $sql = "SELECT * FROM `arena_ro` WHERE `mm` = '".$this->mm_id."'";
        $query = mysql_query($sql, $this->connect);

        return mysql_num_rows($query);
    }
    
    function EndTerm(){
	    $sql = "UPDATE `arena_mission` SET `end_date` = '".time()."' WHERE `bhg_id` = '".$this->mm_bhg_id."'";
		
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
 }

?>