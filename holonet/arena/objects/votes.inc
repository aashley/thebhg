<?

 Class Vote extends Arena {

    var $vote_id;
    var $vote_bhg_id;
    var $vote_option;
    var $vote_date;
    var $vote_date_deleted;

    function Vote($id) {
        Sheet::Sheet();

        $sql = "SELECT * FROM `arena_poll_votes` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'vote_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }
    
    function GetID(){
	    return $this->vote_id;
    }
    
    function GetVoter(){
	    return new Person($this->vote_bhg_id);
    }
    
    function GetOption(){
	    return new Option($this->vote_option);
    }
    
    function GetPoll(){
	    $option = $this->GetOption();
	    return $option->GetPoll();
    }
    
    function GetQuestion(){
	    $option = $this->GetOption();
	    return $option->GetQuestion();
    }
    
    function IsDeleted(){
	    return ($this->vote_date_deleted > 0);
    }
    
    function GetDeleted() {
        if ($this->vote_date_delted){
            $date = getdate($this->vote_date_delted);
            return $date['month']." ".$date['mday'].", ".$date['year'];
        } else {
            return false;
        }
    }
    
    function Undelete() {
        $sql = "UPDATE `arena_poll_votes` SET `date_deleted` = '0' WHERE `id` = '".$this->vote_id."'";

        if (mysql_query($sql, $this->connect)) {
            return true;
        } else {
            return false;
        }
    }
    
    function Delete() {
        $sql = "UPDATE `arena_poll_votes` SET `date_deleted` = '".time()."' WHERE `id` = '".$this->vote_id."'";

        if (mysql_query($sql, $this->connect)) {
            return true;
        } else {
            return false;
        }
    }

 }

?>