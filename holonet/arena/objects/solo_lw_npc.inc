<?

 Class LW_NPC extends LW_Solo {

    var $npc_c1string;
    var $npc_c2string;
    var $npc_id;

    function LW_NPC($id) {
        Arena::Arena();

        $sql = "SELECT * FROM `arena_lw_npc` WHERE id = '$id'";
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

    function GetName1() {
	    if ($this->GetID() <= 13){
	        $npc = explode("/", $this->npc_c1string);

        	return mb_convert_case($npc[34], MB_CASE_TITLE, "UTF-8")." ".mb_convert_case($npc[35], MB_CASE_TITLE, "UTF-8");
        } else {
	        $npc = explode("/", $this->npc_c1string);
	        
	        return mb_convert_case($npc[0], MB_CASE_TITLE, "UTF-8")." ".mb_convert_case($npc[1], MB_CASE_TITLE, "UTF-8");
        }
        
    }


    function BuildSheet1(){
       $build = new NPC_Utilities();

       if ($this->GetID() <= 13){
       		return $build->BuildSheet($this->npc_c1string);
	   } else {
		    return $build->Construct($this->npc_c1string);
	   }

    }

    function GetName2() {
        if ($this->GetID() <= 13){
	        $npc = explode("/", $this->npc_c2string);

        	return mb_convert_case($npc[34], MB_CASE_TITLE, "UTF-8")." ".mb_convert_case($npc[35], MB_CASE_TITLE, "UTF-8");
        } else {
	        $npc = explode("/", $this->npc_c2string);
	        
	        return mb_convert_case($npc[0], MB_CASE_TITLE, "UTF-8")." ".mb_convert_case($npc[1], MB_CASE_TITLE, "UTF-8");
        }
    }


    function BuildSheet2(){
       $build = new NPC_Utilities();

       if ($this->GetID() <= 13){
       		return $build->BuildSheet($this->npc_c2string);
	   } else {
		    return $build->Construct($this->npc_c2string);
	   }

    }

 }

?>