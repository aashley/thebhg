<?

 Class NPC extends Solo {

    var $npc_string;
    var $npc_id;

    function NPC($id) {
        Arena::Arena();

        $sql = "SELECT * FROM `arena_solo_npc` WHERE id = '$id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'npc_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }

    function GetID() {
        return $this->npc_id;
    }

    function GetName() {
	    if ($this->GetID() <= 111){
	        $npc = explode("/", $this->npc_string);
	
	        return mb_convert_case($npc[34], MB_CASE_TITLE, "UTF-8")." ".mb_convert_case($npc[35], MB_CASE_TITLE, "UTF-8");
        } else {
	        $npc = explode("/", $this->npc_string);
	        
	        return mb_convert_case($npc[0], MB_CASE_TITLE, "UTF-8")." ".mb_convert_case($npc[1], MB_CASE_TITLE, "UTF-8");
        }
    }


    function BuildSheet(){
       $build = new NPC_Utilities();
       
       if ($this->GetID() <= 111){
       		return $build->BuildSheet($this->npc_string);
	   } else {
		    return $build->Construct($this->npc_string);
	   }

    }

 }

?>