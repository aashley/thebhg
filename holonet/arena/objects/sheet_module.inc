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
    
    function GetShares(){
		$sql = "SELECT * FROM `cs_shares`";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$sqla = "SELECT * FROM `character_sheet_backups` WHERE `id` = '".$info['sheet']."'";
			$querya = mysql_query($sqla, $this->connect);
			$infer = mysql_fetch_array($querya);
			
			$sqlb = "SELECT * FROM `character_sheet_backup` WHERE `id` = '".$info['sheet']."'";
			$queryb = mysql_query($sqlb, $this->connect);
			$infor = mysql_fetch_array($queryb);
			
			if (mysql_num_rows($querya)){
				$return[] = array('id'=>$info['sheet'], 'with'=>$info['bhg_id'], 'hunter'=>$infor['bhg_id'], 'name'=>stripslashes($infor['save_name']));
			}
		}
		
		return $return;
	}	
	
	function GetCores($extra = ''){
	    $sql = "SELECT * FROM `character_sheet_core` $extra ORDER BY `pending` DESC";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
	    	$date = getdate($info['date']);
	    	$char = new Character($info['bhg_id']);
	    	$name = $char->GetName('cores', $info['id'], 'id');
			$return[$info['id']] = array('id'=>$info['id'], 'bhg_id'=>$info['bhg_id'], 'date'=>$date['mon'].'/'.$date['mday'].'/'.$date['year'], 'name'=>$name, 'app'=>$info['approved'], 'pending'=>$info['pending']);
		}
		
		return $return;
    }
    
    function GetBackups(){
	    $sql = "SELECT * FROM `character_sheet_backup`";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
	    	$date = getdate($info['date']);
			$return[$info['id']] = array('id'=>$info['id'], 'bhg_id'=>$info['bhg_id'], 'date'=>$date['mon'].'/'.$date['mday'].'/'.$date['year'], 'name'=>stripslashes($info['save_name']), 'share'=>0);
		}
		
		return $return;
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
		    $new = new Chara($info['bhg_id']);
		    if ($exclude == 1){
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
    
    function DeleteBlank(){
	    $sql = "SELECT * FROM `character_sheets` ORDER BY `pending` ASC, `approved` ASC, `last_change` DESC";
	    $query = mysql_query($sql, $this->connect);
	    
	    while ($info = mysql_fetch_array($query)){
		    $new = new Character($info['bhg_id']);
		    if ($new->Status('SYSTEM') == -1){
		    	$new->Kill('Cleaning out old blank sheets.');
	    	}
	    }
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