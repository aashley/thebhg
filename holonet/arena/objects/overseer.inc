<?php

 Class Overseer extends Arena {

     var $ov_id;
     var $ov_bhg_id;
     var $ov_xp;
     var $ov_creds;
     var $ov_medal;
     var $ov_start_date;
     var $ov_end_date;

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