<?

 Class Coder extends Arena {

	var $fields = array();
	 
    function Coder(){
        Arena::Arena();
    }
    
    function Fileds($table){   
	    $sql = "SHOW COLUMNS FROM `$table`";
	    $result = mysql_query($sql, $connect);
		if (mysql_num_rows($result) > 0) {
		   while ($row = mysql_fetch_assoc($result)) {
		       $fields[] = array('name'=>$row[Field], 'type'=>$row[Type]);
		   }
		}
    }   
    
    function Add(){
 
    }
 }

?>