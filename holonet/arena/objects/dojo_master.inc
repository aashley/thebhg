<?php

 Class Master extends Arena {

     var $dojo_id;
     var $dojo_bhg_id;
     var $dojo_start_date;
     var $dojo_end_date;

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

    }

    function GetHunter(){
        return new Person($dojo_bhg_id);
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