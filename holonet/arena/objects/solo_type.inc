<?

 Class SoloType extends Solo {

    var $arena_solo_id;
    var $arena_solo_name;
    var $arena_solo_description;

    function SoloType($id) {
        Arena::Arena();

        $sql = "SELECT * FROM `arena_solo_types` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'arena_solo_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }

    function GetID() {
        return $this->arena_solo_id;
    }

    function GetName() {
        return stripslashes($this->arena_solo_name);
    }

    function GetDesc() {
        return stripslashes(nl2br($this->arena_solo_description));
    }

    function GetUsed() {
        $sql = "SELECT * FROM `arena_solo_contracts` WHERE `type` = '".$this->arena_solo_id."'";
        $query = mysql_query($sql, $this->connect);

        return mysql_num_rows($query);
    }

    function Edit($name, $description) {
        $sql = "UPDATE `arena_solo_types` SET ";
        $add = array();
        $return = "";

        if ($name != $this->arena_solo_name){
            array_push($add, "`name` = '".addslashes($name)."'");
            $return .= "Name Edited.<br />";
        }

        if ($description != $this->arena_solo_description){
            array_push($add, "`description` = '".addslashes($description)."'");
            $return .= "Description Edited.<br />";
        }

        $sql .= implode(', ', $add);

        $sql .= " WHERE `id` = '".$this->arena_solo_id."'";


        if (mysql_query($sql, $this->connect)){

            return $return;

        } else {

            $arena = new Arena();
	        
            return $arena->NEC(89);

        }

    }
    
    function Delete(){
	    $sql = "UPDATE `arena_solo_types` SET `date_deleted` = '".time()."' WHERE `id` = '".$this->arena_solo_id."'";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    } 
    
    function Undelete(){
	    $sql = "UPDATE `arena_solo_types` SET `date_deleted` = '0' WHERE `id` = '".$this->arena_solo_id."'";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    } 

 }

?>