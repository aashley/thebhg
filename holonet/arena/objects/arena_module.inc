<?php

 Class Arena extends Roster {
	 
	var $connect;
	var $lyarna;
	var $fiction;

    function Arena(){   
		$this->connect = mysql_connect('localhost', 'thebhg_holonet', 'w0rdy');
			mysql_select_db('thebhg_holonet', $this->connect);
			
		$this->lyarna = $this->LyarnaConnect();
		$this->fiction = $this->FictionConnect();
    }
    
    function FictionConnect(){
        $fiction = mysql_connect("localhost", "thebhg_fiction", "c80509a2");
        mysql_select_db('thebhg_fiction', $fiction);

    	return $fiction;    
    }
    
    function LyarnaConnect(){
	    $lyarna = mysql_connect("localhost", "thebhg_lyarna", "lyarnasys55");
        mysql_select_db('thebhg_lyarna', $lyarna);
        
        return $lyarna;
    }

    function Overseer(){
	    $roster = new Roster();
        $overseer = $roster->SearchPosition('29');

        if (is_object($overseer[0])){
	        return $overseer[0];
        } else {
	        return new Person(1);
        }
    }

    function Adjunct(){
         $roster = new Roster();
         $adjunct = $roster->SearchPosition('9');

         if (is_object($adjunct[0])){
         	return $adjunct[0];
         } else {
	        return new Person(1);
        }
    }

    function Signature($id){
        if ($id == 1){
            $obj = $this->Overseer();
        } else {
            $obj = $this->Adjunct();
        }

        $name = $obj->GetName();

        return "<i><font face='Lucida Handwriting'>$name</font></i>";
    }
    
    function LatestReport($id){
	    
	    $roster = new Roster();
	    
	    if ($id == 1){
            $pos = new Position('29');
        } else {
            $pos = new Position('9');
        }
	    
        $reports = mysql_query('SELECT * FROM hn_reports WHERE position=' . $pos->GetID() . ' ORDER BY time DESC LIMIT 1', $roster->roster_db);
		if ($reports && mysql_num_rows($reports)) {
			$table = new Table($pos->GetName().' Report');
			$table->StartRow();
			$table->AddHeader('Latest');
			$table->AddHeader('Author');
			$table->EndRow();
			$report = mysql_fetch_array($reports);
			$author = $roster->GetPerson($report['author']);
			$table->AddRow('<a href="' . internal_link('report', array('id'=>$report['id']), 'roster') . '">' . date('j F Y', $report['time']) . '</a>', '<a href="' . internal_link('atn_general', array('id'=>$report['author'])) . '">' . $author->GetName() . '</a>');
			$table->EndTable();
		}
    }
    
    function FictionByPerson($bhg_id) {
        $sql = "SELECT * FROM `fiction` WHERE `bhg_id` = '$bhg_id' AND `date_deleted` = '0' AND `date` > '0' ORDER BY `id`";
        $query = mysql_query($sql, $this->fiction);
        $return = array();

        while ($result = mysql_fetch_array($query)) {
            $run = new Article($result['id']);
            array_push($return, $run);
        }

        return $return;
    }
    
    function CanBe($hunter){
	    $bhg_id = $hunter->GetID();
	    
	    $aas = array();
		
		$positions = array();
		$output = array();
		
		//Get the Arena Aide positions
		$aas['reg'] = new Registrar($bhg_id);
		$positions['reg']['desc'] = 'Office of Character Development Registrar';
		$aas['dojo'] = new Master($bhg_id);
		$positions['dojo']['desc'] = 'Master of the Dojo of Shadows';
		$aas['mm'] = new MissionMaster($bhg_id);
		$positions['mm']['desc'] = 'Mission Master of Run-Ons';
		$aas['cbo'] = new Comissioner($bhg_id);
		$positions['cbo']['desc'] = 'Commissioner of the Bounty Office';
		
		$output = array();
		
		foreach ($aas as $class=>$object){
			if ($object->GetStatus() == 'Current '){
				$output[$class] = $positions[$class]['desc'];
			}
		}
		
		return $output;
	}
    
    function Tracker($hunter, $flag, $value, $aa = 0){
		$bhg_id = $hunter->GetID();
		
		$aas = array();
		
		$positions = array();
		$output = array();
		
		//Get the Arena Aide positions
		$aas['reg'] = new Registrar($bhg_id);
		$positions['reg']['desc'] = 'Office of Character Development Registrar';
		$positions['reg']['table'] = 'registrar';
		$aas['dojo'] = new Master($bhg_id);
		$positions['dojo']['desc'] = 'Master of the Dojo of Shadows';
		$positions['dojo']['table'] = 'dojo_masters';
		$aas['mm'] = new MissionMaster($bhg_id);
		$positions['mm']['desc'] = 'Mission Master of Run-Ons';
		$positions['mm']['table'] = 'mission';
		$aas['cbo'] = new Comissioner($bhg_id);
		$positions['cbo']['desc'] = 'Commissioner of the Bounty Office';
		$positions['cbo']['table'] = 'solo_comissioners';
		
		foreach ($aas as $class=>$object){
			if ($object->GetStatus() == 'Current '){
				$output[$class] = $positions[$class]['desc'];
			}
		}
		
		switch ($flag){
			case 'XP':
			$column = 'xp';
			break;
			
			case 'CREDS':
			$column = 'creds';
			break;
			
			case 'MEDAL':
			$column = 'medal';
			$value = 1;
			break;
		}
		
		if (count($output)){
			$return = ($aa ? $output[$aa] : $ouput[key(end($output))]);
			$use = ($aa ? $aa : key(end($output)));

			$sql = "UPDATE `".$positions[$use]['desc']."` SET `".$column."` = ".$column."+$value WHERE `id` = '".$aas[$use]->GetID()."'";
		
			echo $sql;
			
			if (mysql_query($sql, $this->connect)){
				return $return.': ';
			} else {
				return '';
			}
		} else {
			return '';
		}
	    
    }
    
    function ArenaType($id){
        return new Type($id);
    }

    function ArenaMatches(){
        $details = new Details();
        return $details->Matches();
    }
    
    function IRCAMatches(){
        $details = new IRCADetails();
        return $details->Matches();
    }

    function StarfieldMatches(){
        $details = new StarfieldDetails();
        return $details->Matches();
    }

    function SoloContracts(){
        $details = new Solo();
        return $details->Contracts();
    }
    
    function LWContracts(){
        $details = new LW_Solo();
        return $details->Contracts();
    }

    function ArenaLadder(){
        $details = new Details();
        return $details->Build();
    }
    
    function IRCALadder(){
        $details = new IRCADetails();
        return $details->Build();
    }

    function StarfieldLadder(){
        $details = new StarfieldDetails();
        return $details->Build();
    }

    function SoloLadder(){
        $details = new Solo();
        return $details->Build();
    }
    
    function LWLadder(){
        $details = new LW_Solo();
        return $details->Build();
    }

    function ArenaLocation($id, $table){
        return new Location($id, $table);
    }

    function StarfieldRestriction($id){
        return new Restriction($id);
    }

    function SoloType($id){
        return new SoloType($id);
    }

    function SoloGrade($id){
        return new Grade($id);
    }

    function StarfieldLocation($id){
        return new StarfieldLocation($id);
    }

    function StarfieldType($id){
        return new StarfieldType($id);
    }
    
    function StarfieldSetting($id){
        return new Setting($id);
    }

    function IRCAMatch($id){
        return new IRCAMatch($id);
    }
    
    function ArenaMatch($id){
        return new Match($id);
    }

    function StarfieldMatch($id){
        return new StarfieldMatch($id);
    }

    function Contract($id){
        return new Contract($id);
    }
    
    function LW_Contract($id){
        return new LW_Contract($id);
    }

    function Date2Unix($date, $seperator = "-"){
        $unix = explode($seperator, $date);

        return mktime (0,0,0,$unix[0],$unix[1],$unix[2]);
    }

    function GetOutcome($points) {

        if ($points == 5){
            return "Win";
        } elseif ($points == 2){
            return "Win via Disqualification";
        } elseif ($points == 3){
            return "Draw";
        } elseif ($points == -2){
            return "Loss";
        } elseif ($points == -5){
            return "Loss via Disqualification";
        } elseif ($points == 0){
            return "<b>Match Pending</b>";
        }

    }

    function Points(){
        return array('5'=>'Win', '2'=>'Win via Disqualification', '3'=>'Draw', '-2'=>'Loss', '-5'=>'Loss via Disqualification');
    }
    
    function AddApproved($bhg_id){
	    $sql = "INSERT INTO `arena_approved` VALUES ('$bhg_id')";
	    $query = mysql_query($sql, $this->connect);
	    
	    $text = "Your Dojo Master has declared you a graduate of the institute.";
		
        $from = "Dojo of Shadows <overseer@thebhg.org>";
        $subject = "Notice of Graduation";
	    
	    $person = new Person($bhg_id);
	    $person->Sendemail($from, $subject, $text);
	    
	    return ($query ? true : false);
    }
    
    function RemoveApproved($bhg_id){
	    $sql = "DELETE FROM `arena_approved` WHERE `bhg_id` = '$bhg_id'";
	    $query = mysql_query($sql, $this->connect);
	    
	    $text = "The Overseer has declared you undergo a retraining in the Dojo of Shadows.";
		
        $from = "Dojo of Shadows <overseer@thebhg.org>";
        $subject = "Notice of Retraining";
	    
	    $person = new Person($bhg_id);
	    $person->Sendemail($from, $subject, $text);
	    
	    return ($query ? true : false);
    }
    
    function AddTeta($bhg_id){
	    $sql = "INSERT INTO `arena_teta` VALUES ('$bhg_id')";
	    $query = mysql_query($sql, $this->connect);
	    
	    $text = "The Overseer has awarded you a set of Teta's Knives.";
		
        $from = "Arena Tracking Network <overseer@thebhg.org>";
        $subject = "Notice of Graduation";
	    
	    $person = new Person($bhg_id);
	    $person->Sendemail($from, $subject, $text);
	    
	    return ($query ? true : false);
    }
    
    function RemoveTeta($bhg_id){
	    $sql = "DELETE FROM `arena_teta` WHERE `bhg_id` = '$bhg_id'";
	    $query = mysql_query($sql, $this->connect);
	    
	    $text = "The Overseer has ordered the removal of your Teta's Knives.";
		
        $from = "Arena Tracking Network <overseer@thebhg.org>";
        $subject = "Teta's Knives Removal";
	    
	    $person = new Person($bhg_id);
	    $person->Sendemail($from, $subject, $text);
	    
	    return ($query ? true : false);
    }
    
    function GetTeta(){
	    $sql = "SELECT * FROM `arena_teta`";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $return[] = $info['bhg_id'];
	    }
	    
	    return array_unique($return);
    }
    
    function GetApproved(){
	    $sql = "SELECT * FROM `arena_approved`";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $return[] = $info['bhg_id'];
	    }
	    
	    return array_unique($return);
    }
    
    function GetDojo(){
	    $compare = $this->GetApproved();
	    $sheet = new Sheet();
	    $dojo = array();
	    
	    foreach ($sheet->SheetHolders() as $char){
		    if (!in_array($char->GetID(), $compare)){
			    $dojo[] = $char->GetID();
		    }
	    }
	    
	    return array_unique($dojo);
    }

 }

?>