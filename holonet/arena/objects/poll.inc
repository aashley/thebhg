<?

 Class Poll extends Arena {

    var $poll_id;
    var $poll_question;
    var $poll_poster;
    var $poll_rpa;
    var $poll_multiple;
    var $poll_open_to;
    var $poll_starts;
    var $poll_ends;
    var $poll_date_deleted;

    function Poll($id) {
        Sheet::Sheet();

        $sql = "SELECT * FROM `arena_poll` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'poll_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }
    
    function GetID(){
	    return $this->poll_id;
    }
    
    function GetQuestion(){
	    return stripslashes($this->poll_question);
    }
    
    function GetRPA(){
	    $arena = new Arena();
	    return $arena->ArenaPosition($this->poll_rpa);
    }
    
    function GetRPAKey(){
	    return $this->poll_rpa;
    }
    
    function GetMultiple(){
	    return ($this->poll_multiple == 1);
    }
    
    function GetOpen(){
	    return unserialize($this->poll_open_to);
    }
    
    function GetStarts(){
	    return $this->poll_starts;
    }
    
    function GetEnds(){
	    return $this->poll_ends;
    }
    
    function GetStart() {
        $date = getdate($this->GetStarts());
        return $date['month']." ".$date['mday'].", ".$date['year'];
    }

    function GetDeleted() {
        if ($this->poll_date_delted){
            $date = getdate($this->poll_date_delted);
            return $date['month']." ".$date['mday'].", ".$date['year'];
        } else {
            return false;
        }
    }
    
    function GetEnd() {
        if ($this->GetEnds() > time()){
            $date = getdate($this->GetEnds());
            return $date['month']." ".$date['mday'].", ".$date['year'];
        } else {
            return format_time(time()-$this->GetEnds());
        }
    }
    
    function IsDeleted(){
	    return ($this->date_deleted > 0);
    }
    
    function SetOptions($options){
	    $errors = 0;
	    foreach ($options as $question){
		    $sql = "INSERT INTO `arena_poll_options` (`poll`, `question`) VALUES ('".$this->poll_id."', '".addslashes($question)."')";
		    if (!mysql_query($sql, $this->connect)){
			    $errors++;
		    }
	    }
	    
	    return ($errors ? 'Errors occured while writing options.' : 'Options added successfully.');
    }
    
    function GetOptions($delete = 1){
	    if ($delete){
	    $sql = "SELECT * FROM `arena_poll_options` WHERE $del `poll` = '".$this->poll_id."'";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $return[] = new Option($info['id']);
	    }
	    
	    return $return;
    }
    
    function GetVotes(){
	    $votes = array();
	    $total = 0;
	    foreach ($this->GetOptions() as $option){
		    $votes[$option->GetID()] = $option->GetVotes();
		    $total += count($option->GetVotes());
	    }
	    $votes['total'] = $total;
	    
	    return $votes;
    }
    
    function Edit($question, $poster, $rpa, $multiple, $open_to, $starts, $ends) {
        $sql = "UPDATE `arena_poll` SET ";
        $add = array("`id` = '".$this->poll_id."'");
        $return = "";

        if ($question != $this->poll_question){
            array_push($add, "`question` = '".addslashes($question)."'");
            $return .= "Question Edited.<br />";
        }

        if ($poster != $this->poll_poster){
            array_push($add, "`poster` = '$poster'");
            $return .= "Poster Edited.<br />";
        }

        if ($rpa != $this->poll_rpa){
            array_push($add, "`rpa` = '".addslashes($rpa)."'");
            $return .= "Location Table Edited.<br />";
        }

        if ($multiple != $this->poll_multiple){
            array_push($add, "`multiple` = '$multiple'");
            $return .= "Multiple Answer Option Edited.<br />";
        }

        if ($open_to != $this->GetOpen()){
            array_push($add, "`open_to` = '".serialize($open_to)."'");
            $return .= "Open To Option Edited.<br />";
        }

        if ($starts != $this->poll_starts){
            array_push($add, "`starts` = '$starts'");
            $return .= "Start Date Edited.<br />";
        }

        if ($ends != $this->poll_ends){
            array_push($add, "`ends` = '$ends'");
            $return .= "End Date Edited.<br />";
        }

        $sql .= implode(', ', $add);

        $sql .= " WHERE `id` = '".$this->poll_id."'";


        if (mysql_query($sql, $this->connect)){

            return $return;

        } else {

	        $arena = new Arena();
	        
            return $arena->NEC(206);

        }

    }
    
    function DidVote($bhg_id){
	    $votes = 0;
	    foreach ($this->GetOptions() as $option){
	    	$sql = "SELECT * FROM `arena_poll_votes` WHERE `bhg_id` = '".$hunter->GetID()."' AND `date_deleted` = '0' AND `option` = '".$option->GetID()."'";
		    $query = mysql_query($sql, $this->connect);
		    $votes += mysql_num_rows($query);
	    }
	    return $votes;
    }
	    
    function CanSubmit($hunter, $aas){
	    $div = $hunter->GetDivision();
	    $pos = $hunter->GetPosition();
	    
	    $open = $this->GetOpen();
	    $aas = array_keys($aas);
	    
	    $sql = "SELECT * FROM `arena_poll_bans` WHERE `bhg_id` = '".$hunter->GetID()."' AND `date` >= '".time()."'";
	    $query = mysql_query($sql, $this->connect);
	    
	    if (count($open)){	    
		    if (!$this->DidVote()){
			    if (!mysql_num_rows($query)){	    
				    if (in_array($div->GetID(), $open['divisions'])){
					    return true;
				    } else {
					    if (in_array($aas, $open['aas'])){
						    return true;
					    } else {
						    if (count($aas) && $open['aa']){
							    return true;
						    } else {
							    if (in_array($pos->GetID(), $open['positions'])){
								    return true;
							    } else {
								    return false;
						    	}
					    	}
				    	}
			    	}
				} else {
					$info = mysql_fetch_array($query);
					$date = getdate($info['date']);
		            $date = $date['month']." ".$date['mday'].", ".$date['year'];
					echo 'You are banned from participating in polls until '.$date;
					return false;
				}
			} else {
				echo 'You have already voted for this poll';
				return false;
			}
		} else {
			return true;
		}
	}
    
    function WriteResults(){
	    $votes = $this->GetVotes();
    }
    
    function Undelete() {
        $sql = "UPDATE `arena_poll` SET `date_deleted` = '0' WHERE `id` = '".$this->poll_id."'";

        if (mysql_query($sql, $this->connect)) {
            return true;
        } else {
            return false;
        }
    }
    
    function Delete() {
        $sql = "UPDATE `arena_poll` SET `date_deleted` = '".time()."' WHERE `id` = '".$this->poll_id."'";

        if (mysql_query($sql, $this->connect)) {
            return true;
        } else {
            return false;
        }
    }

 }

?>