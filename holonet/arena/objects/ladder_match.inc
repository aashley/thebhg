<?

 Class Match extends Ladder {

    var $arena_id;
    var $arena_match_id;
    var $arena_is_ttg;
    var $arena_name;
    var $arena_start;
    var $arena_end;
    var $arena_type;
    var $arena_location;
    var $arena_location_table;
    var $arena_weapons;
    var $arena_weapon_type;
    var $arena_num_posts;
    var $arena_accepted;
    var $arena_date_deleted;

    function Match($id) {
        Arena::Arena();

        $sql = "SELECT * FROM `arena_ladder_match` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'arena_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }

    function GetChallenger(){
        $sql = "SELECT * FROM `arena_ladder_records` WHERE `match_id` = '".$this->GetID()."' AND `challenger` = 1";
        $query = mysql_query($sql, $this->connect);

        $info = mysql_fetch_array($query);

        return new Fighter($info['bhg_id'], $this->arena_id);

    }
    
    function IsDojo(){
	    $location = $this->GetLocation();
	    
	    if ($location->GetID() == 31 && $location->GetTable() == 'complex'){
		    return true;
	    } else {
		    return false;
	    }
    }

    function GetChallengee(){
        $sql = "SELECT * FROM `arena_ladder_records` WHERE `match_id` = '".$this->arena_id."' AND `challenger` = 0";
        $query = mysql_query($sql, $this->connect);

        $info = mysql_fetch_array($query);

        return new Fighter($info['bhg_id'], $this->arena_id);

    }

    function IsTTG(){
	    return ($this->arena_is_ttg == 1);
    }
    
    function Accept() {
        $sql = "UPDATE `arena_ladder_match` SET `accepted` = '1' WHERE `id` = '".$this->arena_id."'";

        if (mysql_query($sql, $this->connect)) {

            $contenders = $this->GetContenders();

            $person1 = new Person($contenders[1]->GetID());
            $person2 = new Person($contenders[0]->GetID());
            $adjunct = $this->Adjunct();
            $overseer = $this->Overseer();

            $type = $this->GetType();
            $location = $this->GetLocation();
            $weapon = $this->GetWeaponType();

            $text = $person1->GetName()."'s Arena Challenge to ".$person2->GetName()." was accepted. Here are the details of the match:"
                    ."\r\nMatch Type - ".$type->GetName()
                    ."\r\nLocation - ".$location->GetName()
                    ."\r\nWeapon Types - ".$weapon->GetWeapon()
                    ."\r\nWeapons - ".$this->GetWeapons()
                    ."\r\nPosts - ".$this->GetPosts();
                    
            $staff = '';
            
            if ($this->IsDojo()){
	            $text .= "\r\nThis match is a Dojo of Shadows match and will be found there instead of on the Arena Board.";
	            $staff = "Dojo Master, ";
            }
            
            $staff .= "Overseer, or Adjunct.";

            $text .= "\r\nYou will be notified when your match has been posted on the boards by the $staff"
                    ."\r\n\r\n-The Overseer";

            $from = "Arena <overseer@thebhg.org>";
            $subject = "Challenge Accepted!";

            $person1->SendEmail($from, $subject, $text);
            $person2->SendEmail($from, $subject, $text);
            $adjunct->SendEmail($from, $subject, $text);
            $overseer->SendEmail($from, $subject, $text);
            
            if ($this->IsDojo()){
	            $ladder = new Ladder();
	            $master = new Person($ladder->CurrentMaster());
	            $master->SendEmail($from, $subject, $text);
            }

            return true;

        } else {

            return false;

        }

    }

    function Decline() {
        $sql = "UPDATE `arena_ladder_match` SET `date_deleted` = '1' WHERE `id` = '".$this->arena_id."'";

        if (mysql_query($sql, $this->connect)) {
	        
	        $sql = "UPDATE `arena_starfield_records` SET `date_deleted` = '1' WHERE `match_id` = '".$this->arena_starfield_id."'";
	        mysql_query($sql, $this->connect);

            $contenders = $this->GetContenders();

            $person1 = new Person($contenders[1]->GetID());
            $person2 = new Person($contenders[0]->GetID());

            $type = $this->GetType();
            $location = $this->GetLocation();
            $weapon = $this->GetWeaponType();

            $text = $person1->GetName()."'s Arena Challenge to ".$person2->GetName()." was declined. These were the details of the match:"
                    ."\r\nMatch Type - ".$type->GetName()
                    ."\r\nLocation - ".$location->GetName()
                    ."\r\nWeapon Types - ".$weapon->GetWeapon()
                    ."\r\nWeapons - ".$this->GetWeapons()
                    ."\r\nPosts - ".$this->GetPosts();

            $text .= "\r\nThank you for using the Arena Challenge Network.";

            $from = "Arena <overseer@thebhg.org>";
            $subject = "Challenge Declined!";

            $person1->SendEmail($from, $subject, $text);
            $person2->SendEmail($from, $subject, $text);

            return true;

        } else {

            return false;

        }

    }

    function Remove() {
        $sql = "UPDATE `arena_ladder_match` SET `date_deleted` = '".time()."' WHERE `id` = '".$this->arena_id."'";

        if (mysql_query($sql, $this->connect)) {

	        $sql = "UPDATE `arena_ladder_records` SET `date_deleted` = '".time()."' WHERE `match_id` = '".$this->arena_id."'";
	        mysql_query($sql, $this->connect);
	        
            $contenders = $this->GetContenders();

            $person1 = new Person($contenders[1]->GetID());
            $person2 = new Person($contenders[0]->GetID());

            $type = $this->GetType();
            $location = $this->GetLocation();
            $weapon = $this->GetWeaponType();

            $text = $person1->GetName()."'s Arena Challenge to ".$person2->GetName()." was removed by the Overseer."
                    ."\r\nMatch Type - ".$type->GetName()
                    ."\r\nLocation - ".$location->GetName()
                    ."\r\nWeapon Types - ".$weapon->GetWeapon()
                    ."\r\nWeapons - ".$this->GetWeapons()
                    ."\r\nPosts - ".$this->GetPosts();

            $text .= "\r\nThank you for using the Arena Challenge Network.";

            $from = "Arena <overseer@thebhg.org>";
            $subject = "Challenge Removed!";

            $person1->SendEmail($from, $subject, $text);
            $person2->SendEmail($from, $subject, $text);

            return true;

        } else {

            return false;

        }

    }

    function GetContenders(){
        $sql = "SELECT * FROM `arena_ladder_records` WHERE `match_id` = '".$this->arena_id."'";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Fighter($info['bhg_id'], $this->arena_id);
            array_push($return, $new);
        }

        return $return;

    }

    function GetID() {
        return $this->arena_id;
    }

    function GetStatus() {
        if ($this->arena_date_deleted == 1){
            return "Declined";
        } elseif ($this->arena_accepted){
            return "Accepted";
        } else {
            return "Pending";
        }
    }

    function GetOutcome($bhg_id){
        $fighter = new Fighter($bhg_id, $this->GetID());

        return $fighter->GetResult();
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
        return $this->arena_match_id;
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

    function GetWeapons() {
        return $this->arena_weapons;
    }

    function GetPosts() {
        return $this->arena_num_posts;
    }

    function GetComplete() {
        return ($this->arena_end > 0);
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

    function StartMatch($id, $send_mail = true) {
        $sql = "UPDATE `arena_ladder_match` SET `match_id` = '$id', `start` = ".time()." WHERE `id` = '".$this->arena_id."'";

        if (mysql_query($sql, $this->connect)) {

	        if ($send_mail){
	            $contenders = $this->GetContenders();
	
	            $person1 = new Person($contenders[1]->GetID());
	            $person2 = new Person($contenders[0]->GetID());
	
	            $text = "Your arena match has been posted.\r\n\r\n".$this->RawLink($id);
	
	            $text .= "\r\nThank you for using the Arena Challenge Network.";
	
	            $from = "Arena <overseer@thebhg.org>";
	            $subject = "Match Posted!";
	
	            $person1->SendEmail($from, $subject, $text);
	            $person2->SendEmail($from, $subject, $text);
            }

            return true;

        } else {

            return false;

        }

    }

    function Edit($name, $location, $location_table, $weapons, $weapon_type, $posts, $match_id, $type) {
        $sql = "UPDATE `arena_ladder_match` SET ";
        $add = array("`id` = '".$this->arena_id."'");
        $return = "";

        if ($name != $this->arena_name){
            array_push($add, "`name` = '".addslashes($name)."'");
            $return .= "Match Nickname Edited.<br />";
        }

        if ($location != $this->arena_location){
            array_push($add, "`location` = '$location'");
            $return .= "Location Edited.<br />";
        }

        if ($location_table != $this->arena_location_table){
            array_push($add, "`location_table` = '$location_table'");
            $return .= "Location Table Edited.<br />";
        }

        if ($weapons != $this->arena_weapons){
            array_push($add, "`weapons` = '$weapons'");
            $return .= "Number of Weapons Edited.<br />";
        }

        if ($weapon_type != $this->arena_weapon_type){
            array_push($add, "`weapon_type` = '$weapon_type'");
            $return .= "Weapon Type Edited.<br />";
        }

        if ($posts != $this->arena_num_posts){
            array_push($add, "`num_posts` = '$posts'");
            $return .= "Number of Posts Edited.<br />";
        }

        if ($match_id != $this->arena_match_id){
            array_push($add, "`match_id` = '$match_id'");
            $return .= "Message Board ID Edited.<br />";
        }

        if ($type != $this->arena_type){
            array_push($add, "`type` = '$type'");
            $return .= "Match Type Edited.<br />";
        }

        $sql .= implode(', ', $add);

        $sql .= " WHERE `id` = '".$this->arena_id."'";


        if (mysql_query($sql, $this->connect)){

            return $return;

        } else {

            return 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 72';

        }

    }

    function RemoveContender($id) {
        $sql = "DELETE FROM `arena_ladder_records` WHERE `bhg_id` = '$id' AND `match_id` = '".$this->arena_id."'";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }

    function GetFighters() {
        $sql = "SELECT * FROM `arena_ladder_records` WHERE `match_id` = '".$this->arena_id."'";
        $query = mysql_query($sql, $this->connect);

        $return = array();

        while ($result = mysql_fetch_array($query)){
            $fighter = new Fighter($result['bhg_id'], $this->arena_id);
            array_push($return, $fighter);
        }

        return $return;

    }


    function Complete($id, $xp, $creds, $outcome, $date = '0') {

        if ($date == 0){
            $end = time();
        } else {
            $end = $this->date2unix($date);
        }

        $sql = "UPDATE `arena_ladder_match` SET `end` = '$end' WHERE `id` = '".$this->arena_id."'";

        if (mysql_query($sql, $this->connect)) {

            $sql = "UPDATE `arena_ladder_records` SET `xp` = '$xp', `credits` = '$creds', `outcome` = '$outcome' WHERE `bhg_id` = '$id' AND `match_id` = '".$this->arena_id."'";

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

    function Undelete() {
        $sql = "UPDATE `arena_ladder_match` SET `date_deleted` = '0' WHERE `id` = '".$this->arena_id."'";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }

 }

?>