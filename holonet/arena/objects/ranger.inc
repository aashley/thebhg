<?php

 Class Ranger extends Solo {

     var $ranger_id;
     var $ranger_bhg_id;
     var $ranger_xp;
     var $ranger_creds;
     var $ranger_medal;
     var $ranger_start_date;
     var $ranger_end_date;
     var $creds;
     var $xp;

     function Ranger($bhg_id){
        Arena::Arena();

        $sql = "SELECT * FROM `arena_rangers` WHERE `bhg_id` = '$bhg_id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'ranger_'.$key;
                $this->$key = stripslashes($value);
            }

        }

        $this->SecondBuild();

    }

    function GetID(){
	    return $this->ranger_id;
    }
    
    function SecondBuild(){       
        $sql = "SELECT SUM(xp) as xp, "
                ."SUM(creds) as credits "
                ."FROM `arena_survival_contracts` WHERE `ranger` = '".$this->ranger_id."'";

        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        $this->creds = $info['credits']+$this->ranger_creds;
        $this->xp = $info['xp']+$this->ranger_xp;
    }

    function GetHunter(){
        return new SoloHunter($this->ranger_bhg_id);
    }

    function GetContracts(){
        $sql = "SELECT * FROM `arena_solo_contracts` WHERE `ranger` = '".$this->ranger_id."'";
        $query = mysql_query($sql, $this->connect);

        $base = mysql_num_rows($query);
        
        $sql = "SELECT * FROM `arena_lw_contracts` WHERE `ranger` = '".$this->ranger_id."'";
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
	    return $this->ranger_medal;
    }

    function GetStatus(){
        if ($this->ranger_bhg_id){
		    if ($this->ranger_end_date == 0){
	            return "Current ";
	        } elseif ($this->ranger_end_date > 0) {
	            return "Retired ";
	        } 
        }else {
	        return false;
        }
    }
    
    function EndTerm(){
	    $sql = "UPDATE `arena_rangers` SET `end_date` = '".time()."' WHERE `bhg_id` = '".$this->ranger_bhg_id."'";
		
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
 }

?>