<?php

 Class Comissioner extends Solo {

     var $comish_id;
     var $comish_bhg_id;
     var $comish_xp;
     var $comish_creds;
     var $comish_medal;
     var $comish_start_date;
     var $comish_end_date;
     var $creds;
     var $xp;

     function Comissioner($bhg_id){
        Arena::Arena();

        $sql = "SELECT * FROM `arena_solo_comissioners` WHERE `bhg_id` = '$bhg_id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'comish_'.$key;
                $this->$key = stripslashes($value);
            }

        }

        $this->SecondBuild();

    }

    function GetID(){
	    return $this->comish_id;
    }
    
    function SecondBuild(){
        $sql = "SELECT SUM(xp) as xp, "
                ."SUM(creds) as credits "
                ."FROM `arena_solo_contracts` WHERE `comissioner` = '".$this->comish_id."'";

        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        $this->creds = $info['credits'];
        $this->xp = $info['xp'];
        
        $sql = "SELECT SUM(xp) as xp, "
                ."SUM(creds) as credits "
                ."FROM `arena_lw_contracts` WHERE `comissioner` = '".$this->comish_id."'";

        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        $this->creds = $this->creds+$info['credits']+$this->comish_creds;
        $this->xp = $this->xp+$info['xp']+$this->comish_xp;
    }

    function GetHunter(){
        return new SoloHunter($this->comish_bhg_id);
    }

    function GetContracts(){
        $sql = "SELECT * FROM `arena_solo_contracts` WHERE `comissioner` = '".$this->comish_id."'";
        $query = mysql_query($sql, $this->connect);

        $base = mysql_num_rows($query);
        
        $sql = "SELECT * FROM `arena_lw_contracts` WHERE `comissioner` = '".$this->comish_id."'";
        $query = mysql_query($sql, $this->connect);
        
        return $base+mysql_num_rows($query);
    }

    function GetXP(){
        return $this->xp;
    }

    function GetCreds(){
        return $this->creds;
    }
    
    function GetMedals(){
	    return $this->comish_medal;
    }

    function GetStatus(){
        if ($this->comish_bhg_id){
		    if ($this->comish_end_date == 0){
	            return "Current Commissioner ";
	        } elseif ($this->comish_end_date > 0) {
	            return "Retired Commissioner ";
	        } 
        }else {
	        return false;
        }
    }
    
    function EndTerm(){
	    $sql = "UPDATE `arena_solo_comissioners` SET `end_date` = '".time()."' WHERE `bhg_id` = '".$this->comish_bhg_id."'";
		
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
 }

?>