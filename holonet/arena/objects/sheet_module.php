<?php

 Class Sheet extends Arena {
	 
	var $connect;
	
	function Sheet(){
		Arena::Arena();
	}
    
    function GetBackup($id){
	    $sql = "SELECT * FROM `character_sheet_backup` WHERE `id` = '".$id."'";
	    $query = mysql_query($sql, $this->holonet);
	    $info = mysql_fetch_array($query);
	    
	    return new Character($info['bhg_id']);
    }
    
    function AllMods(){
	    $sql = "SELECT * FROM `cs_mods` WHERE `date_deleted` = 0";
	    $query = mysql_query($sql, $this->holonet);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $return[] = array('id'=>$info['id'], 'name'=>$info['name']);
	    }
	    
	    return $return;
    }
    
    function BuildModEdit($id){
    	$sql = "SELECT * FROM `cs_mods` WHERE `id` = '$id' AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->holonet);
	    
	    if (mysql_num_rows($query)){
		    $info = mysql_fetch_array($query);
		    return array('id'=>$info['id'], 'name'=>$info['name'], 'desc'=>stripslashes($info['description']), 'fields'=>unserialize($info['fields']));
	    } else {
		    return 0;
	    }
    }
    
    function GetSheetMod($field){
	    $sql = "SELECT * FROM `cs_mods` WHERE `name` = '$field' AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->holonet);
	    
	    if (mysql_num_rows($query)){
		    $info = mysql_fetch_array($query);
		    return $info['id'];
	    } else {
		    return 0;
	    }
    }
    
    function NewCSCA($name, $desc){
	    $sql = "INSERT INTO `cs_ca` (`name`, `description`) VALUES ('".addslashes($name)."', '".addslashes($desc)."')";
	    $query = mysql_query($sql, $this->holonet);
	    
	    return ($query ? true : false);
    }
    
    function AddCAValue($ca, $skill, $field, $mod){
	    $sql = "INSERT INTO `cs_ca_stats` (`skill`, `field`, `ca`, `modifier`) VALUES ('$skill', '$field', '$ca', '$mod')";
	    $query = mysql_query($sql, $this->holonet);
	    
	    return ($query ? true : false);
    }
    
    function EditCA($id, $name, $desc){
	    $sql = "UPDATE `cs_ca` SET `name` = '".addslashes($name)."', `description` = '".addslashes($desc)."' WHERE `id` = '$id'";
	    $query = mysql_query($sql, $this->holonet);
	    
	    return ($query ? true : false);
    }
    
    function EditCAValue($id, $skill, $field, $mod){
	    $sql = "UPDATE `cs_ca_stats` SET `skill` = '$skill', `field` = '$field', `modifier` = '$mod' WHERE `id` = '$id'";
	    $query = mysql_query($sql, $this->holonet);
	    
	    return ($query ? true : false);
    }
    
    function DeleteCAValue($id){
	    $sql = "UPDATE `cs_ca_stats` SET `date_deleted` = '".time()."' WHERE `id` = '$id'";
	    $query = mysql_query($sql, $this->holonet);
	    
	    return ($query ? true : false);
    }
    
    function DeleteCA($id){
	    $sql = "UPDATE `cs_ca` SET `date_deleted` = '".time()."' WHERE `id` = '$id'";
	    $query = mysql_query($sql, $this->holonet);
	    
	    return ($query ? true : false);
    }
    
    function GetCAs(){
	    $sql = "SELECT * FROM `cs_ca` WHERE `date_deleted` = 0";
	    $query = mysql_query($sql, $this->holonet);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $return[$info['id']] = array('name'=>stripslashes($info['name']), 'desc'=>stripslashes($info['description']), 'description'=>stripslashes(nl2br($info['description'])));
	    }
	    
	    return $return;
    }
    
    function GetCA($id){
	    $sql = "SELECT * FROM `cs_ca` WHERE `id` = '$id'";
	    $query = mysql_query($sql, $this->holonet);
	    $info = mysql_fetch_array($query);
	    
	    return array('id'=>$info['id'], 'date_deleted'=>$info['date_deleted'], 'name'=>stripslashes($info['name']), 'desc'=>stripslashes($info['description']), 'description'=>stripslashes(nl2br($info['description'])));
    }
    
    function GetCAValues($id){
	    $sql = "SELECT * FROM `cs_ca_stats` WHERE `ca` = '$id' AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->holonet);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $field = $info['field'];
		    if ($info['skill']){
			    $fo = new Skill($field);
		    } else {
			    $fo = new Statribute($field);
		    }
		    $return[$info['id']] = array('field'=>$field, 'skill'=>$info['skill'], 'ca'=>$info['ca'], 'fo'=>$fo, 'mod'=>$info['modifier']);
	    }
	    
	    return $return;
    }
    
    function AwardedCAs(){
	    $sql = "SELECT * FROM `character_sheet_ca` WHERE `date_deleted` = 0";
	    $query = mysql_query($sql, $this->holonet);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $ca = $this->GetCa($info['ca']);
		    if (!$ca['date_deleted']){
		    	$return[] = array('ca'=>$info['ca'], 'person'=>new Person($info['bhg_id']), 'name'=>$ca['name']);
	    	}
	    }
	    
	    return $return;
    }
    
    function CharacterAttributes($id){
	    $base = $this->GetCAValues($id);
	    
	    foreach ($base as $id=>$array){
		    if ($array['skill']){
			    $call = 'skill';
		    } else {
			    $call = 'stat';
		    }
		    $return[$call][$array['field']] = $array['mod'];
	    }
	    
	    return $return;
    }
    
    function ModFields($id){
	    $sql = "SELECT * FROM `cs_mods` WHERE `id` = '$id'";
	    $query = mysql_query($sql, $this->holonet);
	    
	    if (mysql_num_rows($query)){
		    $info = mysql_fetch_array($query);
		    return unserialize($info['fields']);
	    } else {
		    return array();
	    }
    }
    
    function AddSheetMod($name, $description, $fields){
	    $sql = "INSERT INTO `cs_mods` (`name`, `description`, `fields`) VALUES ('$name', '".addslashes($description)."', '".serialize($fields)."')";
	    $query = mysql_query($sql, $this->holonet);
	    
	    return ($query ? true : false);
    }
    
    function UpdateSheetMod($id, $name, $description, $fields){
	    $sql = "UPDATE `cs_mods` SET `fields` = '".serialize($fields)."', `name` = '$name', `description` = '".addslashes($description)."' WHERE `id` = '$id'";
	    $query = mysql_query($sql, $this->holonet);
	    
	    return ($query ? true : false);
    }
    
    function SetSheetMod($project, $type, $value, $lock){
	    /* Type 1: Statribute
	       Type 2: Skill
	     */
	    $sql = "SELECT * FROM `cs_mod` WHERE `type` = '$type' AND `value` = '$value' AND `project` = '$project' AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->holonet);
	    if (mysql_num_rows($query)){
		    $info = mysql_fetch_array($query);
		    $this->UpdatePermit($info['id'], $type, $value, $lock);
	    } else {
		    $sql = "INSERT INTO `cs_mod` (`type`, `project`, `value`, `lock`) VALUES ('$type', '$project', '$value', '$lock')";
		    mysql_query($sql, $this->holonet);
	    }
    }
    
    function UpdatePermit($id, $type, $value, $lock){
	    $sql = "UPDATE `cs_mod` SET `lock` = '$lock', `type` = '$type', `value` = '$value' WHERE `id` = '$id'";
	    mysql_query($sql, $this->holonet);
    }
    
    function Permit($type, $value, $project){
	    $sql = "SELECT * FROM `cs_mod` WHERE `type` = '$type' AND `value` = '$value' AND `project` = '$project' AND `date_deleted` = 0  AND `lock` = 0";
	    $query = mysql_query($sql, $this->holonet);
	    
	    return mysql_num_rows($query);
    }
    
    function GetShares(){
		$sql = "SELECT * FROM `cs_shares`";
		$query = mysql_query($sql, $this->holonet);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$sqla = "SELECT * FROM `character_sheet_backups` WHERE `id` = '".$info['sheet']."'";
			$querya = mysql_query($sqla, $this->holonet);
			$infer = mysql_fetch_array($querya);
			
			$sqlb = "SELECT * FROM `character_sheet_backup` WHERE `id` = '".$info['sheet']."'";
			$queryb = mysql_query($sqlb, $this->holonet);
			$infor = mysql_fetch_array($queryb);
			
			if (mysql_num_rows($querya)){
				$return[] = array('id'=>$info['sheet'], 'with'=>$info['bhg_id'], 'hunter'=>$infor['bhg_id'], 'name'=>stripslashes($infor['save_name']));
			}
		}
		
		return $return;
	}
    
    function GetBackups(){
	    $sql = "SELECT * FROM `character_sheet_backup`";
	    $query = mysql_query($sql, $this->holonet);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
	    	$date = getdate($info['date']);
			$return[$info['id']] = array('id'=>$info['id'], 'bhg_id'=>$info['bhg_id'], 'date'=>$date['mon'].'/'.$date['mday'].'/'.$date['year'], 'name'=>stripslashes($info['save_name']), 'share'=>0);
		}
		
		return $return;
    }
    
    function NewField($name, $desc){
	    $sql = "INSERT INTO `cs_fields` (`name`, `desc`) VALUES ('".addslashes($name)."', '".addslashes($desc)."')";
	    
	    if (mysql_query($sql, $this->holonet)){
		    return mysql_insert_id($this->holonet);
	    } else {
		    return false;
	    }
    }
    
    function NewStatribute($name, $desc, $int, $field){
	    $sql = "INSERT INTO `cs_statributes` (`name`, `field`, `desc`, `int`) VALUES ('".addslashes($name)."', '$field', '".addslashes($desc)."', '$int')";
	    
	    if (mysql_query($sql, $this->holonet)){
		    return mysql_insert_id($this->holonet);
	    } else {
		    return false;
	    }
    }
    
    function NewSkill($name, $desc, $field){
	    $sql = "INSERT INTO `cs_skills` (`name`, `field`, `desc`) VALUES ('".addslashes($name)."', '$field', '".addslashes($desc)."')";
	    
	    if (mysql_query($sql, $this->holonet)){
		    return mysql_insert_id($this->holonet);
	    } else {
		    return false;
	    }
    }
    
    function NewVaraible($skill, $stat, $mod){
	    $sql = "INSERT INTO `cs_skill_equ` (`skill`, `statribute`, `modifier`) VALUES ('$skill', '$stat', '$mod')";
	    
	    if (mysql_query($sql, $this->holonet)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function GetFields(){
	    $sql = "SELECT * FROM `cs_fields` ORDER BY `name`";
	    $query = mysql_query($sql, $this->holonet);
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
	    $query = mysql_query($sql, $this->holonet);
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
	    $query = mysql_query($sql, $this->holonet);
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
	    $sql = "SELECT character_sheets.bhg_id FROM character_sheets, character_sheet_values WHERE "
	    		."character_sheets.date_deleted = 0 AND character_sheet_values.id = character_sheets.id GROUP BY character_sheet_values.id "
	    		."ORDER BY character_sheets.pending ASC, character_sheets.approved ASC, character_sheets.last_change DESC";
	    $query = mysql_query($sql, $this->holonet);
	    $return = array();

	    while ($info = mysql_fetch_array($query)){
			$return[] = $info['bhg_id'];
	    }
	    
	    return $return;
    }
    
    function Pending($exclude = 0){
	    $sql = "SELECT character_sheets.bhg_id FROM character_sheets, character_sheet_values WHERE "
	    		."character_sheets.date_deleted = 0 AND character_sheets.pending > 0 AND character_sheet_values.id = character_sheets.id GROUP BY character_sheet_values.id "
	    		."ORDER BY character_sheets.pending ASC, character_sheets.approved ASC, character_sheets.last_change DESC";
	    $query = mysql_query($sql, $this->holonet);
	    $return = array();
	    
	    echo mysql_error($this->holonet);

	    while ($info = mysql_fetch_array($query)){
			$return[] = $info['bhg_id'];
	    }
	    
	    return $return;
    }
    
    function DeleteBlank(){
	    $sql = "SELECT * FROM `character_sheets` WHERE `date_deleted` = 0 ORDER BY `pending` ASC, `approved` ASC, `last_change` DESC";
	    $query = mysql_query($sql, $this->holonet);
	    
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