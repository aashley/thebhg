<?

Class Obj extends Arena {
	
	var $data = array();
	var $fields = array();
	var $table;
	 
    function Obj($table, $id) {
        Arena::Arena();

        $this->table = $table;
        
        $sql = "SELECT * FROM `".$this->table."` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_assoc($query)) {
            foreach ($result as $key => $value) {
                $this->data[$key] = stripslashes($value);
            }
        }
    }
    
    function Get($name, $nl = 0, $date = 0){
	    $ret = stripslashes($this->data[$name]);
	    
	    if ($date){
		    $ret = date('j F Y \a\t G:i:s T', $ret);
	    }
	    
	    if ($nl){
		    $ret = nl2br($ret);
	    }
	    
	    return $ret;
    }
	    

    function Edit($input) {
        $sql = "UPDATE `".$this->table."` SET ";
        
        foreach ($input as $key=>$value){
	        if ($value != $this->$key){
		        $add[] = "`".$key."` = '".addslashes($value)."'";
		        $return[] = ucfirst($key);
	        }
        }
        
        if (count($add)){
	        $sql .= implode(', ', $add)." WHERE `id` = '".$this->id."'";
	        
	        if (mysql_query($sql, $this->connect)){
	            return implode(' Edited.<br />', $return).' Edited.<br />';	
	        } else {
				return 'Error';
	        }
        }
    }
 }

?>