<?

 Class ROHunter extends RO {

    var $arena_bhg_id;
    var $arena_xp;
    var $arena_creds;
    var $arena_first;
    var $arena_run_on;

    function ROHunter($id, $match) {
        Arena::Arena();

        $sql = "SELECT * FROM `arena_ro_hunters` WHERE `bhg_id` = '$id' and `run_on` = '$match'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'arena_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }

    function GetID() {
        return $this->arena_bhg_id;
    }

    function GetName(){

        $person = new Person($this->arena_bhg_id);

        return $person->GetName();
    }

    function GetXP() {
        return $this->arena_xp;
    }

    function GetCredits() {
        return $this->arena_creds;
    }

    function GetRunOn() {
        return new RunOn($this->arena_run_on);
    }

    function IsWinner(){
	    return ($this->arena_first == 1);
    }
    
    function GetStats() {
        return new ROStats($this->arena_bhg_id);
    }
    
    function Delete() {
        $sql = "UPDATE `arena_ro_hunters` SET `date_deleted` = '".time()."' WHERE `run_on` = '".$this->arena_run_on."'";

        if (mysql_query($sql, $this->connect)) {
            return true;
        } else {
            return false;
        }
    }
    
    function Undelete() {
        $sql = "UPDATE `arena_ro_hunters` SET `date_deleted` = '0' WHERE `run_on` = '".$this->arena_run_on."'";

        if (mysql_query($sql, $this->connect)) {
            return true;
        } else {
            return false;
        }
    }

 }

?>