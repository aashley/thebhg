<?php

 Class Sheet extends Arena {
	 
	var $connect;
	
	function Sheet(){
		Arena::Arena();
	}
    
	function CurrentRegistrar(){
        $sql = "SELECT * FROM `arena_registrar` WHERE `end_date` = '0'";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        return $info['bhg_id'];
    }
    
    function GetBackup($id){
	    $sql = "SELECT * FROM `character_sheet_backup` WHERE `id` = '".$id."'";
	    $query = mysql_query($sql, $this->connect);
	    $info = mysql_fetch_array($query);
	    
	    return new Character($info['bhg_id']);
    }
    
    function NewRegistrar($bhg_id){
	    $current = new Registrar($this->CurrentRegistrar());
	    $current->EndTerm();
	    
	    $sql = "SELECT * FROM `arena_registrar` WHERE `bhg_id` = '$bhg_id'";
	    $query = mysql_query($sql, $this->connect);
	    
	    if (mysql_num_rows($query)){
		    $info = mysql_fetch_array($query);
		    $sql = "UPDATE `arena_registrar` SET `start_date` = '".time()."', `end_date` = 0";
	    } else {
	    	$sql = "INSERT INTO `arena_registrar` (`bhg_id`, `start_date`) VALUES ('$bhg_id', '".time()."')";
    	}
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
	
    function RegistrarTrack($event){
	    $reg = new Registrar($this->CurrentRegistrar());
	    $sql = "SELECT * FROM `arena_registrar_track` WHERE `registrar` = '".$reg->GetID()."'";
	    $query = mysql_query($sql, $this->connect);
	    
	    if (mysql_num_rows($query)){
		    $sql = "UPDATE `arena_registrar_track` SET `$event` = $event+1 WHERE `registrar` = '".$this->CurrentRegistrar()."'";
		    mysql_query($sql, $this->connect);
	    } else {
		    $sql = "INSERT INTO `arena_registrar_track` (`$event`, `registrar`) VALUES (1, '".$this->CurrentRegistrar()."')";
		    mysql_query($sql, $this->connect);
	    }
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
    
    function SheetHolders($exclude = 0){
	    $sql = "SELECT * FROM `character_sheets` ORDER BY `pending` ASC, `approved` ASC, `last_change` DESC";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $new = new Character($info['bhg_id']);
		    if ($exclude){
			    $go = true;
		    } else {
			    if ($new->Includeable()){
			    	$go = true;
		    	} else {
			    	$go = false;
		    	}
		    }
		    if ($go){
				$return[] = $new;
		    }
	    }
	    
	    return $return;
    }
    
    function HasSheet($bhg_id){
	    $new = new Character($bhg_id);
	    return ($new->Includeable() ? true : false);
    }
    
    function DropdownFields($form, $name = 'csfield'){
	    $form->table->StartRow();
	    $form->table->AddCell('Stat/Skill');
	    $form->AddHidden('nameused[]', $name);
	    $cell = '';
	    
	    $cell .= '<select type="select" name="'.$name.'">';
	    
	    foreach ($this->GetSkills() as $skill){
		    $cell .= '<option value="skill_'.$skill->GetID().'">'.$skill->GetName().'</option>';
	    }
	    foreach ($this->GetStats() as $stat){
		    $cell .= '<option value="stat_'.$stat->GetID().'">'.$stat->GetName().'</option>';
	    }
	    
	    $cell .= '</select> Value: <input type="text" name="txt_'.$name.'" value=0>';
	    
		$form->table->AddCell($cell);
		$form->table->EndRow();
	}	
	
	function HasValue($bhg_id, $field, $value){
		if ($this->HasSheet($bhg_id)){
			$fields = explode('_', $field);
			$field = $fields[0];
			$resource = $fields[1];
			$character = new Character($bhg_id);
			if ($field == 'skill'){
				$evalue = $character->GetValue($resource, 'values', 'SYSTEM'); 
			} else {
				$evalue = $character->Point($resource, 'SYSTEM'); 
			}
			
			$return = ($evalue >= $value);
			
			return ($return ? true : false);
			
		} else {
			return false;
		}
	}
 }

?>