<?

 Class Option extends Arena {

    var $option_id;
    var $option_question;
    var $option_poll;
    var $option_date_deleted;

    function Option($id) {
        Sheet::Sheet();

        $sql = "SELECT * FROM `arena_poll_options` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'option_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }
    
    function GetID(){
	    return $this->option_id;
    }
    
    function GetPoll(){
	    return new Poll($this->option_poll);
    }
    
    function GetQuestion(){
	    return stripslashes($this->option_question);
    }
    
    function IsDeleted(){
	    return ($this->option_date_deleted > 0);
    }
    
    function Vote($bhg_id){
	    $errors = 0;
	    $sql = "INSERT INTO `arena_poll_votes` (`bhg_id`, `option`, `date`) VALUES ('$bhg_id', '".$this->option_id."', '".time()."')";
	    if (!mysql_query($sql, $this->connect)){
		    $errors++;
	    }
	    
	    return ($errors ? 'Errors occured while voting.' : 'Vote added successfully.');
    }
    
    function GetVotes(){
	    $sql = "SELECT * FROM `arena_poll_votes` WHERE `date_deleted` = 0 AND `option` = '".$this->option_id."'";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();

	    while ($info = mysql_fetch_array($query)){
		    $return[] = new Vote($info['id']);
	    }
	    
	    return $return;
    }
    
    function GetDeleted() {
        if ($this->option_date_delted){
            $date = getdate($this->option_date_delted);
            return $date['month']." ".$date['mday'].", ".$date['year'];
        } else {
            return false;
        }
    }
    
    function Edit($question, $poll) {
        $sql = "UPDATE `arena_poll_options` SET ";
        $add = array("`id` = '".$this->option_id."'");
        $return = "";

        if ($question != $this->option_question){
            array_push($add, "`question` = '".addslashes($question)."'");
            $return .= "Question Edited.<br />";
        }

        if ($poll != $this->option_poll){
            array_push($add, "`poll` = '$poll'");
            $return .= "Poll Edited.<br />";
        }

        $sql .= implode(', ', $add);

        $sql .= " WHERE `id` = '".$this->option_id."'";


        if (mysql_query($sql, $this->connect)){

            return $return;

        } else {

	        $arena = new Arena();
	        
            return $arena->NEC(207);

        }

    }
    
    function Undelete() {
        $sql = "UPDATE `arena_poll_options` SET `date_deleted` = '0' WHERE `id` = '".$this->option_id."'";

        if (mysql_query($sql, $this->connect)) {
            return true;
        } else {
            return false;
        }
    }
    
    function Delete() {
        $sql = "UPDATE `arena_poll_options` SET `date_deleted` = '".time()."' WHERE `id` = '".$this->option_id."'";

        if (mysql_query($sql, $this->connect)) {
            return true;
        } else {
            return false;
        }
    }

 }

?>