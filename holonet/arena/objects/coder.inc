<?

Class Coder extends Arena {

	var $tables = array();
	var $fields = array();
	var $allowed = array();
	 
	function Coder(){
	    Arena::Arena();
	    
	    $this->allowed = array('arena', 'character_sheet', 'cs');
	    $this->LoadTables();	    
	}
	
	function LoadTables(){   
		$sql = "SHOW TABLES FROM `thebhg_holonet`";
	    $query = mysql_query($sql, $this->connect);
	    
		while ($info = mysql_fetch_assoc($query)) {
			$name = $info[key($info)];
			$exp = explode('_', $name);
			if (in_array($exp[0], $this->allowed)){
				array_shift($exp);
				$ref = implode(' ', $exp);
				$this->tables[] = array('full'=>$name, 'index'=>mb_convert_case($ref, MB_CASE_TITLE, "UTF-8"));
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