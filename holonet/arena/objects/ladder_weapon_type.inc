<?

 Class WeaponType extends Ladder {

    var $arena_id;
    var $arena_weapon;

    function WeaponType($id) {
        Arena::Arena();

        $sql = "SELECT * FROM `arena_ladder_weapons` WHERE `id` = '$id'";
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

    function GetWeapon() {
        return stripslashes($this->arena_weapon);
    }

    function GetUsed() {
        $sql = "SELECT * FROM `arena_ladder_match` WHERE `type` = '".$this->arena_id."'";
        $query = mysql_query($sql, $this->connect);

        return mysql_num_rows($query);
    }
    
    function SetWeapon($name) {
        $sql = "UPDATE `arena_ladder_weapons` SET `weapon` = '".addslashes($name)."' WHERE `id` = '".$this->arena_id."'";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }
    
    function Delete(){
	    $sql = "UPDATE `arena_ladder_weapons` SET `date_deleted` = '".time()."' WHERE `id` = '".$this->arena_id."'";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    } 
    
    function Undelete(){
	    $sql = "UPDATE `arena_ladder_weapons` SET `date_deleted` = '0' WHERE `id` = '".$this->arena_id."'";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    } 

 }

?>