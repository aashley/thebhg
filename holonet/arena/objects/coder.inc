<?

Class Coder extends Arena {

	var $tables = array();
	var $fields = array();
	 
	function Coder(){
	    Arena::Arena();
	    
	    $this->LoadTables();
	}
	
	function LoadTables(){   
		$sql = "SQL SHOW TABLES `thebhg_holonet` [LIKE 'arena_']"
	    $query = mysql_query($sql, $this->connect);
		
		while ($info = mysql_fetch_assoc($query)) {
			$this->tables[] = $info;
		}
	}
	
	function LoadFields($table){   
	    $sql = "SHOW COLUMNS FROM `$table`";
	    $query = mysql_query($sql, $this->connect);
	   	while ($info = mysql_fetch_assoc($query)) {
	    	$this->fields[] = array('name'=>$info[Field], 'type'=>$info[Type]);
	   	}
	}
	
	function Add(){
			
	}
}

?>