<?

 Class IRCAControl extends IRCA {

    var $new_match_id;

    function IRCAControl(){
        Arena::Arena();
    }
    
    function LastInsert(){
	    return $this->new_match_id;
    }
    
    function OldMatch($type, $location, $location_table, $weapons, $challenger, $challengee, $weapon_type, $posts, $name){

        $person1 = new Person($challenger);
        $person2 = new Person($challengee);

        if ($name == 0){
        	$name = $person1->GetName()." vs. ".$person2->GetName();
    	}

    	$irca = new IRCA();
    	$hc = $irca->CurrentHC();
    	
        $sql = "INSERT INTO `arena_irca_match` (`name`, `type`, `location`, `location_table`, `weapons`, `weapon_type`, `posts`, `date`, `hc`) "
                ."VALUES ('".addslashes($name)."', '$type', '$location', '$location_table', '$weapons', '$weapon_type', '$posts', '".time()."', '$hc')";
                
        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }
    
    function NewMatch($type, $location, $location_table, $weapons, $challenger, $challengee, $weapon_type, $match, $posts){

        $person1 = new Person($challenger);
        $person2 = new Person($challengee);

        $name = $person1->GetName()." vs. ".$person2->GetName();

        $sql = "INSERT INTO `arena_irca_match` (`match`, `name`, `type`, `location`, `location_table`, `weapons`, `weapon_type`, `posts`, `date`) "
                ."VALUES ('".addslashes($match)."', '".addslashes($name)."', '$type', '$location', '$location_table', '$weapons', '$weapon_type', '$posts', '".time()."')";
                
        if (mysql_query($sql, $this->connect)) {

            $this->new_match_id = mysql_insert_id($this->connect);

            $this->Fighter($challenger);
            $this->Fighter($challengee);

            $adjunct = $this->Adjunct();
            $overseer = $this->Overseer();

            $text = "There is a new IRCA Match for you to grade. Please go to the Holonet and grade it at your convenience.";

            $text .= "\r\n\r\n-Arena Tracking Network";

            $from = "IRC Arena <overseer@thebhg.org>";
            $subject = "New IRCA Match";

            $adjunct->SendEmail($from, $subject, $text);
            $overseer->SendEmail($from, $subject, $text);

            return true;

        } else {

            return false;

        }

    }

    function Fighter($id) {
        $sql = "INSERT INTO `arena_irca_records` (`bhg_id`, `match_id`) VALUES ($id, ".$this->new_match_id.")";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }

 }

?>