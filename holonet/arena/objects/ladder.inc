<?

 Class Ladder extends Arena {

	var $xp;
	var $creds;
	var $dxp;
	var $dcreds;
	 
    function Ladder(){
        Arena::Arena();
    }
    
    function ByBoardID($mbid){
        $sql = "SELECT * FROM `arena_ladder_match` WHERE `match_id` = '$mbid'";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        return $new = new Match($info['id']);
    }

    function Recent(){
        $sql = "SELECT * FROM `arena_ladder_match` WHERE `date_deleted` <= 1 ORDER BY `id` DESC LIMIT 20";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Match($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function Unposted(){
        $sql = "SELECT * FROM `arena_ladder_match` WHERE `date_deleted` = 0 AND `accepted` = 1 AND `match_id` = 0 AND `is_dojo` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Match($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function CurrentMaster(){
        $sql = "SELECT * FROM `arena_dojo_masters` WHERE `end_date` = '0'";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        return $info['bhg_id'];
    }
    
    function NewMaster($bhg_id){
	    $current = new Master($this->CurrentMaster());
	    $current->EndTerm();
	    
	    $sql = "SELECT * FROM `arena_dojo_masters` WHERE `bhg_id` = '$bhg_id'";
	    $query = mysql_query($sql, $this->connect);
	    
	    $sql = "INSERT INTO `arena_dojo_masters` (`bhg_id`, `start_date`) VALUES ('$bhg_id', '".time()."')";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function Build(){
	   $sql = "SELECT SUM(arena_ladder_records.xp) as xp, SUM(arena_ladder_records.credits) as credits FROM arena_ladder_records, arena_ladder_match WHERE arena_ladder_match.accepted = 1 "
                ."AND arena_ladder_match.id = arena_ladder_records.match_id AND arena_ladder_match.match_id > 0 AND arena_ladder_match.steward > 0 AND arena_ladder_match.date_deleted = 0 AND arena_ladder_match.is_dojo = '0'";
       
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        $this->creds = $info['credits'];
        $this->xp = $info['xp'];
        
        $sql = "SELECT SUM(arena_ladder_records.xp) as xp, SUM(arena_ladder_records.credits) as credits FROM arena_ladder_records, arena_ladder_match WHERE arena_ladder_match.accepted = 1 "
                ."AND arena_ladder_match.id = arena_ladder_records.match_id AND arena_ladder_match.match_id > 0 AND arena_ladder_match.steward > 0 AND arena_ladder_match.date_deleted = 0 AND arena_ladder_match.is_dojo > '0'";
       
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        $this->dcreds = $info['credits'];
        $this->dxp = $info['xp'];
    }
    
    function GetXP(){
	    return $this->xp;
    }
    
    function GetCreds(){
	    return $this->creds;
    }
    
    function GetDXP(){
	    return $this->dxp;
    }
    
    function GetDCreds(){
	    return $this->dcreds;
    }
    
    function CurrentSteward(){
        $sql = "SELECT * FROM `arena_stewards` WHERE `end_date` = '0'";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        return $info['bhg_id'];
    }
    
    function NewSteward($bhg_id){
	    $current = new Steward($this->CurrentSteward());
	    $current->EndTerm();
	    
	    $sql = "SELECT * FROM `arena_stewards` WHERE `bhg_id` = '$bhg_id'";
	    $query = mysql_query($sql, $this->connect);
	    
	    if (mysql_num_rows($query)){
		    $info = mysql_fetch_array($query);
		    $sql = "UPDATE `arena_stewards` SET `start_date` = '".time()."', `end_date` = 0 WHERE `bhg_id` = '$bhg_id'";
	    } else {
	    	$sql = "INSERT INTO `arena_stewards` (`bhg_id`, `start_date`) VALUES ('$bhg_id', '".time()."')";
    	}
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function PendingDojo($type = 'match_id'){
        $sql = "SELECT * FROM `arena_ladder_match` WHERE `date_deleted` = 0 AND `accepted` = 1 AND `$type` = 0 AND `is_dojo` > 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Match($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function NewType($name, $description, $rules, $fighters = 2){
	    $sql = "INSERT INTO `arena_ladder_type` (`name`, `description`, `rules`, `fighters`) VALUES ('".addslashes($name)."', '"
	    .addslashes($description)."', '".addslashes($rules)."', '$fighters')";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function NewWeapon($name){
	    $sql = "INSERT INTO `arena_ladder_weapons` (`weapon`) VALUES ('".addslashes($name)."')";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }

    function Pending($bhg_id = 0){
        if ($bhg_id){
            $sql = "SELECT arena_ladder_records.match_id as id FROM arena_ladder_records, arena_ladder_match WHERE arena_ladder_records.bhg_id = '$bhg_id' AND "
                    ."arena_ladder_match.accepted = 0 AND arena_ladder_records.challenger = 0 AND arena_ladder_match.id = arena_ladder_records.match_id AND "
                    ."arena_ladder_match.date_deleted = 0";
        } else {
            $sql = "SELECT * FROM `arena_ladder_match` WHERE `accepted` = 1 AND `date_deleted` = 0 AND `end` = 0 AND `is_dojo` = 0";
        }

        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Match($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function Unfinished(){
        $sql = "SELECT * FROM `arena_ladder_match` WHERE `date_deleted` = 0 AND `accepted` = 1 AND `end` = 0 AND `is_dojo` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Match($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function WeaponTypes(){
        $sql = "SELECT * FROM `arena_ladder_weapons` WHERE `date_deleted` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new WeaponType($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function AllTypes(){
        $sql = "SELECT * FROM `arena_ladder_weapons`";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new WeaponType($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function Locations(){
        $return = array();
        $names = array();
        $output = array();
        $locations = array('complex', 'estate', 'hq', 'personal', 'other');
        
        foreach ($locations as $location){ 
        
        	$sql = "SELECT * FROM $location WHERE `arena` = 1";

        	$query = mysql_query($sql, $this->lyarna);

	        while ($info = mysql_fetch_array($query)){
		        $new = new Location($info['id'], $location);
	
	            $return[$new->GetID()."_".$new->GetTable()] = $info['planet'];
	            $names[$new->GetID()."_".$new->GetTable()] = $new->GetName();
            }
            
        }
        
        asort($return);
        
        foreach ($return as $key=>$planet){
		    $planets = new StarfieldLocation($planet);
		    $name = explode(',', $planets->GetName());
	        $output[$key] = $name[0].' - '.$names[$key];
        }

        return $output;

    }

    function Rules(){
        $sql = "SELECT * FROM `arena_ladder_type` WHERE `date_deleted` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Type($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function AllRules(){
        $sql = "SELECT * FROM `arena_ladder_type`";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Type($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
 
 }

?>