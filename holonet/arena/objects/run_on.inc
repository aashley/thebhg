<?

 Class RunOn extends RO {

    var $arena_id;
    var $arena_name;
    var $arena_mbid;
    var $arena_start;
    var $arena_end;
    var $arena_graded;
    var $arena_date_deleted;

    function RunOn($id) {
        Arena::Arena();

        $sql = "SELECT * FROM `arena_ro` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'arena_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }

    function GetHunters(){
        $sql = "SELECT * FROM `arena_ro_hunters` WHERE `run_on` = '".$this->arena_id."' AND `date_deleted` = 0 ORDER BY `first` DESC";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new ROHunter($info['bhg_id'], $this->arena_id);
            array_push($return, $new);
        }

        return $return;

    }

    function GetID() {
        return $this->arena_id;
    }

    function GetStatus() {
        if ($this->arena_date_deleted > 0){
            return "Deleted";
        } elseif ($this->arena_start == 0){
            return "Unstarted";
        } elseif ($this->arena_end == 0){
            return "Pending";
        } elseif ($this->arena_end > 0){
            return "Completed";
        }
    }

    function ArenaLink(){
        return "<i><a href=http://boards.thebhg.org/index.php?op=view&topic=".$this->GetMatchID().">Message Board Topic</a></i>";
    }

    function GetLink(){
        return "<i><a href=http://boards.thebhg.org/index.php?op=view&topic=".$this->GetMatchID().">Match ".$this->GetMatchID()."</a></i>";
    }

    function RawLink($id = 0){
	    if ($id == 0){
		    $link = $this->GetMatchID();
	    } else {
		    $link = $id;
	    }
        return "http://boards.thebhg.org/index.php?op=view&topic=".$link;
    }

    function GetMatchID() {
        return $this->arena_mbid;
    }

    function GetName() {
        return stripslashes($this->arena_name);
    }

    function GetStart() {
        $date = getdate($this->arena_start);
        return $date['month']." ".$date['mday'].", ".$date['year'];
    }

    function GetEnd() {
        if ($this->arena_end){
            $date = getdate($this->arena_end);
            return $date['month']." ".$date['mday'].", ".$date['year'];
        } else {
            return "<b>Pending</b>";
        }
    }

    function GetComplete() {
        return ($this->arena_end > 0);
    }

    function GetGraded(){
	    return ($this->arena_graded == 1);
    }
    
    function GetDeleted() {
        return ($this->arena_date_deleted > 0);
    }

    function Edit($name, $mbid) {
        $sql = "UPDATE `arena_ro` SET ";
        $add = array("`id` = '".$this->arena_id."'");
        $return = "";

        if ($name != $this->arena_name){
            array_push($add, "`name` = '".addslashes($name)."'");
            $return .= "Run-On Nickname Edited.<br />";
        }

        if ($mbid != $this->arena_mbid){
            array_push($add, "`mbid` = '$mbid'");
            $return .= "Message Board ID Edited.<br />";
        }

        $sql .= implode(', ', $add);

        $sql .= " WHERE `id` = '".$this->arena_id."'";


        if (mysql_query($sql, $this->connect)){

            return $return;

        } else {

            $arena = new Arena();
	        
            return $arena->NEC(122);

        }

    }

    function Grade($id, $xp, $creds, $first, $posts) {
        $sql = "UPDATE `arena_ro` SET `graded` = '1' WHERE `id` = '".$this->arena_id."'";

        if (mysql_query($sql, $this->connect)) {	  
	        $sql = "INSERT INTO `arena_ro_hunters` VALUES ('$id', '$xp', '$creds', '$first', '$posts', '".$this->arena_id."', 0)";

            if (mysql_query($sql, $this->connect)) {

	            $person = new Person($id, 'fight-51-me');
	            $person->AddCredits($creds, 'Arena Match');
	            
                return true;          
            } else {
	            return false;
            }
        } else {
            return false;
        }

    }
    
    function Post($mbid) {
        $sql = "UPDATE `arena_ro` SET `mbid` = '$mbid' WHERE `id` = '".$this->arena_id."'";

        if (mysql_query($sql, $this->connect)) {	  
			return true;          
        } else {
            return false;
        }

    }

    function Delete() {
        $sql = "UPDATE `arena_ro` SET `date_deleted` = '".time()."' WHERE `id` = '".$this->arena_id."'";

        if (mysql_query($sql, $this->connect)) {
            return true;
        } else {
            return false;
        }
    }
    
    function Undelete() {
        $sql = "UPDATE `arena_ro` SET `date_deleted` = '0' WHERE `id` = '".$this->arena_id."'";

        if (mysql_query($sql, $this->connect)) {
            return true;
        } else {
            return false;
        }
    }

 }

?>