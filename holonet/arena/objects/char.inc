<?php

Class Chara extends Sheet {

    var $cs_bhg_id;
    var $cs_last_change;
    var $cs_approved;
    var $cs_person;
    var $cs_pending;
    var $cs_ban;
    var $LastID;

    function Chara($id) {
        Sheet::Sheet();
        
        $sql = "SELECT * FROM `character_sheets` WHERE `bhg_id` = '$id'";
        $query = mysql_query($sql, $this->connect);

        $this->cs_person = new Person($id);
        
        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'cs_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }
    
    function GetID(){
	    return $this->cs_person->GetID();
    }
    
    function GetName(){
	    
	    return $this->cs_person->GetName();
    }
    
    function HasValue(){
	    $sql = "SELECT * FROM `character_sheet_values` WHERE `bhg_id` = '".$this->GetID()."' LIMIT 1";
        $query = mysql_query($sql, $this->connect);
        
        return (mysql_num_rows($query));
    }
    
    function Includeable(){
	    $inc = array(1,3,5);
	    if (in_array($this->Status('SYSTEM'), $inc)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function Status($output){
	    $status = array(1=>'Approved', 2=>'Not Created', 3=>'Edit in Progress', 5=>'Pending Approval', 4=>'Denied Character', 6=>'Pending Approval', -1=>'Blank Sheet');
	    if ($this->cs_bhg_id){
		    if ($this->cs_last_change){
			    if ($this->cs_approved){
				    $return = 1;
			    } else {
				    if ($this->cs_pending){
					    $return = 3;
				    } else {
				    	$return = 5;
			    	}
			    }
		    }
		    if (!$this->HasValue()){
			    $return = -1;
		    }
		    if (!$this->HasValue()){
			    if ($this->cs_approved){
			    	$return = 4;
		    	} else {
			    	if (!$this->cs_pending){
			    		$return = 6;
		    		}
		    	}
	    	}
	    } else {
		    $return = 2;
	    }

	    if ($output == 'HUMAN'){
		    return $status[$return];
	    } elseif ($output == 'SYSTEM'){
		    return $return;
	    }
    }
}	    
?>