<?

 Class Survival extends Arena {

    function Survival(){
        Arena::Arena();
    }

    function CurrentRanger(){
        $sql = "SELECT * FROM `arena_rangers` WHERE `end_date` = '0'";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        return $info['bhg_id'];
    }
    
    function CurrentRangerID(){
        $sql = "SELECT * FROM `arena_rangers` WHERE `end_date` = '0'";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        return $info['id'];
    }

    function NotifyRanger($type = '1', $mb_id = '', $name = ''){

        if ($type == 1){

            $text = "A Survival Mission has been requested. Please go here to begin the posting process.\r\n\r\n http://holonet.thebhg.org/";

        } elseif ($type == 2) {

            $text = "A Dead Survivalist Mission has been requested by $name. \r\n\r\n Link to the contract: http://boards.thebhg.org/index.php?op=view&topic=$mb_id";

        } elseif ($type == 3) {

            $text = "A Survival Mission has been retired by $name. \r\n\r\n Link to the contract: http://boards.thebhg.org/index.php?op=view&topic=$mb_id";

        }

        $person = new Person($this->CurrentComissioner());
        
        $from = "Office of Survival Skills <overseer@thebhg.org>";
        $subject = "Survival Mission Request";

        $person->SendEmail($from, $subject, $text);
    }
    
    function NewRanger($bhg_id){
	    $current = new Ranger($this->CurrentRanger());
	    $current->EndTerm();
	    
	    $sql = "INSERT INTO `arena_rangers` (`bhg_id`, `start_date`) VALUES ('$bhg_id', '".time()."')";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }

    function NewGrade($name, $description){
	    $sql = "INSERT INTO `arena_survival_grades` (`name`, `desc`) VALUES ('".addslashes($name)."', '".addslashes($description)."')";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function NewType($name, $description){
	    $sql = "INSERT INTO `arena_survival_types` (`name`, `description`) VALUES ('".addslashes($name)."', '".addslashes($description)."')";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function Contracts(){
        $sql = "SELECT * FROM `arena_survival_contracts` WHERE `bhg_id` > 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new SurvivalContract($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function Types(){
        $sql = "SELECT * FROM `arena_survival_types` WHERE `date_deleted` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new SurvivalType($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function AllTypes(){
        $sql = "SELECT * FROM `arena_survival_types`";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new SurvivalType($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function Grades(){
        $sql = "SELECT * FROM `arena_survival_grades` WHERE `date_deleted` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new SurvivalGrade($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function AllGrades(){
        $sql = "SELECT * FROM `arena_survival_grades`";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new SurvivalGrade($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function PendingContracts(){
        $sql = "SELECT * FROM `arena_survival_contracts` WHERE `completed` = 0 AND `bhg_id` > 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new SurvivalContract($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function DCORequests(){
	    $sql = "SELECT * FROM `arena_survival_contracts` WHERE `requested` = 1 AND `bhg_id` > 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new SurvivalContract($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function RetireRequests(){
	    $sql = "SELECT * FROM `arena_survival_contracts` WHERE `requested` = 1 AND `bhg_id` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new SurvivalContract($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function NeedApproval(){
	    $sql = "SELECT * FROM `arena_survival_request`";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $return[] = array('bhg_id'=>$info['bhg_id'], 'type'=>$info['type']);
	    }
	    
	    return $return;
    }
    
    function RequestedContracts(){
        $sql = "SELECT * FROM `arena_survival_contracts` WHERE `mb_id` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new SurvivalContract($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function DeadContracts(){
        $sql = "SELECT * FROM `arena_survival_contracts` WHERE `bhg_id` = 0 AND `requested` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new SurvivalContract($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function GetGrades(){
        $sql = "SELECT * FROM `arena_survival_grades` WHERE `date_deleted` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new SurvivalGrade($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function PendingContract($bhg_id){
        $sql = "SELECT * FROM `arena_survival_contracts` WHERE `bhg_id` = '$bhg_id' AND `completed` = 0";
        $query = mysql_query($sql, $this->connect);

        if (mysql_num_rows($query)){        
        	return (mysql_num_rows($query));
    	} else {
	    	$sql = "SELECT * FROM `arena_survival_request` WHERE `bhg_id` = '$bhg_id'";
	        $query = mysql_query($sql, $this->connect);
	
        	return (mysql_num_rows($query));
    	}
    }

    function Build() {

        $sql = "SELECT * FROM `arena_survival_contracts` WHERE `bhg_id` > 0 ORDER BY `bhg_id` ASC";
        $query = mysql_query($sql, $this->connect);
        $return = array();
        $var = array();

        while ($result = mysql_fetch_array($query)){
            $var[$result['bhg_id']][] = $result['grade'];
        }

        $count = count($var);
        $i = 0;
        $keys = array_keys($var);

        while ($i < $count){
            $key = $keys[$i];
            $result = $var[$key];
            $new = array_sum($result);
            $put = array($key => $new);
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