<?

 Class SoloControl extends Solo {

    function SoloControl(){
        Arena::Arena();
    }

    function New_Contract($bhg_id, $type){

	    $solo = new Solo();
	    
        $sql = "INSERT INTO `arena_solo_contracts` (`type`, `bhg_id`, `comissioner`) VALUES ('$type', '$bhg_id', '".$solo->CurrentComissionerID()."')";

        if (mysql_query($sql, $this->connect)) {

            $id = mysql_insert_id($this->connect);

            $npc = new Parse_NPC($type);

            $this->New_NPC($id, $npc->GetString());

            $this->NotifyComissioner();

           return $id;

        } else {

           return false;

        }

    }

    function New_NPC($id, $string){
        $sql = "SELECT * FROM `arena_solo_npc` WHERE `id` = $id";
        $query = mysql_query($sql, $this->connect);

        if (mysql_num_rows($query) > 0){

            return false;

        } else {

            $sql = "INSERT INTO `arena_solo_npc` (`id`, `string`) VALUES ('$id', '$string')";

            if (mysql_query($sql, $this->connect)) {

                return true;

            } else {

                return false;

            }
        }
    }

 }

?>