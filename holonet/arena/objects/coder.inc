<?

Class Coder extends Arena {

	var $tables = array();
	var $fields = array();
	var $allowed = array();
	 
	function Coder(){
	    Arena::Arena();
	    
	    $this->LoadTables();
	    $this->allowed = array('arena', 'character_sheet', 'cs');
	}
	
	function LoadTables(){   
		$sql = "SHOW TABLES FROM `thebhg_holonet`";
	    $query = mysql_query($sql, $this->connect);
	    
		while ($info = mysql_fetch_assoc($query)) {
			$name = $info[key($info)];
			$exp = explode('_', $name);
			if (in_array($exp[0], $this->allowed)){
				$this->tables[] = $name;
			}
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