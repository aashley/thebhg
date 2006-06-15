<?php

	// Connect to DB
	$GLOBALS['db'] = mysql_connect("localhost", "thebhg", "monkey69");
	mysql_select_db("thebhg_lyarna");
	
	/** Get plants */
	function getPlanets($nomoon = false, $saymoon = false){
		$sql = "SELECT * FROM planets ORDER BY name ASC";
		$query = mysql_query($sql, $GLOBALS['db']);
		$return = array();
		
		while ($info = mysql_fetch_assoc($query)){
			if ($nomoon){
				if (isMoon($info['id']))
					continue;
			}
			$return[$info['id']] = ($saymoon ? (isMoon($info['id']) ? 'Satellite: ' : '') : '').stripslashes($info['name']);
		}
			
		return $return;
	}
	
	/** Declare Moon */
	function makeMoon($planet, $moon){
		$sql = "INSERT INTO `moon` (`moon`, `planet`) VALUES ('$moon', '$planet')";
		
		return mysql_query($sql, $GLOBALS['db']);
	}
	
	/** Is a moon? */
	function isMoon($id){
		$sql = "SELECT * FROM `moon` WHERE `moon` = $id";
		$query = mysql_query($sql, $GLOBALS['db']);
		
		return (mysql_num_rows($query) >= 1);		
	}	
	
	/** Get planet */
	function getPlanet($id){
		$sql = "SELECT * FROM planets WHERE `id` = '$id'";
		$query = mysql_query($sql, $GLOBALS['db']);
		$info = mysql_fetch_assoc($query);
		$return = array();
		
		foreach ($info as $name => $value)
			$return[$name] = stripslashes($value);
			
		return $return;
	}
	
	/** Get planet for Form */
	function getPlanetForm($id){
		$sql = "SELECT * FROM planets WHERE `id` = '$id'";
		$query = mysql_query($sql, $GLOBALS['db']);
		$info = mysql_fetch_assoc($query);
		$return = array();
		
		foreach ($info as $name => $value)
			$return['return['.$name.']'] = stripslashes($value);
			
		return $return;
	}
	
	function updatePlanet($id, $array){
		$sql = "UPDATE `planets` SET ".implode(', ', $array)." WHERE `id` = '$id'";
		
		return mysql_query($sql, $GLOBALS['db']);		
	}
	
	function createPlanet($values, $array){
		$sql = "INSERT INTO `planets` (".implode(', ', $values).") VALUES (".implode(', ', $array).")";
		
		return mysql_query($sql, $GLOBALS['db']);
	}
  
?>
