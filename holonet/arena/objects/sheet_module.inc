<?php

 Class Sheet extends Arena {
	 
	var $connect;
	
	function Sheet(){
		Arena::Arena();
	}
    
    function NewField($name, $desc){
	    $sql = "INSERT INTO `cs_fields` (`name`, `desc`) VALUES ('".addslashes($name)."', '".addslashes($desc)."')";
	    
	    if (mysql_query($sql, $this->connect)){
		    return mysql_insert_id($this->connect);
	    } else {
		    return false;
	    }
    }
    
    function NewStatribute($name, $desc, $int, $field){
	    $sql = "INSERT INTO `cs_statributes` (`name`, `field`, `desc`, `int`) VALUES ('".addslashes($name)."', '$field', '".addslashes($desc)."', '$int')";
	    
	    if (mysql_query($sql, $this->connect)){
		    return mysql_insert_id($this->connect);
	    } else {
		    return false;
	    }
    }
    
    function NewSkill($name, $desc, $field){
	    $sql = "INSERT INTO `cs_skills` (`name`, `field`, `desc`) VALUES ('".addslashes($name)."', '$field', '".addslashes($desc)."')";
	    
	    if (mysql_query($sql, $this->connect)){
		    return mysql_insert_id($this->connect);
	    } else {
		    return false;
	    }
    }
    
    function NewVaraible($skill, $stat, $mod){
	    $sql = "INSERT INTO `cs_skill_equ` (`skill`, `statribute`, `modifier`) VALUES ('$skill', '$stat', '$mod')";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function GetFields(){
	    $sql = "SELECT * FROM `cs_fields` ORDER BY `name`";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $return[] = new Field($info['id']);
	    }
	    
	    return $return;
    }
    
    function GetSkills($id = 0){
	    $extra = '';
	    
	    if ($id){
		    $extra = "WHERE `field` = $id";
	    }
	    
	    $sql = "SELECT * FROM `cs_skills` $extra ORDER BY `name`";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $return[] = new Skill($info['id']);
	    }
	    
	    return $return;
    }
    
    function GetStats($id = 0){
	    $extra = '';
	    
	    if ($id){
		    $extra = "WHERE `field` = $id";
	    }
	    
	    $sql = "SELECT * FROM `cs_statributes` $extra ORDER BY `name`";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $return[] = new Statribute($info['id']);
	    }
	    
	    return $return;
    }
    
    function StatributePoints(){
	    return 40;
    }
    
    function ExpertisePoints(){
	    return 60;
    }
    
    function SheetHolders(){
	    $sql = "SELECT * FROM `character_sheets` ORDER BY `pending` ASC, `approved` ASC, `last_change` DESC";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $return[] = new Character($info['bhg_id']);
	    }
	    
	    return $return;
    }
    
    function HasSheet($bhg_id){
	    $sql = "SELECT * FROM `character_sheets` WHERE `bhg_id` = '$bhg_id' ORDER BY `approved` ASC, `last_change` DESC";
	    $query = mysql_query($sql, $this->connect);
	    
	    return mysql_num_rows($query);
    }
 }

?>