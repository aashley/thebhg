<?php

 Class Tempy extends Arena {

    function Tempy(){
        Arena::Arena();
    }

    function GetMembers(){
        $sql = "SELECT * FROM `arena_tempy_members` WHERE `mod` = 0 ORDER BY `bhg_id` ASC";
        $query = mysql_query($sql, $this->connect);
        $members = array();
        $mods = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Person($info['bhg_id']);
            array_push($members, $new);
        }
        
        $sql = "SELECT * FROM `arena_tempy_members` WHERE `mod` > 0 ORDER BY `bhg_id` ASC";
        $query = mysql_query($sql, $this->connect);
        while ($info = mysql_fetch_array($query)){
            $new = new Person($info['bhg_id']);
            array_push($mods, $new);
        }

        return array($members, $mods);
    }
    
    function Members(){
	    $return = array();
	    foreach ($this->GetMembers() as $members){
		    foreach ($members as $value){
		    	$return[] = $value->GetID();
	    	}
	    }

        return $return;
    }
    
    function ActiveMods(){
        $sql = "SELECT * FROM `arena_tempy_members` WHERE `mod` = 1 ORDER BY `bhg_id` ASC";
        $query = mysql_query($sql, $this->connect);
		$return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Person($info['bhg_id']);
            array_push($return, $new->GetID());
        }

        return $return;
    }
    
    function BaseMembers(){
        $sql = "SELECT * FROM `arena_tempy_members` WHERE `mod` = 0 ORDER BY `bhg_id` ASC";
        $query = mysql_query($sql, $this->connect);
		$return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Person($info['bhg_id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function Mods(){
        $sql = "SELECT * FROM `arena_tempy_members` WHERE `mod` > 0 ORDER BY `bhg_id` ASC";
        $query = mysql_query($sql, $this->connect);
		$return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Person($info['bhg_id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function ModStatus($bhg_id){
	    $sql = "SELECT * FROM `arena_tempy_members` WHERE `bhg_id` = '$bhg_id'";
	    $query = mysql_query($sql, $this->connect);
	    $info = mysql_fetch_array($query);
	    
	    if ($info['mod'] == 2){
		    return "Inactive";
	    } elseif ($info['mod']){
		    return "Active";
	    }
    }
    
    function DeleteMember($bhg_id){
	    $sql = "DELETE FROM `arena_tempy_members` WHERE `bhg_id` = '$bhg_id'";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }	    
    }
    
    function InsertMember($bhg_id){
	    $sql = "INSERT INTO `arena_tempy_members` (`bhg_id`) VALUES ('$bhg_id')";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }	    
    }
    
    function Petition($bhg_id, $reason){
	    $sql = "INSERT INTO `arena_tempy_jury` (`bhg_id`, `reason`) VALUES ('$bhg_id', '".addslashes($reason)."')";
	    
	    if (mysql_query($sql, $this->connect)){
		    
		    $person = new Person($bhg_id);
		    
		    foreach ($this->ActiveMods() as $value){

				$text = $person->GetName()." has submitted a petition for admittance to the Tempestuous Group. Please go to the Holonet to either "
			    		."approve or deny their request.\r\n\r\nTheir reason they think they should be admitted is:\r\n".$reason;

	            $from = "Tempestuous Group <overseer@thebhg.org>";
	            $subject = "Tempestuous Petition Submitted";
	
	            $value->SendEmail($from, $subject, $text);
            }
		    
		    return true;
	    } else {
		    return false;
	    }	    
    }
    
    function CanPetition($bhg_id){
	    $sql = "SELECT * FROM `arena_tempy_jury` WHERE `bhg_id` = '$bhg_id' AND `approved` = 0 AND `complete` = 0 AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->connect);
	    
	    return (mysql_num_rows($query) == 0);
    }
    
    function Pending(){
	    $sql = "SELECT * FROM `arena_tempy_jury` WHERE `approved` = 0 AND `complete` = 0 AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
			$new = new Petition($info['id']);
			array_push($return, $new);    
	    }
	    
	    return $return;
    }
    
    function NeedJury(){
	    $sql = "SELECT * FROM `arena_tempy_jury` WHERE `juror1` = 0 OR `juror2` = 0 OR `juror3` = 0 OR `juror4` = 0 AND `approved` = 1 AND "
	    	."`complete` = 0 AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
			$new = new Petition($info['id']);
			array_push($return, $new);    
	    }
	    
	    return $return;
    }
    
    function InJury($bhg_id){
	    $sql = "SELECT * FROM `arena_tempy_jury` WHERE `juror1` = '$bhg_id' OR `juror2` = '$bhg_id' OR `juror3` = '$bhg_id' OR `juror4` = '$bhg_id' "
	    	." AND `approved` = 1 AND `complete` = 0 AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
			$new = new Petition($info['id']);
			array_push($return, $new);    
	    }
	    
	    return $return;
    }
    
    function FullJury($hunter){
	    $posi = $hunter->GetPosition();
	    if ($posi->GetID() == 9 || $posi->GetID() == 29){
		    $extra = '';
	    } else {
		    $extra = 'AND `mod` ='.$hunter->GetID();
	    }
		    
	    $sql = "SELECT * FROM `arena_tempy_jury` WHERE `juror1` > 0 AND `juror2` > 0 AND `juror3` > 0 AND `juror4` > 0 AND `approved` = 1 AND "
	    	."`complete` = 0 AND `started` = 0 $extra AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
			$new = new Petition($info['id']);
			array_push($return, $new);    
	    }
	    
	    return $return;
    }
    
    function Solidified(){		    
	    $sql = "SELECT * FROM `arena_tempy_jury` WHERE fiction1 = 0 OR fiction2 = 0 OR fiction3 = 0 OR arena1 = 0 OR arena2 = 0 OR runon = 0 AND "
	    	."`approved` = 1 AND `complete` = 0 AND `started` > 0 AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
			array_push($return, $info['bhg_id']);    
	    }
	    
	    return $return;
    }
    
    function RequiredWorks($bhg_id){		    
	    $sql = "SELECT * FROM `arena_tempy_jury` WHERE fiction1 = 0 OR fiction2 = 0 OR fiction3 = 0 OR arena1 = 0 OR arena2 = 0 OR runon = 0 AND "
	    	."`approved` = 1 AND `complete` = 0 AND `started` > 0 AND `date_deleted` = 0 AND `bhg_id` = '$bhg_id'";
	    $query = mysql_query($sql, $this->connect);
	    $info = mysql_fetch_array($query);
	    
	    return new Petition($info['id']);
    }
    
    function RequiredVotes($bhg_id){		    
	    $sql = "SELECT * FROM `arena_tempy_jury` WHERE `juror1` = '$bhg_id' OR `juror2` = '$bhg_id' OR `juror3` = '$bhg_id' OR `juror4` = '$bhg_id'  OR `mod` = '$bhg_id' AND "
	    	."fiction1 > 0 AND fiction2 > 0 AND fiction3 > 0 AND arena1 > 0 AND arena2 > 0 AND runon > 0 AND "
	    	."`approved` = 1 AND `complete` = 0 AND `started` > 0 AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
			$new = new Petition($info['id']);
			array_push($return, $new);    
	    }
	    
	    return $return;
    }
    
    function AllPending(){
	    $sql = "SELECT * FROM `arena_tempy_jury` WHERE `approved` = 1 AND `complete` = 0 AND `date_deleted` = 0 AND `started` = 0";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
			$new = new Petition($info['id']);
			array_push($return, $new);    
	    }
	    
	    return $return;
    }
    
    function UpdateMod($bhg_id, $status){
	    $sql = "UPDATE `arena_tempy_members` SET `mod` = '$status' WHERE `bhg_id` = '$bhg_id'";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }	    
    }
		    

 }

?>