<?

 Class StarfieldMatch extends Starfield {

    var $arena_starfield_id;
    var $arena_starfield_match_id;
    var $arena_starfield_name;
    var $arena_starfield_start;
    var $arena_starfield_end;
    var $arena_starfield_type;
    var $arena_starfield_settings;
    var $arena_starfield_location;
    var $arena_starfield_restrictions;
    var $arena_starfield_num_posts;
    var $arena_starfield_date_deleted;

    function StarfieldMatch($id) {
        Arena::Arena();

        $sql = "SELECT * FROM `arena_starfield_match` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'arena_starfield_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }

    function GetChallenger(){
        $sql = "SELECT * FROM `arena_starfield_records` WHERE `match_id` = ".$this->arena_starfield_id." AND `challenger` = 1";
        $query = mysql_query($sql, $this->connect);

        $info = mysql_fetch_array($query);

        return new StarfieldFighter($info['bhg_id'], $this->arena_starfield_id);

    }

    function GetChallengee(){
        $sql = "SELECT * FROM `arena_starfield_records` WHERE `match_id` = ".$this->arena_starfield_id." AND `challenger` = 0";
        $query = mysql_query($sql, $this->connect);

        $info = mysql_fetch_array($query);

        return new StarfieldFighter($info['bhg_id'], $this->arena_starfield_id);

    }

    function GetContenders(){
        $sql = "SELECT * FROM `arena_starfield_records` WHERE `match_id` = '".$this->arena_starfield_id."'";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new StarfieldFighter($info['bhg_id'], $this->arena_starfield_id);
            array_push($return, $new);
        }

        return $return;

    }

    function GetID() {
        return $this->arena_starfield_id;
    }

    function GetOutcome($bhg_id){
        $fighter = new StarfieldFighter($bhg_id, $this->GetID());

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
        return $this->arena_starfield_match_id;
    }

    function GetName() {
        return stripslashes($this->arena_starfield_name);
    }

    function GetStart() {
        $date = getdate($this->arena_starfield_start);
        return $date['month']." ".$date['mday'].", ".$date['year'];
    }

    function GetStartBox() {
        $date = getdate($this->arena_starfield_start);
        return $date['mon']."-".$date['mday']."-".$date['year'];
    }

    function GetEnd() {
        if ($this->arena_starfield_end){
            $date = getdate($this->arena_starfield_end);
            return $date['month']." ".$date['mday'].", ".$date['year'];
        } else {
            return "<b>Pending</b>";
        }
    }

    function GetEndBox() {
        $date = getdate($this->arena_starfield_end);
        return $date['mon']."-".$date['mday']."-".$date['year'];
    }

    function GetRestrictions() {

	    if ($this->arena_starfield_restrictions == 0){
		    $restrictions = array();
	    } else {
        	$restrictions = explode("_", $this->arena_starfield_restrictions);
		}
		
        return $restrictions;
    }

    function WriteRestrictions($end = '<br />') {
        $return = "";

        if (count($this->GetRestrictions()) > 0){

            foreach($this->GetRestrictions() as $value){
                $info = new Restriction($value);
                $return .= $info->GetName().$end;
            }

        } else {

            $return = "None";
        }

        return $return;
    }

    function GetPosts() {
        return $this->arena_starfield_num_posts;
    }

    function GetComplete() {
        return ($this->arena_starfield_end > 0);
    }

    function GetDeleted() {
        return ($this->arena_starfield_date_deleted > 0);
    }

    function GetType() {
        return new StarfieldType($this->arena_starfield_type);
    }

    function GetLocation() {
        if ($this->HasLocation()){
            return new StarfieldLocation($this->arena_starfield_location);
        } else {
            return "No location specified";
        }
    }

    function GetSettings() {
        return new Setting($this->arena_starfield_settings);
    }

    function HasLocation(){
        return ($this->arena_starfield_location > 0);
    }

    function IsRestriction($id){
        $restrictions = $this->GetRestrictions();
        
        return in_array($id, $restrictions);
    }

    function GetStatus() {
        if ($this->arena_starfield_date_deleted == 1){
            return "Declined";
        } elseif ($this->arena_starfield_accepted){
            return "Accepted";
        } else {
            return "Pending";
        }
    }

    function Accept() {
        $sql = "UPDATE `arena_starfield_match` SET `accepted` = '1' WHERE `id` = '".$this->arena_starfield_id."'";

        if (mysql_query($sql, $this->connect)) {

            $contenders = $this->GetContenders();

            $person1 = new Person($contenders[1]->GetID());
            $person2 = new Person($contenders[0]->GetID());
            $adjunct = $this->Adjunct();
            $overseer = $this->Overseer();

            $type = $this->GetType();
            $settings = $this->GetSettings();
            $restrictions = $this->WriteRestrictions("\n");
            $location = $this->GetLocation();

            $text = $person1->GetName()."'s Starfield Arena Challenge to ".$person2->GetName()." was accepted. Here are the details of the match:"
                    ."\nMatch Type - ".$type->GetName()
                    ."\nSetting - ".$settings->GetName();

            if ($this->HasLocation()){
                $text .= "\nLocation - ".$location->GetName();
            }

            $text .= "\nRestrictions";

            $text .= "\n".$restrictions;

            $text .= "\nShip Data";

            $text .= "\n".$person1->GetName()."'s Ship: ".$this->ShipName($challenger, $ship_id1)." [ http://mall.thebhg.org/ssl/index.php?frame=registries/item.php&id=".$ship_id1." ]\n";
            $text .= "\nYour Ship: ".$this->ShipName($challengee, $ship_id2)." [ http://mall.thebhg.org/ssl/index.php?frame=registries/item.php&id=".$ship_id2." ]\n";

            $text .= "\nYou will be notified when your match has been posted on the boards by the Overseer or Adjunct."
                    ."\n\n-The Adjunct";

            $from = "Starfield Arena <adjunct@thebhg.org>";
            $subject = "Challenge Accepted!";

            $person1->SendEmail($from, $subject, $text);
            $person2->SendEmail($from, $subject, $text);
            $adjunct->SendEmail($from, $subject, $text);
            $overseer->SendEmail($from, $subject, $text);

            return true;

        } else {

            return false;

        }

    }

    function Decline() {
        $sql = "UPDATE `arena_starfield_match` SET `date_deleted` = '1' WHERE `id` = '".$this->arena_starfield_id."'";

        if (mysql_query($sql, $this->connect)) {

            $contenders = $this->GetContenders();

            $person1 = new Person($contenders[1]->GetID());
            $person2 = new Person($contenders[0]->GetID());

            $type = $this->GetType();
            $settings = $this->GetSettings();
            $restrictions = $this->WriteRestrictions("\n");
            $location = $this->GetLocation();

            $text = $person1->GetName()."'s Starfield Arena Challenge to ".$person2->GetName()." was declined. Here are the details of the match:"
                    ."\nMatch Type - ".$type->GetName()
                    ."\nSetting - ".$settings->GetName();

            if ($this->HasLocation()){
                $text .= "\nLocation - ".$location->GetName();
            }

            $text .= "\nRestrictions";

            $text .= "\n".$restrictions;

            $text .= "\nShip Data";

            $text .= "\n".$person1->GetName()."'s Ship: ".$this->ShipName($challenger, $ship_id1)." [ http://mall.thebhg.org/ssl/index.php?frame=registries/item.php&id=".$ship_id1." ]";
            $text .= "\nYour Ship: ".$this->ShipName($challengee, $ship_id2)." [ http://mall.thebhg.org/ssl/index.php?frame=registries/item.php&id=".$ship_id2." ]";

            $text .= "\nThank you for using the Arena Challenge Network.";

            $from = "Starfield Arena <adjunct@thebhg.org>";
            $subject = "Challenge Declined!";

            $person1->SendEmail($from, $subject, $text);
            $person2->SendEmail($from, $subject, $text);

            return true;

        } else {

            return false;

        }

    }

    function Remove() {
        $sql = "UPDATE `arena_starfield_match` SET `date_deleted` = '".time()."' WHERE `id` = '".$this->arena_starfield_id."'";

        if (mysql_query($sql, $this->connect)) {

            $contenders = $this->GetContenders();

            $person1 = new Person($contenders[1]->GetID());
            $person2 = new Person($contenders[0]->GetID());

            $type = $this->GetType();
            $settings = $this->GetSettings();
            $restrictions = $this->WriteRestrictions("\n");
            $location = $this->GetLocation();

            $text = $person1->GetName()."'s Starfield Arena Challenge to ".$person2->GetName()." was declined. Here are the details of the match:"
                    ."\nMatch Type - ".$type->GetName()
                    ."\nSetting - ".$settings->GetName();

            if ($match->HasLocation()){
                $text .= "\nLocation - ".$location->GetName();
            }

            $text .= "\nRestrictions";

            $text .= "\n".$restrictions;

            $text .= "\nShip Data";

            $text .= "\n".$person1."'s Ship: ".$this->ShipName($challenger, $ship_id1)." [ http://mall.thebhg.org/ssl/index.php?frame=registries/item.php&id=".$ship_id1." ]";
            $text .= "\nYour Ship: ".$this->ShipName($challengee, $ship_id2)." [ http://mall.thebhg.org/ssl/index.php?frame=registries/item.php&id=".$ship_id2." ]";

            $text .= "\nThank you for using the Arena Challenge Network.";

            $from = "Starfield Arena <adjunct@thebhg.org>";
            $subject = "Challenge Removed!";

            $person1->SendEmail($from, $subject, $text);
            $person2->SendEmail($from, $subject, $text);

            return true;

        } else {

            return false;

        }

    }

    function WriteShips(){
        $sql = "SELECT * FROM `arena_starfield_records` WHERE `match_id` = '".$this->arena_starfield_id."'";
        $query = mysql_query($sql, $this->connect);
        $return = "";

        while ($info = mysql_fetch_array($query)){
            $person = new Fighter($info['bhg_id'], $this->arena_starfield_id);

            $return .= $person->GetName()." :: ".$this->GetShipMBLink()."<br />";
        }

        return $return;
    }

    function StartMatch($id) {
        $sql = "UPDATE `arena_starfield_match` SET `match_id` = '$id', `start` = ".time()." WHERE `id` = '".$this->arena_starfield_id."'";

        if (mysql_query($sql, $this->connect)) {

            $contenders = $this->GetContenders();

            $person1 = new Person($contenders[1]->GetID());
            $person2 = new Person($contenders[0]->GetID());

            $text = "Your starfield arena match has been posted.\n\n".$this->RawLink($id);

            $text .= "\nThank you for using the Arena Challenge Network.";

            $from = "Starfield Arena <overseer@thebhg.org>";
            $subject = "Match Posted!";

            $person1->SendEmail($from, $subject, $text);
            $person2->SendEmail($from, $subject, $text);

            return true;

        } else {

            return false;

        }

    }

    function Edit($name, $location, $settings, $restrictions, $posts, $match_id, $type) {
        $sql = "UPDATE `arena_starfield_match` SET `id` = '".$this->arena_starfield_id."'";
        $add = array();
        $return = "";

        $rest = "";

        foreach($restrictions as $value){
            $rest .= $value."_";
        }

        $rest .= "0";

        $restriction = explode("_0", $rest);

        if ($name != $this->arena_starfield_name){
            array_push($add, "`name` = '$name'");
            $return .= "Match Nickname Edited.<br />";
        }

        if ($location != $this->arena_starfield_location){
            array_push($add, "`location` = '$location'");
            $return .= "Location Edited.<br />";
        }

        if ($settings != $this->arena_starfield_settings){
            array_push($add, "`settings` = '$settings'");
            $return .= "Match Settings Edited.<br />";
        }

        if ($restriction[0] != $this->arena_starfield_restrictions){
            array_push($add, "`restrictions` = '".$restriction[0]."'");
            $return .= "Match Restructions Edited.<br />";
        }

        if ($posts != $this->arena_starfield_num_posts){
            array_push($add, "`num_posts` = '$posts'");
            $return .= "Number of Posts Edited.<br />";
        }

        if ($match_id != $this->arena_starfield_match_id){
            array_push($add, "`match_id` = '$match_id'");
            $return .= "Message Board ID Edited.<br />";
        }

        if ($type != $this->arena_starfield_type){
            array_push($add, "`type` = '$type'");
            $return .= "Match Type Edited.<br />";
        }

        $sql .= implode(', ', $add);

        $sql .= " WHERE `id` = '".$this->arena_starfield_id."'";

        if (mysql_query($sql, $this->connect)){

            return $return;

        } else {

            return 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 50';

        }

    }

    function RemoveContender($id) {
        $sql = "DELETE FROM `arena_starfield_records` WHERE `bhg_id` = '$id' AND `match_id` = '".$this->arena_starfield_id."'";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }

    function GetFighters() {
        $sql = "SELECT * FROM `arena_starfield_records` WHERE `match_id` = '".$this->arena_starfield_id."'";
        $query = mysql_query($sql, $this->connect);

        $return = array();

        while ($result = mysql_fetch_array($query)){
            $fighter = new StarfieldFighter($result['bhg_id'], $this->arena_starfield_id);
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

        $sql = "UPDATE `arena_starfield_match` SET `end` = '$end' WHERE `id` = '".$this->arena_starfield_id."'";

        if (mysql_query($sql, $this->connect)) {

            $sql = "UPDATE `arena_starfield_records` SET `xp` = '$xp', `credits` = '$creds', `outcome` = '$outcome' WHERE `bhg_id` = '$id' AND `match_id` = '".$this->arena_starfield_id."'";

            if (mysql_query($sql, $this->connect)) {

	            //Edit out until get coder id
	            //$person = new Person($id);
	            //$person->AddCredits($creds);
	            
                return true;

            } else {

                return false;

            }

        } else {

            return false;

        }

    }


    function Undelete() {
        $sql = "UPDATE `arena_starfield_match` SET `date_deleted` = '0' WHERE `id` = '".$this->arena_starfield_id."'";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }

 }

?>