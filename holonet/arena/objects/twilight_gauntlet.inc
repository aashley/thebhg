<?php

 Class TTG extends Arena {

    function TTG(){
        Arena::Arena();
    }

    function GetMembers($rp = 0){
        $sql = "SELECT * FROM `arena_ttg_members` ORDER BY `bhg_id` ASC";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Person($info['bhg_id']);
            if ($rp){
	            $posi = $new->GetPosition();
	            if (!($posi->GetID() == 9 || $posi->GetID() == 29)){
		            $process = true;
	            } else {
		            $process = false;
	            }
            } else {
	            $process = true;
            }
            
            if ($process){
            	array_push($return, $new); 
        	}           
            
        }

        return $return;
    }
    
    function Members($rp = 0){
	    $return = array();
	    
	    foreach ($this->GetMembers($rp) as $value){
		    $return[] = $value->GetID();
	    }
	    
	    return $return;
    }
    
    function CanAdd(){
        $sql = "SELECT * FROM `arena_ttg_members`";
        $query = mysql_query($sql, $this->connect);

        return (mysql_num_rows($query) < 12);
    }
    
    function DeleteMember($bhg_id, $email = false){
	    $sql = "DELETE FROM `arena_ttg_members` WHERE `bhg_id` = '$bhg_id'";
	    
	    if (mysql_query($sql, $this->connect)){
		    
		    if ($email){
			    $person = new Person($bhg_id);
		
		        $text = "You are no longer a member of the Twilight Gauntlet.";
		
		        $from = "Twilight Gauntlet <overseer@thebhg.org>";
		        $subject = "Notice of Removal";
		
		        $person->SendEmail($from, $subject, $text);
	        }    
		    
		    return true;
	    } else {
		    return false;
	    }	    
    }
    
    function InsertMember($bhg_id, $email = false){
	    $sql = "INSERT INTO `arena_ttg_members` (`bhg_id`) VALUES ('$bhg_id')";
	    
	    if (mysql_query($sql, $this->connect)){
		    
		    if ($email){
			    $person = new Person($bhg_id);
		
		        $text = "Congratulations! You are now a member of the Twilight Gauntlet.";
		
		        $from = "Twilight Gauntlet <overseer@thebhg.org>";
		        $subject = "Notice of Membership";
		
		        $person->SendEmail($from, $subject, $text);
	        }  
		    
		    return true;
	    } else {
		    return false;
	    }	    
    }
    
    function Challenge($bhg_id){
	    $sql = "INSERT INTO `arena_ttg_queue` (`bhg_id`) VALUES ('$bhg_id')";
	    
	    if (mysql_query($sql, $this->connect)){

            $adjunct = $this->Adjunct();
            $overseer = $this->Overseer();
            $person = new Person($bhg_id);

            $text = $person->GetName()." has chllenged the gauntlet. Go now and approve or deny their petition.";

            $from = "Twilight Gauntlet <overseer@thebhg.org>";
            $subject = "Gauntlet Chellenge";

            $adjunct->SendEmail($from, $subject, $text);
            $overseer->SendEmail($from, $subject, $text);
		    
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function CanChallenge($bhg_id){
	    $sql = "SELECT * FROM `arena_ttg_queue` WHERE `bhg_id` = '$bhg_id' AND `completed` = 0 AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->connect);
	    
	    return (mysql_num_rows($query) < 1);
    }
    
    function NeedChallengers(){
	    $sql = "SELECT * FROM `arena_ttg_queue` WHERE (`c1` = 0 OR `c2` = 0 OR `c3` = 0) AND `completed` = 0 AND `date_deleted` = 0 AND `approved` = 1";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $new = new Challenge($info['id']);
		    array_push($return, $new);
	    }
	    
	    return $return;
    }
    
    function Ready(){
	    $sql = "SELECT * FROM `arena_ttg_queue` WHERE `c1` > 0 AND `c2` > 0 AND `c3` > 0 AND `match_id3` = 0 AND `completed` = 0 AND `date_deleted` = 0 AND `approved` = 1";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $new = new Challenge($info['id']);
		    array_push($return, $new);
	    }
	    
	    return $return;
    }
    
    function Start(){
	    $sql = "SELECT * FROM `arena_ttg_queue` WHERE `c1` > 0 AND `c2` > 0 AND `c3` > 0 AND `match_id1` = 1 AND `match_id3` = 0 AND `completed` = 0 AND `date_deleted` = 0 AND `approved` = 1";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $new = new Challenge($info['id']);
		    array_push($return, $new);
	    }
	    
	    return $return;
    }
    
    function UnsetWinners(){
	    $sql = "SELECT * FROM `arena_ttg_queue` WHERE `c1` > 0 AND `c2` > 0 AND `c3` > 0 AND `match_id3` > 0 AND `completed` = 0 AND `date_deleted` = 0 AND `approved` = 1";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $new = new Challenge($info['id']);
		    array_push($return, $new);
	    }
	    
	    return $return;
    }
    
    function Winners(){
	    $sql = "SELECT * FROM `arena_ttg_queue` WHERE `c1` > 0 AND `c2` > 0 AND `c3` > 0 AND `match_id3` > 0 AND `completed` > 0 AND `date_deleted` = 0 AND `approved` = 1 AND `final_match` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    array_push($return, $info['bhg_id']);
	    }
	    
	    return $return;
    }
    
    function NeedPosting(){
	    $sql = "SELECT * FROM `arena_ttg_queue` WHERE `date_deleted` = 0 AND `approved` = 1 AND `final_match` > 0 AND `completed` = 1";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $new = new Challenge($info['id']);
		    array_push($return, $new);
	    }
	    
	    return $return;
    }
    
    function Finish(){
	    $sql = "SELECT * FROM `arena_ttg_queue` WHERE `date_deleted` = 0 AND `approved` = 1 AND `final_match` > 0 AND `completed` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $new = new Challenge($info['id']);
		    array_push($return, $new);
	    }
	    
	    return $return;
    }
    
    function FinalMatch($bhg_id){
	    $sql = "SELECT * FROM `arena_ttg_queue` WHERE `bhg_id` = '$bhg_id' AND `match_id3` > 0 AND `completed` > 0 AND `date_deleted` = 0 AND `approved` = 1";
	    $query = mysql_query($sql, $this->connect);
	    $info = mysql_fetch_array($query);
	    
	    return new Challenge($info['id']);
    }
    
    function AllPending(){
	    $sql = "SELECT * FROM `arena_ttg_queue` WHERE `completed` = 0 AND `date_deleted` = 0 AND `approved` = 1";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $new = new Challenge($info['id']);
		    array_push($return, $new);
	    }
	    
	    return $return;
    }
    
    function Running(){
	    $sql = "SELECT * FROM `arena_ttg_queue` WHERE `completed` = 0 AND `date_deleted` = 0 AND `approved` = 1 AND match_id1 > 0";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $new = new Challenge($info['id']);
		    array_push($return, $new);
	    }
	    
	    return $return;
    }
    
    function MyChallenges($bhg_id){
	    $sql = "SELECT * FROM `arena_ttg_queue` WHERE (`c1` = '$bhg_id' OR `c2` = '$bhg_id' OR `c3` = '$bhg_id') AND "
	    		."`completed` = 0 AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $new = new Challenge($info['id']);
		    array_push($return, $new);
	    }
	    
	    return $return;
    }
    
    function Pending($bhg_id = ''){
	    if ($bhg_id){
		    $sql = "SELECT * FROM `arena_ttg_queue` WHERE (`c1` = '$bhg_id' OR `c2` = '$bhg_id' OR `c3` = '$bhg_id') AND `completed` = 0 AND `date_deleted` = 0 AND `approved` = 0";
	    } else {
		    $sql = "SELECT * FROM `arena_ttg_queue` WHERE `completed` = 0 AND `date_deleted` = 0 AND `approved` = 0";
	    }
	    $query = mysql_query($sql, $this->connect);
	    
	    return mysql_num_rows($query);
    }
    
    function OpenChallenge(){
	    $sql = "SELECT * FROM `arena_ttg_queue` WHERE `completed` = 0 AND `approved` = 1 AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->connect);
	    
	    return (mysql_num_rows($query) > 5);
    }
    
    function Queue(){
	    $sql = "SELECT * FROM `arena_ttg_queue` WHERE `completed` = 0 AND `date_deleted` = 0 AND `approved` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $new = new Challenge($info['id']);
		    array_push($return, $new);
	    }
	    
	    return $return;
    }
    
    function QueueHistory($bhg_id){
	    $sql = "SELECT * FROM `arena_ttg_queue` WHERE `approved` = 1 AND `bhg_id` = '$bhg_id'";
	    $query = mysql_query($sql, $this->connect);
	    
	    return mysql_num_rows($query);
    }
 }

?>