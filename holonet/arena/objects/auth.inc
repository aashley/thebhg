<?php

 Class Auth extends Arena {

     var $id;
     var $person;
     var $posi;

     function Auth($bhg_id){
        Arena::Arena();

        $this->id = $bhg_id;
        $this->person = new Person($bhg_id);
        $this->posi = $this->person->GetPosition();

    }

    function GetID(){
	    return $this->id;
    }
    
    function GetHunter(){
        return $this->person;
    }
    
    function Father(){
	    return ($this->id == 2650);
    }
    
    function OV(){
	    return ($this->Father() || $this->posi->GetID() == 29);
    }
    
    function RP(){
	    return ($this->Father() || $this->posi->GetID() == 29 || $this->posi->GetID() == 9);
    }
    
    function CH(){
	    return ($this->Father() || $this->posi->GetID() == 11 || $this->posi->GetID() == 12);
    }

    function Build($posi){
	    $sql = "SELECT * FROM `arena_$posi` WHERE `end_date` = '0'";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);
        
        return $info['bhg_id'];
    }
    
    function Populate($posi){
    	$sql = "SELECT * FROM `arena_$posi`";
        $query = mysql_query($sql, $this->connect);
        $return = array();
        
        while ($info = mysql_fetch_array($query)){
	        $return[] = $info['bhg_id'];
        }
        
        return $return;
    }
    
    function DM(){
	    return ($this->Build('dojo_masters') == $this->id);
    }
    
    function ST(){
	    return ($this->Build('stewards') == $this->id);
    }
    
    function RA(){
	    return ($this->Build('rangers') == $this->id);
    }
    
    function SK(){
	    return ($this->Build('skippers') == $this->id);
    }
    
    function MM(){
	    return ($this->Build('mission') == $this->id);
    }
    
    function RE(){
	    return ($this->Build('registrar') == $this->id);
    }
    
    function SO(){
	    return ($this->Build('solo_comissioners') == $this->id);
    }
    
    function HC(){
	    return ($this->Build('commentator') == $this->id);
    }
    
    function LW(){
	    print_r($this->id);
	    return ($this->RP() || in_array($this->id, $this->Populate('lw_members')));
    }
    
 }

?>