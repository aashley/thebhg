<?

 Class Coder extends Arena {

	var $fields = array();
	 
    function Coder(){
        Arena::Arena();
    }
    
    function Fileds($table){
	    $sql = "SELECT * FROM `$table` LIMIT 1";
	    $query = mysql_query($sql, $this->connect);
	    $array = mysql_fetch_array($query, MYSQL_ASSOC);
	    echo mysql_error($this->connect);
	    
	    foreach ($array as $field=>$value){
		    $this->fields[] = $field;
	    }
    }   
    
    function Add(){
 
    }
 }

?>