<?php

class Team extends Podracer {

	var $id;
	var $name;
	var $leader;
	var $slogan;
	var $url;
	var $credits;
	var $image;
	var $accepting;
	var $date_deleted;
	
	function Team($id) {
		Podracer::Podracer();
		
		$sql = "SELECT * FROM `podracer_teams` WHERE `id` = '$id'";
		$query = mysql_query($sql, $this->connect);
		
		if ($result = @mysql_fetch_array($query)) {
            foreach ($result as $key => $value) {
                $this->$key = stripslashes($value);
            }
        }
	}		
	
	function Update($call, $value) {
		$sql = "UPDATE `podracer_teams` SET `$call` = '$value' WHERE `id` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		
		return ($query ? true : false);
	}
	
	function GetID() {
		return $this->id;
	}
	
	function GetName() {
		return stripslashes($this->name);
	}
	
	function SetName($id) {
		return $this->Update('name', addslashes($id));
	}
	
	function GetSlogan() {
		return stripslashes($this->slogan);
	}
	
	function SetSlogan($id) {
		return $this->Update('slogan', addslashes($id));
	}
		
	function GetURL() {
		return stripslashes($this->url);
	}
	
	function SetURL($id) {
		return $this->Update('url', addslashes($id));
	}
	
	function GetLeader() {
		return new Person($this->leader);
	}
	
	function SetLeader($id) {
		return $this->Update('leader', $id);
	}
	
	function GetAccepting(){
		return ($this->accepting == 1);
	}
	
	function SetAccepting($id){
		return $this->Update('accepting', $id);
	}
	
	function GetCredits() {
		return $this->credits;
	}
	
	function AddCredits($id) {
		$creds = $this->GetCredits()+$id;
		return $this->Update('credits', $creds);
	}
	
	function RemoveCredits($id) {
		$creds = $this->GetCredits()-$id;
		return $this->Update('credits', $creds);
	}
	
	function SetCredits($id) {
		return $this->Update('credits', $id);
	}
	
	function GetImage() {
		return stripslashes($this->image);
	}
	
	function SetImage($id) {
		return $this->Update('image', addslashes($id));
	}

	function ListMembers() {		
  		$sql = "SELECT `id` FROM `podracer_team_members` WHERE `date_deleted` = 0 AND `team` = '".$this->id."' ORDER BY donations DESC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$mem = new TeamMember($info['id']);
			if ($mem->IsLeader()){
				$leader = $mem;
			} else {
				$return[] = $mem;
			}
		}
		
		array_unshift($return, $leader);
		
		return $return;
	}
	
	function ListMembersRoster() {		
  		$sql = "SELECT `bhg_id` FROM `podracer_team_members` WHERE `date_deleted` = 0 AND `team` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$return[] = new Person($info['bhg_id']);
		}
		
		return $return;
	}
	
	function GetValue(){
		$total = 0;
		foreach ($this->ListMembers() as $member){
			$total += $member->GetDonations();
		}
		return $total;
	}
	
	function ListPods($del = 0) {		
  		$sql = "SELECT `id` FROM `podracer_owned_pods` WHERE ".($del ? '' : '`date_deleted` = 0 AND ')."`team` = '".$this->id."'";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)) {
			$return[] = new OwnedPod($info['id']);
		}
		
		return $return;
	}
	
	function ListRaceRegistrations() {		
  		$return = array();
  		$pods = $this->ListPods();
  		foreach ($pods as $pod){
	  		foreach($pod->ListRaceRegistrations() as $reg){
		  		$race = $reg->GetRace();
		  		if (!$race->GetHasRun()){
		  			$return[] = $reg;
	  			}
	  		}
  		}
  		
  		return $return;
	}
	
	function ListRaceResults() {		
  		$return = array();
  		$pods = $this->ListPods(1);
  		foreach ($pods as $pod){
	  		foreach($pod->ListRaceResults() as $reg){
		  		$return[] = $reg;
	  		}
  		}
  		
  		return $return;
	}
	
	function GetDeleted() {
		return $this->date_deleted;
	}
	
	function Delete() {
		foreach ($this->ListMembers() as $iter){
			if (!is_object($iter)){ continue; }
			$iter->delete();
		}
		return $this->Update('date_deleted', time());
	}
}
?>