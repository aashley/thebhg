<?php

 Class Adjunct extends Arena {

     var $aj_id;
     var $aj_bhg_id;
     var $aj_xp;
     var $aj_creds;
     var $aj_medal;
     var $aj_start_date;
     var $aj_end_date;

     function Adjunct($bhg_id){
        Arena::Arena();

        $sql = "SELECT * FROM `arena_adjunct` WHERE `bhg_id` = '$bhg_id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'aj_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }
    
    function GetID(){
	    return $this->aj_id;
    }

    function GetHunter(){
        return new Person($this->aj_bhg_id);
    }

    function GetStatus(){
        if ($this->aj_bhg_id){
		    if ($this->aj_end_date == 0){
	            return "Current ";
	        } elseif ($this->aj_end_date > 0) {
	            return "Retired ";
	        } 
        }else {
	        return false;
        }
    }
    
    function GetXP(){
        return $this->aj_xp;
    }

    function GetCreds(){
        return $this->aj_creds;
    }
    
    function GetMedals(){
	    return $this->aj_medal;
    }
    
    function EndTerm(){
	    $sql = "UPDATE `arena_adjunct` SET `end_date` = '".time()."' WHERE `bhg_id` = '".$this->aj_bhg_id."'";
		
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
 }

?>