<?

 Class Restriction extends Starfield {

    var $arena_starfield_id;
    var $arena_starfield_name;
    var $arena_starfield_description;

    function Restriction($id) {
        Arena::Arena();

        $sql = "SELECT * FROM `arena_starfield_restrictions` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'arena_starfield_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }

    function GetID() {
        return $this->arena_starfield_id;
    }

    function GetName() {
        return stripslashes($this->arena_starfield_name);
    }

    function GetDesc() {
        return stripslashes(nl2br($this->arena_starfield_description));
    }

    function GetUsed() {
        /* $sql = "SELECT * FROM `arena_starfield_match` WHERE MATCH(`restrictions`) AGAINST ('".$this->arena_starfield_id."')";
        $query = mysql_query($sql, $this->connect); */

        return "This function currently disabled.";
    }

    function Edit($name, $description) {
        $sql = "UPDATE `arena_starfield_restrictions` SET ";
        $add = array();
        $return = "";

        if ($name != $this->arena_starfield_name){
            array_push($add, "`name` = '".addslashes($name)."'");
            $return .= "Name Edited.<br />";
        }

        if ($description != $this->arena_starfield_description){
            array_push($add, "`description` = '".addslashes($description)."'");
            $return .= "Description Edited.<br />";
        }

        $sql .= implode(', ', $add);

        $sql .= " WHERE `id` = '".$this->arena_starfield_id."'";
        
        echo $sql;        
        
        if (mysql_query($sql, $this->connect)){

            return $return;

        } else {

            $arena = new Arena();
	        
            return $arena->NEC(101);

        }

    }
    
    function Delete(){
	    $sql = "UPDATE `arena_starfield_restrictions` SET `date_deleted` = '".time()."' WHERE `id` = '".$this->arena_starfield_id."'";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    } 
    
    function Undelete(){
	    $sql = "UPDATE `arena_starfield_restrictions` SET `date_deleted` = '0' WHERE `id` = '".$this->arena_starfield_id."'";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    } 

 }

?>