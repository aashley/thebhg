<?

 Class Control extends Ladder {

    var $new_match_id;

    function Control(){
        Arena::Arena();
    }
    
    function LastInsert(){
	    return $this->new_match_id;
    }
    
    function OldMatch($type, $location, $location_table, $posts, $weapons, $challenger, $challengee, $weapon_type, $name, $start, $end, $match_id){

        $person1 = new Person($challenger);
        $person2 = new Person($challengee);

        if ($name == 0){
        	$name = $person1->GetName()." vs. ".$person2->GetName();
    	}

        $sql = "INSERT INTO `arena_ladder_match` (`name`, `type`, `location`, `location_table`, `weapons`, `num_posts`, `weapon_type`, `start`, `end`, `accepted`, `match_id`) "
                ."VALUES ('".addslashes($name)."', '$type', '$location', '$location_table', '$weapons', '$posts', '$weapon_type', '$start', '$end', '1', '$match_id')";

        if (mysql_query($sql, $this->connect)) {

            $this->new_match_id = mysql_insert_id($this->connect);

            $this->Fighter($challenger, 1);
            $this->Fighter($challengee, 0);

            return true;

        } else {

            return false;

        }

    }

    function Challenge($type, $location, $location_table, $posts, $weapons, $challenger, $challengee, $weapon_type, $link, $dojo = '0'){

        $person1 = new Person($challenger);
        $person2 = new Person($challengee);

        $name = $person1->GetName()." vs. ".$person2->GetName();

        /*$ttg = new TTG();
        $gauntlet = 0;
        
        if (in_array($challenger, $ttg->Members())){
	        if (in_array($challengee, $ttg->Members())){
		        $gauntlet = 1;
	        }
        }*/
        
        $sql = "INSERT INTO `arena_ladder_match` (`name`, `type`, `location`, `location_table`, `weapons`, `num_posts`, `weapon_type`, `is_dojo`) "
                ."VALUES ('".addslashes($name)."', '$type', '$location', '$location_table', '$weapons', '$posts', '$weapon_type', $dojo)";

        if (mysql_query($sql, $this->connect)) {

            $this->new_match_id = mysql_insert_id($this->connect);

            $this->Fighter($challenger, 1);
            $this->Fighter($challengee, 0);

            $match = new Match($this->new_match_id);
            $type = $match->GetType();
            $location = $match->GetLocation();
            $weapon = $match->GetWeaponType();

            $text = $person1->GetName()." has issued an Arena Challenge to ".$person2->GetName()." with the following details: \r\n"
                    ."Match Type - ".$type->GetName()."\r\n"
                    ."Location - ".$location->GetName()."\r\n"
                    ."Weapon Types - ".$weapon->GetWeapon()."\r\n"
                    ."Weapons - ".$match->GetWeapons()."\r\n"
                    ."Posts - ".$match->GetPosts()."\r\n";

            $text .= "\r\nTo accept this challenge, please go to $link and choose ACCEPT for the pending challenge."
                    ."\r\n\r\n-The Overseer";

            $from = "Arena <overseer@thebhg.org>";
            $subject = "You have been challenged!";

            $person1->SendEmail($from, $subject, $text);
            $person2->SendEmail($from, $subject, $text);


            return true;

        } else {

            return false;

        }

    }

    function Fighter($id, $challenger = '0') {
        $sql = "INSERT INTO `arena_ladder_records` (`bhg_id`, `match_id`, `challenger`) VALUES ($id, ".$this->new_match_id.", $challenger)";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }

 }

?>