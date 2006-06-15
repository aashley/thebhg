<?php

	// Connect to DB
	$GLOBALS['db'] = mysql_connect("localhost", "thebhg", "monkey69");
	mysql_select_db("thebhg_lyarna");
	
	/** Get plants */
	function getPlanets(){
		$sql = "SELECT * FROM planets ORDER BY name ASC";
		$query = mysql_query($sql, $GLOBALS['db']);
		$return = array();
		
		while ($info = mysql_fetch_assoc($query))
			$return[$info['id']] = stripslashes($info['name']);
			
		return $return;
	}
	
	/** Get planet */
	function getPlanet($id){
		$sql = "SELECT * FROM planets WHERE `id` = '$id'";
		$query = mysql_query($sql, $GLOBALS['db']);

		return $info = mysql_fetch_assoc($query);
	}
  
?>
