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

        $restriction = serialize($restrictions);

        $new = new Starfield();
    	$skip = $new->CurrentSkipper();
    	$skipper = new Skipper($skip);
        
        $sql = "INSERT INTO `arena_starfield_match` (`name`, `type`, `restrictions`, `location`, `settings`, `num_posts`, `skipper`) "
                ."VALUES ('".addslashes($name)."', '$type', '".$restriction."', '$location', '$settings', '$posts', '".$skipper->GetID()."')";

        if (mysql_query($sql, $this->connect)) {

            $this->new_match_id = mysql_insert_id($this->connect);

            $this->Fighter($challenger, 1, $ship_id1);
            $this->Fighter($challengee, 0, $ship_id2);

            $text = $person1->GetName()." has issued a Starfield Arena Challenge to ".$person2->GetName().".";

            $from = "overseer@thebhg.org";
            $subject = "You have been challenged!";

            $person1->SendEmail($from, $subject, $text);
            $person2->SendEmail($from, $subject, $text);


            return true;

        } else {

            return false;

        }

    }

    function OldMatch($type, $restrictions, $settings, $location, $posts, $challenger, $challengee, $ship_id1, $ship_id2, $name){

	    $new = new Starfield();
    	$skip = $new->CurrentSkipper();
    	$skipper = new Skipper($skip);
    	
        $person1 = new Person($challenger);
        $person2 = new Person($challengee);

        if ($name == ''){
        	$name = $person1->GetName()." vs. ".$person2->GetName();
    	}

        $restriction = serialize($restrictions);
        
        $sql = "INSERT INTO `arena_starfield_match` (`name`, `type`, `restrictions`, `location`, `settings`, `num_posts`, `skipper`, `accepted`) "
                ."VALUES ('".addslashes($name)."', '$type', '".$restriction."', '$location', '$settings', '$posts', '".$skipper->GetID()."', 1)";

        if (mysql_query($sql, $this->connect)) {

	        $this->new_match_id = mysql_insert_id($this->connect);
	        
	        $this->Fighter($challenger, 1, $ship_id1);
            $this->Fighter($challengee, 0, $ship_id2);
	        
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