<?

 Class Statribute extends Sheet {

    var $stat_id;
    var $stat_name;
    var $stat_int;
    var $stat_field;
    var $stat_desc;

    function Statribute($id) {
        Sheet::Sheet();

        $sql = "SELECT * FROM `cs_statributes` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'stat_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }
    
    function GetID(){
	    return $this->stat_id;
    }
    
    function GetName(){
	    return stripslashes($this->stat_name);
    }
    
    function GetDesc(){
	    return stripslashes(nl2br($this->stat_desc));
    }
    
    function GetField(){
	    return new Field($this->stat_field);
    }
    
    function IsInt(){
	    return ($this->stat_int == 1);
    }

 }

?>