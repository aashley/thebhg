<?

 Class RO extends Arena {

    function RO(){
        Arena::Arena();
    }
    
    function ByBoardID($mbid){
        $sql = "SELECT * FROM `arena_ro` WHERE `mbid` = '$mbid'";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        return $new = new RunOn($info['id']);
    }

    function CurrentMM(){
        $sql = "SELECT * FROM `arena_mission` WHERE `end_date` = '0'";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        return $info['bhg_id'];
    }
    
    function NewMM($bhg_id){
	    $current = new MissionMaster($this->CurrentMM());
	    $current->EndTerm();
	    
	    $sql = "SELECT * FROM `arena_mission` WHERE `bhg_id` = '$bhg_id'";
	    $query = mysql_query($sql, $this->connect);
	    
	    if (mysql_num_rows($query)){
		    $info = mysql_fetch_array($query);
		    $sql = "UPDATE `arena_mission` SET `start_date` = '".time()."', `end_date` = 0";
	    } else {
	    	$sql = "INSERT INTO `arena_mission` (`bhg_id`, `start_date`) VALUES ('$bhg_id', '".time()."')";
		}
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function Recent(){
        $sql = "SELECT * FROM `arena_ro` WHERE `date_deleted` = 0 ORDER BY `id` DESC LIMIT 20";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new RunOn($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function GetROs(){
        $sql = "SELECT * FROM `arena_ro` WHERE `date_deleted` = 0 ORDER BY `id`";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new RunOn($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function AllROs(){
        $sql = "SELECT * FROM `arena_ro` ORDER BY `id`";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new RunOn($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function NewRunOn($name, $start, $end, $mbid = 0){
	    $sql = "INSERT INTO `arena_ro` VALUES ('', '".addslashes($name)."', '$mbid', '".$this->CurrentMM()."', '$start', '$end', 0, 0)";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }

    function Pending($bhg_id = 0){
        if ($bhg_id){
            $sql = "SELECT arena_ro_hunters.run_on as id FROM arena_ro, arena_ro_hunters WHERE arena_ro_hunters.bhg_id = '$bhg_id' AND "
                    ."arena_ro.id = arena_ro_hunters.run_on AND arena_ro.date_deleted = 0 AND `graded` = 0";
        } else {
            $sql = "SELECT * FROM `arena_ro` WHERE `graded` = 0 AND `date_deleted` = 0";
        }

        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new RunOn($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function Unfinished(){
        $sql = "SELECT * FROM `arena_ro` WHERE `date_deleted` = 0 AND `graded` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new RunOn($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function Unposted(){
        $sql = "SELECT * FROM `arena_ro` WHERE `date_deleted` = 0 AND `mbid` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new RunOn($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
 }

?>