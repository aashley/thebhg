<?php

 Class Overseer extends Arena {

     var $ov_id;
     var $ov_bhg_id;
     var $ov_xp;
     var $ov_creds;
     var $ov_medal;
     var $ov_start_date;
     var $ov_end_date;
     var $ovs_creds = 0;
     var $ovs_xp = 0;
     var $ovs_medal = 0;

     function Overseer($bhg_id){
        Arena::Arena();

        $sql = "SELECT * FROM `arena_overseer` WHERE `bhg_id` = '$bhg_id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'ov_'.$key;
                $this->$key = stripslashes($value);
            }

        }
        
        $this->SecondBuild();

    }
    
    function SecondBuild(){
	    $sqls = array();
	    $sqls[] = "SELECT SUM(arena_ladder_records.xp) as xp, SUM(arena_ladder_records.credits) as credits FROM arena_ladder_records, arena_ladder_match WHERE arena_ladder_match.accepted = 1 "
                ."AND arena_ladder_match.id = arena_ladder_records.match_id AND arena_ladder_match.match_id > 0 AND arena_ladder_match.date_deleted = 0 ".($this->ov_end_date ? "AND arena_ladder_match.start <= '".$this->ov_end_date."'" : "");
        
        $sqls[] = "SELECT SUM(arena_starfield_records.xp) as xp, SUM(arena_starfield_records.credits) as credits FROM arena_starfield_records, arena_starfield_match WHERE arena_starfield_match.accepted = 1 "
                ."AND arena_starfield_match.id = arena_starfield_records.match_id AND arena_starfield_match.match_id > 0 AND arena_starfield_match.date_deleted = 0 ".($this->ov_end_date ? "AND arena_starfield_match.start <= '".$this->ov_end_date."'" : "");
        
        $sqls[] = "SELECT SUM(xp) as xp, "
                ."SUM(creds) as credits "
                ."FROM `arena_solo_contracts` ".($this->ov_end_date ? "WHERE completed <= '".$this->ov_end_date."'" : "");
        
        $sqls[] = "SELECT SUM(xp) as xp, "
                ."SUM(creds) as credits "
                ."FROM `arena_lw_contracts` ".($this->ov_end_date ? "WHERE completed <= '".$this->ov_end_date."'" : "");
                
        $sqls[] = "SELECT SUM(arena_ro_hunters.first) as first, SUM(arena_ro_hunters.xp) as xp, SUM(arena_ro_hunters.creds) as credits FROM arena_ro_hunters, arena_ro WHERE arena_ro.id = arena_ro_hunters.run_on"
                ." AND arena_ro.mbid > 0 AND arena_ro.date_deleted = 0 ".($this->ov_end_date ? "AND arena_ro.start <= '".$this->ov_end_date."'" : "");
                
        $sqls[] = "SELECT SUM(arena_irca_records.xp) as xp, SUM(arena_irca_records.credits) as credits FROM arena_irca_records, arena_irca_match WHERE "
	    	."arena_irca_match.id = arena_irca_records.match_id AND arena_irca_match.graded > 0 AND arena_irca_match.date_deleted = 0".($this->ov_end_date ? " AND arena_irca_match.date <= '".$this->ov_end_date."'" : "");

        foreach ($sqls as $sql){
	        $query = mysql_query($sql, $this->connect);
	        $info = mysql_fetch_array($query);
	
	        $this->ovs_creds += $info['credits'];
	        $this->ovs_xp += $info['xp'];
        }
        
        $msqls[] = "SELECT * FROM `arena_dojo_masters`, `arena_registrar`, `arena_mission`, `arena_solo_comissioners`, `arena_adjunct`, `arena_overseer`, `arena_stewards`, `arena_skippers`, `arena_commentator` ".($this->ov_end_date ? "WHERE `start_date` <= '".$this->ov_end_date."'" : "");
        
        foreach ($msqls as $sql){
	        $query = mysql_query($sql, $this->connect);
	        $info = mysql_fetch_array($query);
	
	        $this->ovs_creds += $info['credits'];
	        $this->ovs_xp += $info['xp'];
	        $this->ovs_medal += $info['medal'];
        }

    }
    
    function OVCreds(){
	    return $this->ovs_creds;
    }
    
    function OVXP(){
	    return $this->ovs_xp;
    }
    
    function OVMedal(){
	    return $this->ovs_medal;
    }
    
    function GetID(){
	    return $this->ov_id;
    }

    function GetHunter(){
        return new Person($this->ov_bhg_id);
    }

    function GetStatus(){
        if ($this->ov_bhg_id){
		    if ($this->ov_end_date == 0){
	            return "Current ";
	        } elseif ($this->ov_end_date > 0) {
	            return "Retired ";
	        } 
        }else {
	        return false;
        }
    }
    
    function GetXP(){
        return $this->ov_xp;
    }

    function GetCreds(){
        return $this->ov_creds;
    }
    
    function GetMedals(){
	    return $this->ov_medal;
    }
    
    function EndTerm(){
	    $sql = "UPDATE `arena_overseer` SET `end_date` = '".time()."' WHERE `bhg_id` = '".$this->ov_bhg_id."'";
		
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
 }

?>