<?

 Class Field extends Sheet {

    var $field_id;
    var $field_name;
    var $field_description;
    var $field_help;

    function Field($id) {
        Sheet::Sheet();

        $sql = "SELECT * FROM `cs_fields` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'field_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }
    
    function GetID(){
	    return $this->field_id;
    }
    
    function GetName(){
	    return stripslashes($this->field_name);
    }
    
    function GetDesc(){
	    return stripslashes(nl2br($this->field_description));
    }

 }

?>