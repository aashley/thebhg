<?

 Class Solo extends Arena {

	var $xp;
	var $creds;
	var $dxp;
	var $dcreds;
	 
    function Solo(){
        Arena::Arena();
    }

    function CurrentComissioner(){
        $sql = "SELECT * FROM `arena_solo_comissioners` WHERE `end_date` = '0'";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        return $info['bhg_id'];
    }
    
    function CurrentComissionerID(){
        $sql = "SELECT * FROM `arena_solo_comissioners` WHERE `end_date` = '0'";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        return $info['id'];
    }

    function NotifyComissioner($type = '1', $mb_id = '', $name = ''){

        if ($type == 1){

            $text = "A Solo Mission has been requested. Please go to the Holonet to process it. http://holonet.thebhg.org/";

        } elseif ($type == 2) {

            $text = "A Dead Contract has been requested by $name. http://boards.thebhg.org/index.php?op=view&topic=$mb_id";

        } elseif ($type == 3) {

            $text = "A Contract has been retired by $name. http://boards.thebhg.org/index.php?op=view&topic=$mb_id";

        }

        $person = new Person($this->CurrentComissioner());
        
        $from = "overseer@thebhg.org";
        $subject = "New Contract Request";

        $person->SendEmail($from, $subject, $text);
    }
    
    function Build(){
	   $sql = "SELECT SUM(xp) as xp, "
                ."SUM(creds) as credits "
                ."FROM `arena_solo_contracts` WHERE `comissioner` = '".$this->comish_id."'";

        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        $this->creds = $info['credits'];
        $this->xp = $info['xp'];
        
        $sql = "SELECT SUM(xp) as xp, "
                ."SUM(creds) as credits "
                ."FROM `arena_lw_contracts` WHERE `comissioner` = '".$this->comish_id."'";

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
    
    function NewComissioner($bhg_id){
	    $current = new Comissioner($this->CurrentComissioner());
	    $current->EndTerm();
	    
	    $sql = "SELECT * FROM `arena_solo_comissioners` WHERE `bhg_id` = '$bhg_id'";
	    $query = mysql_query($sql, $this->connect);
	    
	    if (mysql_num_rows($query)){
		    $info = mysql_fetch_array($query);
		    $sql = "UPDATE `arena_solo_comissioners` SET `start_date` = '".time()."', `end_date` = 0 WHERE `bhg_id` = '$bhg_id'";
	    } else {
	    	$sql = "INSERT INTO `arena_solo_comissioners` (`bhg_id`, `start_date`) VALUES ('$bhg_id', '".time()."')";
    	}
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }

    function NewGrade($name, $description, $points){
	    $sql = "INSERT INTO `arena_solo_grades` (`name`, `desc`, `points`) VALUES ('".addslashes($name)."', '".addslashes($description)."', '$points')";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function NewType($name, $description, $points){
	    $sql = "INSERT INTO `arena_solo_types` (`name`, `description`, `points`) VALUES ('".addslashes($name)."', '".addslashes($description)."', '$points')";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function Contracts(){
        $sql = "SELECT * FROM `arena_solo_contracts` WHERE `bhg_id` > 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Contract($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function Types(){
        $sql = "SELECT * FROM `arena_solo_types` WHERE `date_deleted` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new SoloType($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function AllTypes(){
        $sql = "SELECT * FROM `arena_solo_types`";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new SoloType($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function Grades(){
        $sql = "SELECT * FROM `arena_solo_grades` WHERE `date_deleted` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Grade($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function AllGrades(){
        $sql = "SELECT * FROM `arena_solo_grades`";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Grade($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function PendingContracts(){
        $sql = "SELECT * FROM `arena_solo_contracts` WHERE `completed` = 0 AND `bhg_id` > 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Contract($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function DCORequests(){
	    $sql = "SELECT * FROM `arena_solo_contracts` WHERE `requested` = 1 AND `bhg_id` > 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Contract($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function RetireRequests(){
	    $sql = "SELECT * FROM `arena_solo_contracts` WHERE `requested` = 1 AND `bhg_id` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Contract($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function NeedApproval(){
	    $sql = "SELECT * FROM `arena_solo_request`";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $return[] = array('bhg_id'=>$info['bhg_id'], 'type'=>$info['type']);
	    }
	    
	    return $return;
    }
    
    function RequestedContracts(){
        $sql = "SELECT * FROM `arena_solo_contracts` WHERE `mb_id` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Contract($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function DeadContracts(){
        $sql = "SELECT * FROM `arena_solo_contracts` WHERE `bhg_id` = 0 AND `requested` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Contract($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function GetGrades(){
        $sql = "SELECT * FROM `arena_solo_grades` WHERE `date_deleted` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Grade($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function PendingContract($bhg_id){
        $sql = "SELECT * FROM `arena_solo_contracts` WHERE `bhg_id` = '$bhg_id' AND `completed` = 0";
        $query = mysql_query($sql, $this->connect);

        if (mysql_num_rows($query)){        
        	return (mysql_num_rows($query));
    	} else {
	    	$sql = "SELECT * FROM `arena_solo_request` WHERE `bhg_id` = '$bhg_id'";
	        $query = mysql_query($sql, $this->connect);
	
        	return (mysql_num_rows($query));
    	}
    }

    function Build() {

        $sql = "SELECT * FROM `arena_solo_contracts` WHERE `bhg_id` > 0 ORDER BY `bhg_id` ASC";
        $query = mysql_query($sql, $this->connect);
        $return = array();
        $var = array();
		$total = "SELECT * FROM `arena_solo_contracts` WHERE `bhg_id` > 0";
        $qtotal = mysql_query($total, $this->connect);
        $total = mysql_num_rows($qtotal);
        
        if (!$total){ $total = 1; }
        
        while ($result = mysql_fetch_array($query)){
            $grade = new Grade($result['grade']);
            $var[$result['bhg_id']][] = $grade->GetPoints();
        }

        $count = count($var);
        $i = 0;
        $keys = array_keys($var);

        while ($i < $count){
            $key = $keys[$i];
            $result = $var[$key];
            $new = array_sum($result);
            $put = array($key => $new/$total);
            $return = $return + $put;
            $i++;
        }

        arsort($return, SORT_NUMERIC);
        reset($return);

        return $return;
    }
    
    function Search($bhg_id) {
        $base = $this->Build();
        $place = 0;
        $return = array();
        
        foreach ($base as $value=>$points){
	        $place++;
	        $return[$value] = $place;
        }
        
        if (array_key_exists($bhg_id, $return)){
        	return $return[$bhg_id];
    	} else {
	    	return false;
    	}
    }

 }

?>