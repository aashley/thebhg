<?

Class Obj extends Arena {
	
	var $data = array();
	var $table;
	var $con;
	 
    function Obj($table, $id, $con) {
        Arena::Arena();

        $this->table = $table;
        
        $this->con = $this->$con;
        
        $sql = "SELECT * FROM `".$this->table."` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->con);

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
	    $add = array();
	    $return = array();
        $sql = "UPDATE `".$this->table."` SET ";
        
        foreach ($input as $key=>$value){
	        if ($value != $this->Get($key)){
		        $add[] = "`".$key."` = '".addslashes($value)."'";
		        $return[] = str_replace('_', '&nbsp;', ucfirst($key));
	        }
        }
        
        if (count($add)){
	        $sql .= implode(', ', $add)." WHERE `id` = '".$this->Get(id)."'";
			
	        if (mysql_query($sql, $this->con)){
	            echo implode(' Edited.<br />', $return).' Edited.<br />';	
	        } else {
				echo 'Error: '.mysql_error($this->con);
	        }
        }
    }
 }

?>