<?php

 Class Registrar extends Arena {

     var $reg_id;
     var $reg_bhg_id;
     var $reg_xp;
     var $reg_creds;
     var $reg_medal;
     var $reg_start_date;
     var $reg_end_date;

     function Registrar($bhg_id){
        Arena::Arena();

        $sql = "SELECT * FROM `arena_registrar` WHERE `bhg_id` = '$bhg_id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'reg_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }
    
    function GetID(){
	    return $this->reg_id;
    }

    function GetHunter(){
        return new Person($this->reg_bhg_id);
    }

    function GetStatus(){
        if ($this->reg_bhg_id){
		    if ($this->reg_end_date == 0){
	            return "Current ";
	        } elseif ($this->reg_end_date > 0) {
	            return "Retired ";
	        } 
        }else {
	        return false;
        }
    }
    
    function GetXP(){
        return $this->reg_xp;
    }

    function GetCreds(){
        return $this->reg_creds;
    }
    
    function GetMedals(){
	    return $this->reg_medal;
    }
    
    function EndTerm(){
	    $sql = "UPDATE `arena_registrar` SET `end_date` = '".time()."' WHERE `bhg_id` = '".$this->reg_bhg_id."'";
		
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
 }

?>