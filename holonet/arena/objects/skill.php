<?

 Class Skill extends Sheet {

    var $skill_id;
    var $skill_name;
    var $skill_field;
    var $skill_desc;

    function Skill($id) {
        Sheet::Sheet();

        $sql = "SELECT * FROM `cs_skills` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->holonet);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'skill_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }
    
    function GetID(){
	    return $this->skill_id;
    }
    
    function GetName(){
	    return stripslashes($this->skill_name);
    }
    
    function GetDesc(){
	    return stripslashes(nl2br($this->skill_desc));
    }
    
    function GetField(){
	    return new Field($this->skill_field);
    }
    
 }

?>