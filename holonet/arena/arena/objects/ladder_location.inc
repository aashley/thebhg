<?

 Class Location extends Ladder {

    var $arena_name;
    var $arena_id;
    var $table;

    function Location($id, $table) {
        Arena::Arena();

        $this->table = $table;

        $sql = "SELECT `id`, `name` FROM $table WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->lyarna);

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

    function GetTable() {
        return stripslashes($this->table);
    }

    function LocationMesh() {
        return $this->arena_id."_".$this->table;
    }

    function GetLink() {
        return "http://lyarna.thebhg.org/buildings/?type=".$this->table."&id=".$this->GetID();
    }

    function WriteLink(){
        return "<a href=".$this->GetLink().">".$this->GetName()."</a> on [ lyarna.thebhg.org ]";
    }

    function GetUsed() {
        $sql = "SELECT * FROM `arena_ladder_match` WHERE `location_table` = '".$this->table."' AND `location` = '".$this->arena_id."'";
        $query = mysql_query($sql, $this->connect);
		
        return mysql_num_rows($query);
    }

 }

?>