<?

 Class Type extends Ladder {

    var $arena_id;
    var $arena_name;
    var $arena_description;
    var $arena_rules;
    var $arena_fighters;

    function Type($id) {
        Arena::Arena();

        $sql = "SELECT * FROM `arena_ladder_type` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'arena_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }

    function GetID() {
        return $this->arena_id;
    }

    function GetName() {
        return stripslashes($this->arena_name);
    }

    function GetDesc() {
        return stripslashes(nl2br($this->arena_description));
    }

    function GetRules() {
        return stripslashes(nl2br($this->arena_rules));
    }

    function GetFighters() {
        return stripslashes($this->arena_fighters);
    }

    function GetUsed() {
        $sql = "SELECT * FROM `arena_ladder_match` WHERE `type` = '".$this->arena_id."'";
        $query = mysql_query($sql, $this->connect);

        return mysql_num_rows($query);
    }

    function Edit($name, $description, $rules, $fighters) {
        $sql = "UPDATE `arena_ladder_type` SET ";
        $add = array();
        $return = "";

        if ($name != $this->arena_name){
            array_push($add, "`name` = '".addslashes($name)."'");
            $return .= "Type Name Edited.<br />";
        }

        if ($description != $this->arena_description){
            array_push($add, "`description` = '".addslashes($description)."'");
            $return .= "Description Edited.<br />";
        }

        if ($rules != $this->arena_rules){
            array_push($add, "`rules` = '".addslashes($rules)."'");
            $return .= "Rules Edited.<br />";
        }

        if ($fighters != $this->arena_fighters){
            array_push($add, "`fighters` = '".addslashes($fighters)."'");
            $return .= "Fighters Edited.<br />";
        }

        $sql .= implode(', ', $add);

        $sql .= " WHERE `id` = '".$this->arena_id."'";


        if (mysql_query($sql, $this->connect)){

            return $return;

        } else {

            $arena = new Arena();
	        
            return $arena->NEC(79);

        }

    }
    
    function Delete(){
	    $sql = "UPDATE `arena_ladder_type` SET `date_deleted` = '".time()."' WHERE `id` = '".$this->arena_id."'";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    } 
    
    function Undelete(){
	    $sql = "UPDATE `arena_ladder_type` SET `date_deleted` = '0' WHERE `id` = '".$this->arena_id."'";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    } 

 }

?>