<?

 Class StarfieldControl extends Starfield {

    var $new_match_id;

    function StarfieldControl(){
        Arena::Arena();
    }

    function Challenge($type, $restrictions, $settings, $location, $posts, $challenger, $challengee, $ship_id1, $ship_id2, $link){

        $person1 = new Person($challenger);
        $person2 = new Person($challengee);

        $name = $person1->GetName()." vs. ".$person2->GetName();

        $rest = "";

        foreach($restrictions as $value){
            $rest .= $value."_";
        }

        $rest .= "0";

        $restriction = explode("_0", $rest);

        $sql = "INSERT INTO `arena_starfield_match` (`name`, `type`, `restrictions`, `location`, `settings`, `num_posts`) "
                ."VALUES ('".addslashes($name)."', '$type', '".$restriction[0]."', '$location', '$settings', '$posts')";

        if (mysql_query($sql, $this->connect)) {

            $this->new_match_id = mysql_insert_id($this->connect);

            $this->Fighter($challenger, 1, $ship_id1);
            $this->Fighter($challengee, 0, $ship_id2);

            $match = new StarfieldMatch($this->new_match_id);
            $type = $match->GetType();
            $settings = $match->GetSettings();
            $restrictions = $match->WriteRestrictions("\r\n");
            $location = $match->GetLocation();

            $text = $person1->GetName()." has issued a Starfield Arena Challenge to ".$person2->GetName()." with the following details: \r\n"
                    ."Match Type - ".$type->GetName()."\r\n"
                    ."Setting - ".$settings->GetName()."\r\n";

            if ($match->HasLocation()){
                $text .= "Location - ".$location->GetName()."\r\n";
            }

            $text .= "Restrictions\r\n";

            $text .= $restrictions."\r\n";

            $text .= "Ship Data\r\n";

            $text .= $person1."'s Ship: ".$this->ShipName($challenger, $ship_id1)." [ http://mall.thebhg.org/ssl/index.php?frame=registries/item.php&id=".$ship_id1." ]\r\n";
            $text .= "Your Ship: ".$this->ShipName($challengee, $ship_id2)." [ http://mall.thebhg.org/ssl/index.php?frame=registries/item.php&id=".$ship_id2." ]\r\n";

            $text .= "\r\nTo accept this challenge, please go to $link and choose ACCEPT for the pending challenge."
                    ."\r\n\r\n-The Adjunct";

            $from = "Starfield Arena <adjunct@thebhg.org>";
            $subject = "You have been challenged!";

            $person1->SendEmail($from, $subject, $text);
            $person2->SendEmail($from, $subject, $text);


            return true;

        } else {

            return false;

        }

    }

    function Fighter($id, $challenger = '0', $ship_id) {
        $sql = "INSERT INTO `arena_starfield_records` (`bhg_id`, `match_id`, `challenger`, `ship_id`) VALUES ($id, ".$this->new_match_id.", $challenger, $ship_id)";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }

    function NewSetting($name, $description) {
        $sql = "INSERT INTO `arena_starfield_settings` (`name`, `description`) VALUES ('".addslashes($name)."', '".addslashes($description)."')";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }

    function NewRestriction($name, $description) {
        $sql = "INSERT INTO `arena_starfield_restrictions` (`name`, `description`) VALUES ('".addslashes($name)."', '".addslashes($description)."')";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }

    function NewType($name, $description) {
        $sql = "INSERT INTO `arena_starfield_type` (`name`, `description`) VALUES ('".addslashes($name)."', '".addslashes($description)."')";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }

 }

?>