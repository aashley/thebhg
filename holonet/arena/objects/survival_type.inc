<?

 Class SurvivalType extends Survival {

    var $arena_survival_id;
    var $arena_survival_name;
    var $arena_survival_description;
    var $arena_survival_points;

    function SurvivalType($id) {
        Arena::Arena();

        $sql = "SELECT * FROM `arena_survival_types` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'arena_survival_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }

    function GetID() {
        return $this->arena_survival_id;
    }

    function GetName() {
        return stripslashes($this->arena_survival_name);
    }
    
    function GetPoints(){
	    return $this->arena_survival_points;
    }

    function GetDesc() {
        return stripslashes(nl2br($this->arena_survival_description));
    }

    function GetUsed() {
        $sql = "SELECT * FROM `arena_survival_contracts` WHERE `type` = '".$this->arena_survival_id."'";
        $query = mysql_query($sql, $this->connect);

        return mysql_num_rows($query);
    }

    function Edit($name, $description, $points) {
        $sql = "UPDATE `arena_survival_types` SET ";
        $add = array();
        $return = "";

        if ($name != $this->arena_survival_name){
            array_push($add, "`name` = '".addslashes($name)."'");
            $return .= "Name Edited.<br />";
        }

        if ($description != $this->arena_survival_description){
            array_push($add, "`description` = '".addslashes($description)."'");
            $return .= "Description Edited.<br />";
        }
        
        if ($points != $this->arena_survival_points){
            array_push($add, "`points` = '$points'");
            $return .= "Multiplier Points Edited.<br />";
        }

        $sql .= implode(', ', $add);

        $sql .= " WHERE `id` = '".$this->arena_survival_id."'";
        
        if (mysql_query($sql, $this->connect)){

            return $return;

        } else {
	        
	        echo mysql_error($this->connect);

            $arena = new Arena();
	        
            return $arena->NEC(175);

        }

    }
    
    function Delete(){
	    $sql = "UPDATE `arena_survival_types` SET `date_deleted` = '".time()."' WHERE `id` = '".$this->arena_survival_id."'";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    } 
    
    function Undelete(){
	    $sql = "UPDATE `arena_survival_types` SET `date_deleted` = '0' WHERE `id` = '".$this->arena_survival_id."'";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    } 

 }

?>