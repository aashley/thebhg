<?

 Class LW_Solo extends Arena {

    function LW_Solo(){
        Arena::Arena();
    }

    function Members(){
	    $sql = "SELECT * FROM `arena_lw_members`";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $return[] = $info['bhg_id'];
	    }
	    
	    return $return;
    }
    
    function DeleteMember($bhg_id){
	    $sql = "DELETE FROM `arena_lw_members` WHERE `bhg_id` = '$bhg_id'";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function NewMember($bhg_id){
	    $sql = "INSERT INTO `arena_lw_members` VALUES ('$bhg_id')";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }	    
    
    function NotifyComissioner($type = '1', $mb_id = '', $name = ''){

        if ($type == 1){

            $text = "A Lone Wolf Mission has been requested. Please go to the Holonet to process it. http://holonet.thebhg.org/";

        } elseif ($type == 2) {

            $text = "A Dead Contract has been requested by $name. http://boards.thebhg.org/index.php?op=view&topic=$mb_id";

        } elseif ($type == 3) {

            $text = "A Lone Wolf Mission has been retired by $name. http://boards.thebhg.org/index.php?op=view&topic=$mb_id";

        }

        $solo = new Solo();
        
        $person = new Person($solo->CurrentComissioner());

        $from = "overseer@thebhg.org";
        $subject = "New Contract Request";

        $person->SendEmail($from, $subject, $text);
    }

    function Contracts(){
        $sql = "SELECT * FROM `arena_lw_contracts` WHERE `bhg_id` > 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new LW_Contract($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function PendingContracts(){
        $sql = "SELECT * FROM `arena_lw_contracts` WHERE `completed` = 0 AND `bhg_id` > 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new LW_Contract($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function RequestedContracts(){
        $sql = "SELECT * FROM `arena_lw_contracts` WHERE `mb_id` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new LW_Contract($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function DeadContracts(){
        $sql = "SELECT * FROM `arena_lw_contracts` WHERE `bhg_id` = 0 AND `requested` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new LW_Contract($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function DCORequests(){
	    $sql = "SELECT * FROM `arena_lw_contracts` WHERE `requested` = 1 AND `bhg_id` > 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new LW_Contract($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function RetireRequests(){
	    $sql = "SELECT * FROM `arena_lw_contracts` WHERE `requested` = 1 AND `bhg_id` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new LW_Contract($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function PendingContract($bhg_id){
        $sql = "SELECT * FROM `arena_lw_contracts` WHERE `bhg_id` = '$bhg_id' AND `completed` = 0";
        $query = mysql_query($sql, $this->connect);

        if (mysql_num_rows($query)){        
        	return (mysql_num_rows($query));
    	} else {
	    	$sql = "SELECT * FROM `arena_lw_request` WHERE `bhg_id` = '$bhg_id'";
	        $query = mysql_query($sql, $this->connect);
	
        	return (mysql_num_rows($query));
    	}
    }

    function NeedApproval(){
	    $sql = "SELECT * FROM `arena_lw_request`";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $return[] = $info['bhg_id'];
	    }
	    
	    return $return;
    }
    
    function Build() {
		$total = "SELECT * FROM `arena_lw_contracts` WHERE `bhg_id` > 0";
        $qtotal = mysql_query($total, $this->connect);
        $total = mysql_num_rows($qtotal);
        $sql = "SELECT * FROM `arena_lw_contracts` WHERE `bhg_id` > 0 ORDER BY `bhg_id` ASC";
        $query = mysql_query($sql, $this->connect);
        $return = array();
        $var = array();

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