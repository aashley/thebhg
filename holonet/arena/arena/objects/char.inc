<?php

Class Chara extends Sheet {

    var $cs_bhg_id;
    var $cs_id;
    var $cs_last_change;
    var $cs_approved;
    var $cs_person;
    var $cs_pending;
    var $cs_ban;
    var $cs_date_deleted;
    var $LastID;

    function Chara($id) {
        Sheet::Sheet();
        
        $sql = "SELECT * FROM `character_sheets` WHERE `bhg_id` = '$id' AND `date_deleted` = 0";
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
    
    function GetSheetID(){
	    return $this->cs_id;
    }
    
    function GetName(){
	    return $this->cs_person->GetName();
    }
    
    function GetDeleted(){
	    return ($this->cs_date_deleted > 0);
    }
    
    function DateDeleted(){
	    if ($this->GetDeleted()){
		    $date = getdate($this->cs_date_deleted);
		    return $date['month'] . ' ' . $date['mday'] . ', ' . $date['year'];
    	} else {
	    	return 'Not Deleted';
    	}
	}	
    
    function LastEdit(){
	    $date = getdate($this->cs_last_change);
	    return $date['month'] . ' ' . $date['mday'] . ', ' . $date['year'];
    }
    
    function GetBan($type = 'SYSTEM'){
	    if ($type == 'HUMAN'){
		    if ($this->cs_ban >= time()){
			    $date = getdate($this->cs_ban);
			    return $date['mon'].'/'.$date['mday'].'/'.$date['year'];
		    } else {
			    return 'No Edit Ban';
		    }
	    } else {
		    return $this->cs_ban;
	    }
    }
    
    function HasValue(){
	    $sql = "SELECT * FROM `character_sheet_values` WHERE `id` = '".$this->GetSheetID()."' LIMIT 1";
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