<?php

 Class Arena extends Roster {
	 
	var $connect;
	var $lyarna;
	var $fiction;
	var $bastion;

    function Arena(){   
		$this->connect = mysql_connect('localhost', 'thebhg_holonet', 'w0rdy');
			mysql_select_db('thebhg_holonet', $this->connect);
			
		$this->lyarna = $this->LyarnaConnect();
		$this->fiction = $this->FictionConnect();
		$this->bastion = $this->BastionConnect();
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
    
    function BastionConnect(){
	    $bastion = mysql_connect('localhost', 'thebhg_overseer', '01c81257');
		mysql_select_db('thebhg_overseer', $bastion);
        
        return $bastion;
    }
    
    function MyProperties($hunter){
	    $bhg_id = $hunter->GetID();
	    $divi = $hunter->GetDivision();
	    $posi = $hunter->GetPosition();
	    $division = $divi->GetID();
	    $position = $posi->GetID();
	    
	    $tables = array('complex', 'estate', 'hq', 'other', 'personal');
	    $return = array();
	    foreach ($tables as $table){
		    $sql = "SELECT * FROM `$table` WHERE (`division` = '$division' AND `position` = '$position') OR (`bhg_id` = '$bhg_id')";
		    $query = mysql_query($sql, $this->LyarnaConnect());
		    
		    while ($info = mysql_fetch_array($query)){
			    $return[] = array('arena'=>$info['arena'], 'planet'=>$info['planet'], 'table'=>mysql_field_table($query, 'id'), 'id'=>$info['id'], 'posi'=>($info['position'] ? 1 : 0));
		    }
	    }
	    
	    return $return;
    }

    function NEC($error){
	    return 'System Processing Error - <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/index.php?page=reportbug">Bug Tracker. Module: Holonet - Arena</a></b><br />NEC Error Code: '.$error;
    }
    
    function BastionPlayer($bhg_id){
		$result = mysql_query('SELECT SUM(points) AS total, person, kabal, kag FROM `bastion_signups` WHERE `person` = \'$bhg_id\' GROUP BY person, kabal, kag ORDER BY kag ASC', $this->bastion);
		if ($result && mysql_num_rows($result)) {
			$hunters = array();
			while ($row = mysql_fetch_array($result)) {
				$array = array('total'=>$row['total'], 'kabal'=>new Kabal($row['kabal']));
				$hunters[$row['kag']] = $array;
			}
			return $hunters;
		}
		else {
			return false;
		}
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
    
    function CurrentOV(){
        $sql = "SELECT * FROM `arena_overseer` WHERE `end_date` = '0'";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        return $info['bhg_id'];
    }
    
    function NewOV($bhg_id){
	    $current = new Overseer($this->CurrentOV());
	    $current->EndTerm();
	    
	    $sql = "SELECT * FROM `arena_overseer` WHERE `bhg_id` = '$bhg_id'";
	    $query = mysql_query($sql, $this->connect);
	    
	    if (mysql_num_rows($query)){
		    $info = mysql_fetch_array($query);
		    $sql = "UPDATE `arena_overseer` SET `start_date` = '".time()."', `end_date` = 0";
	    } else {
	    	$sql = "INSERT INTO `arena_overseer` (`bhg_id`, `start_date`) VALUES ('$bhg_id', '".time()."')";
    	}
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function CurrentAJ(){
        $sql = "SELECT * FROM `arena_adjunct` WHERE `end_date` = '0'";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        return $info['bhg_id'];
    }
    
    function NewAJ($bhg_id){
	    $current = new Adjunct($this->CurrentAJ());
	    $current->EndTerm();
	    
	    $sql = "SELECT * FROM `arena_adjunct` WHERE `bhg_id` = '$bhg_id'";
	    $query = mysql_query($sql, $this->connect);
	    
	    if (mysql_num_rows($query)){
		    $info = mysql_fetch_array($query);
		    $sql = "UPDATE `arena_adjunct` SET `start_date` = '".time()."', `end_date` = 0";
	    } else {
	    	$sql = "INSERT INTO `arena_adjunct` (`bhg_id`, `start_date`) VALUES ('$bhg_id', '".time()."')";
    	}
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function LatestReport($posis){
	    
	    $table = new Table();
	    $table->StartRow();
		$table->AddHeader('Position');
		$table->AddHeader('Latest');
		$table->AddHeader('Author');
		$table->EndRow();
	    foreach ($posis as $posi=>$t){
	        $reports = mysql_query('SELECT * FROM arena_reports WHERE admin="' . $posi . '" ORDER BY time DESC LIMIT 1', $this->connect);
			if ($reports && mysql_num_rows($reports)) {
				$report = mysql_fetch_array($reports);
				$author = new Person($report['author']);
				$table->AddRow('<a href="'.internal_link('view_reports', array('position'=>$posi)).'">'.$this->ArenaPosition($posi).'</a>', '<a href="' . internal_link('report', array('id'=>$report['id'])) . '">' . date('j F Y', $report['time']) . '</a>', '<a href="' . internal_link('atn_general', array('id'=>$report['author'])) . '">' . $author->GetName() . '</a>');
			}
		}
		$table->EndTable();
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
    
    function ArenaPosition($key){
	    $posi = $this->ArenaPositions();
	    
	    return $posi[$key]['desc'];
    }
    
    function ArenaPositions(){
	    $positions = array();
		
		$positions['reg']['desc'] = 'Office of Character Development Registrar';
		$positions['dojo']['desc'] = 'Master of the Dojo of Shadows';
		$positions['mm']['desc'] = 'Mission Master of Run-Ons';
		$positions['cbo']['desc'] = 'Commissioner of the Bounty Office';
		$positions['ov']['desc'] = 'Overseer of the Guild';
		$positions['aj']['desc'] = 'Adjunct of the Guild';
		$positions['sk']['desc'] = 'Skipper of the Starfield Arena';
		$positions['st']['desc'] = 'Steward of the Arena';
		$positions['irca']['desc'] = 'Holonet Commentator of the IRC Arena';
		$positions['ranger']['desc'] = 'Survival Mission Ranger';
		
		return $positions;
	}
	
	function CurrentHolders(){
		$aas = array();
		
		$sheet = new Sheet();
		$ladder = new Ladder();
		$ro = new RO();
		$solo = new Solo();
		$surv = new Survival();
		$skip = new Starfield();
		$irca = new IRCA();
		
		$aas['reg'] = $sheet->CurrentRegistrar();
		$aas['dojo'] = $ladder->CurrentMaster();
		$aas['mm'] = $ro->CurrentMM();
		$aas['cbo'] = $solo->CurrentComissioner();
		$aas['ov'] = $this->CurrentOV();
		$aas['aj'] = $this->CurrentAJ();
		$aas['sk'] = $skip->CurrentSkipper();
		$aas['st'] = $ladder->CurrentSteward();
		$aas['irca'] = $irca->CurrentHC();
		$aas['ranger'] = $surv->CurrentRanger();
		
		return $aas;
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
		$aas['ov'] = new Overseer($bhg_id);
		$positions['ov']['desc'] = 'Overseer of the Guild';
		$aas['aj'] = new Adjunct($bhg_id);
		$positions['aj']['desc'] = 'Adjunct of the Guild';
		$aas['sk'] = new Skipper($bhg_id);
		$positions['sk']['desc'] = 'Skipper of the Starfield Arena';
		$aas['st'] = new Steward($bhg_id);
		$positions['st']['desc'] = 'Steward of the Arena';
		$aas['irca'] = new Commentator($bhg_id);
		$positions['irca']['desc'] = 'Holonet Commentator of the IRC Arena';
		$aas['ranger'] = new Ranger($bhg_id);
		$positions['ranger']['desc'] = 'Survival Mission Ranger';
		
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
		$aas['ov'] = new Overseer($bhg_id);
		$positions['ov']['desc'] = 'Overseer of the Guild';
		$positions['ov']['table'] = 'overseer';
		$aas['aj'] = new Adjunct($bhg_id);
		$positions['aj']['desc'] = 'Adjunct of the Guild';
		$positions['aj']['table'] = 'adjunct';
		$aas['sk'] = new Skipper($bhg_id);
		$positions['sk']['desc'] = 'Skipper of the Starfield Arena';
		$positions['sk']['table'] = 'skippers';
		$aas['st'] = new Steward($bhg_id);
		$positions['st']['desc'] = 'Steward of the Arena';
		$positions['st']['table'] = 'stewards';
		$aas['irca'] = new Commentator($bhg_id);
		$positions['irca']['desc'] = 'Holonet Commentator of the IRC Arena';
		$positions['irca']['table'] = 'commentator';
		$aas['ranger'] = new Ranger($bhg_id);
		$positions['ranger']['desc'] = 'Survival Mission Ranger';
		$positions['ranger']['table'] = 'rangers';
		
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
			
			$sql = "UPDATE `arena_".$positions[$use]['table']."` SET `".$column."` = ".$column."+$value WHERE `id` = '".$aas[$use]->GetID()."'";
			
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
    
    function SurvivalContracts(){
        $details = new Survival();
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
    
    function SurvivalLadder(){
        $details = new Survival();
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
    
    function SurvivalGrade($id){
        return new SurvivalGrade($id);
    }

    function SurvivalType($id){
        return new SurvivalType($id);
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

    function SurvivalContract($id){
        return new SurvivalContract($id);
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