<?

 Class IRCAMatch extends irca {

    var $arena_id;
    var $arena_name;
    var $arena_match;
    var $arena_date;
    var $arena_type;
    var $arena_location;
    var $arena_location_table;
    var $arena_weapons;
    var $arena_weapon_type;
    var $arena_posts;
    var $arena_graded;
    var $arena_comments;
    var $arena_date_deleted;

    function IRCAMatch($id) {
        Arena::Arena();

        $sql = "SELECT * FROM `arena_irca_match` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'arena_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }

    function GetContenders(){
        $sql = "SELECT * FROM `arena_irca_records` WHERE `match_id` = '".$this->arena_id."'";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new IRCAFighter($info['bhg_id'], $this->arena_id);
            array_push($return, $new);
        }

        return $return;

    }

    function GetID() {
        return $this->arena_id;
    }
    
    function GetComments(){
	    return nl2br(stripslashes($this->arena_comments));
    }

    function GetStatus() {
        if ($this->arena_graded){
            return "Graded";
        } else {
            return "Pending Grading";
        }
    }

    function GetOutcome($bhg_id){
        $fighter = new Fighter($bhg_id, $this->GetID());

        return $fighter->GetResult();
    }

    function GetMatchID() {
        return $this->arena_id;
    }

    function GetName() {
        return stripslashes($this->arena_name);
    }

    function GetMatchDate() {
        $date = getdate($this->arena_date);
        return $date['month']." ".$date['mday'].", ".$date['year'];
    }

    function GetWeapons() {
        return $this->arena_weapons;
    }
    
    function GetActions() {
        return $this->arena_posts;
    }
    
    function GetMatch() {
	    return nl2br(stripslashes($this->arena_match));
    }

    function GetComplete() {
        return ($this->arena_graded > 0);
    }

    function GetDeleted() {
        return ($this->arena_date_deleted > 0);
    }

    function GetType() {
        return new Type($this->arena_type);
    }

    function GetLocation() {
        return new Location($this->arena_location, $this->arena_location_table);
    }

    function GetWeaponType() {
        return new WeaponType($this->arena_weapon_type);
    }

    function GetFighters() {
        $sql = "SELECT * FROM `arena_irca_records` WHERE `match_id` = '".$this->arena_id."'";
        $query = mysql_query($sql, $this->connect);

        $return = array();

        while ($result = mysql_fetch_array($query)){
            $fighter = new IRCAFighter($result['bhg_id'], $this->arena_id);
            array_push($return, $fighter);
        }

        return $return;

    }

    function AddMatchText($match){
		$sql = "UPDATE `arena_irca_match` SET `match` = '".addslashes($match)."' WHERE `id` = '".$this->arena_id."'";

        if (mysql_query($sql, $this->connect)) {

        	return true;

        } else {

            return false;

        }

    }

    function Complete($id, $xp, $creds, $outcome, $date = '0', $comment) {
	    
        $sql = "UPDATE `arena_irca_match` SET `graded` = '1', `comments` = '".addslashes($comment)."' WHERE `id` = '".$this->arena_id."'";

        if (mysql_query($sql, $this->connect)) {

            $sql = "UPDATE `arena_irca_records` SET `xp` = '$xp', `credits` = '$creds', `outcome` = '$outcome' WHERE `bhg_id` = '$id' AND `match_id` = '".$this->arena_id."'";

            if (mysql_query($sql, $this->connect)) {

	            
	            $person = new Person($id, 'fight-51-me');
	            $person->AddCredits($creds, 'IRCA Match');
	            
                return true;

            } else {

                return false;

            }

        } else {

            return false;

        }

    }

    function Remove() {
        $sql = "UPDATE `arena_irca_match` SET `date_deleted` = '".time()."' WHERE `id` = '".$this->arena_id."'";

        if (mysql_query($sql, $this->connect)) {
	        
	        $sql = "UPDATE `arena_irca_records` SET `date_deleted` = '".time()."' WHERE `match_id` = '".$this->arena_id."'";
	        mysql_query($sql, $this->connect);

            return true;

        } else {

            return false;

        }

    }
    
    function Undelete() {
        $sql = "UPDATE `arena_irca_match` SET `date_deleted` = '0' WHERE `id` = '".$this->arena_id."'";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }

 }

?>