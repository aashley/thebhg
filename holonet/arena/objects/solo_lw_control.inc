<?

 Class LW_SoloControl extends LW_Solo {

    function LW_SoloControl(){
        Arena::Arena();
    }

    function New_Contract($bhg_id){

	    $solo = new Solo();
	    
        $sql = "INSERT INTO `arena_lw_contracts` (`bhg_id`, `comissioner`) VALUES ('$bhg_id', '".$solo->CurrentComissionerID()."')";

        if (mysql_query($sql, $this->connect)) {

            $id = mysql_insert_id($this->connect);

            $npc1 = new Parse_NPC(3);
            $npc2 = new Parse_NPC(3);

            $this->New_NPC($id, $npc1->GetString(), $npc2->GetString());

            $this->NotifyComissioner();

           return $id;

        } else {

           return false;

        }

    }

    function New_NPC($id, $string1, $string2){
        $sql = "SELECT * FROM `arena_lw_npc` WHERE `id` = $id";
        $query = mysql_query($sql, $this->connect);

        if (mysql_num_rows($query) > 0){

            return false;

        } else {

            $sql = "INSERT INTO `arena_lw_npc` (`id`, `c1string`, `c2string`) VALUES ('$id', '$string1', '$string2')";

            if (mysql_query($sql, $this->connect)) {

                return true;

            } else {

                return false;

            }
        }
    }

 }

?>