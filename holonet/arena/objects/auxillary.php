<?php

Class Saves extends Character {

	function Saves($bhg_id){
		Character::Character($bhg_id);
	}
	
	function GetBackups($limit = 0){
		$sql = "SELECT * FROM `character_sheet_backup` WHERE `bhg_id` = '".$this->GetID()."' AND `date_deleted` = 0 ORDER BY `date` DESC".($limit ? ' LIMIT '.$limit : '');
		$query = mysql_query($sql, $this->holonet);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$date = getdate($info['date']);
			$return[$info['id']] = array('id'=>$info['id'], 'bhg_id'=>$info['bhg_id'], 'date'=>$date['mon'].'/'.$date['mday'].'/'.$date['year'], 'name'=>stripslashes($info['save_name']), 'share'=>0);
		}
		
		$sql = "SELECT * FROM `cs_shares` WHERE `bhg_id` = '".$this->GetID()."' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->holonet);
		
		while ($mofo = mysql_fetch_array($query)){
			$sql = "SELECT * FROM `character_sheet_backup` WHERE `id` = '".$mofo['sheet']."' AND `date_deleted` = 0";
			$querya = mysql_query($sql, $this->holonet);
			$info = mysql_fetch_array($querya);
			$date = getdate($info['date']);
			$return[$info['id']] = array('id'=>$info['id'], 'bhg_id'=>$this->GetID(), 'date'=>$date['mon'].'/'.$date['mday'].'/'.$date['year'], 'name'=>stripslashes($info['save_name']), 'share'=>1);
		}
		
		return $return;
	}
	
	function GetSaveFunctions($limit = 0){
		$sql = "SELECT * FROM `character_sheet_record` WHERE `bhg_id` = '".$this->GetID()."' ORDER BY `date` DESC".($limit ? ' LIMIT '.$limit : '');
		$query = mysql_query($sql, $this->holonet);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$date = getdate($info['date']);
			$return[$info['id']] = array('id'=>$info['id'], 'bhg_id'=>$info['bhg_id'], 'date'=>$date['mon'].'/'.$date['mday'].'/'.$date['year']);
		}
		
		return $return;
	}
	
	function Backup($save_name, $from = 'values', $id = 0){
		if (!$id){
			$id = $this->GetSheetID();
		}
	    $sql = "SELECT * FROM `character_sheet_$from` WHERE `id` = '".$id."'";
	    $query = mysql_query($sql, $this->holonet);
	    
	    $new = "INSERT INTO `character_sheet_backup` VALUES ('', '".$this->GetID()."', '".addslashes($save_name)."', '".time()."', '')";
	    $store = mysql_query($new, $this->holonet);
	    $id = mysql_insert_id($this->holonet);
	    $errors = 0;
	    
	    while($info = mysql_fetch_array($query)){
		    $sql = "INSERT INTO `character_sheet_backups` (`id`, `statribute`, `value`) VALUES ('$id', '".$info['statribute']."', '".addslashes($info['value'])."')";
		    if (!mysql_query($sql, $this->holonet)){
			    $errors++;
		    }
	    }

		if (!$errors){
			return 'Sheet stored.';
		} else {
			$arena = new Arena();
			return $arena->NEC(160);
		}	   
	}
	
	function ValidLoad($id, $manage = 0){
		$backups = $this->GetBackups();
		$backup = $backups[$id];
		
		if ($manage){
			if ($backup['share']){
				$other = false;
			} else {
				$other = true;
			}
		} else {
			$other = true;
		}
		
		if ($backup && $other){
			return true;
		} else {
			if ($manage){
				if ($backup){
					echo 'You cannot manage sheets which others have shared with you.';
					hr();
				}
			}
			return false;
		}
	}
	
	function MyShares(){
		$sql = "SELECT * FROM `character_sheet_backup` WHERE `bhg_id` = '".$this->GetID()."' AND `date_deleted` = 0 ORDER BY `date` DESC";
		$query = mysql_query($sql, $this->holonet);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$sqla = "SELECT * FROM `cs_shares` WHERE `sheet` = '".$info['id']."' AND `date_deleted` = 0";
			$querya = mysql_query($sqla, $this->holonet);
			$infer = mysql_fetch_array($querya);
			if (mysql_num_rows($querya)){
				$return[] = array('id'=>$info['id'], 'hunter'=>$infer['bhg_id'], 'name'=>stripslashes($info['save_name']));
			}
		}
		
		return $return;
	}		
	
	function Share($bhg_id, $sheet){
		$sql = "INSERT INTO `cs_shares` VALUES ('$bhg_id', '$sheet', '')";
		if (mysql_query($sql, $this->holonet)){
			return 'Sheet shared successfully';
		} else {
			return 'Sheet shared failed';
		}
	}
	
	function RemoveShare($bhg_id, $sheet){
		$sql = "UPDATE `cs_shares` SET `date_deleted` = '".time()."' WHERE `bhg_id` = '$bhg_id' AND `sheet` = '$sheet'";
		if (mysql_query($sql, $this->holonet)){
			return 'Sheet deshare successful';
		} else {
			return 'Sheet deshare failed';
		}
	}
	
	function DeleteBackup($id){
		$delsql = "UPDATE `character_sheet_backup` SET `date_deleted` = '".time()."' WHERE `id` = '".$id."'";
		mysql_query($delsql, $this->holonet);
	    
	    $delsql = "UPDATE `cs_shares` SET `date_deleted` = '".time()."' WHERE `sheet` = '".$id."'";
	    mysql_query($delsql, $this->holonet);
	}
	
	function LoadBackup($id){
		$sql = "SELECT * FROM `character_sheet_backups` WHERE `id` = '".$id."'";
	    $query = mysql_query($sql, $this->holonet);
	    
	    if (mysql_num_rows($query)){
		    $delsql = "DELETE FROM `character_sheet_pending` WHERE `id` = '".$this->GetSheetID()."'";
		    mysql_query($delsql, $this->holonet);
	    }
	    
	    $errors = 0;
	    
	    while($info = mysql_fetch_array($query)){
		    $sql = "INSERT INTO `character_sheet_pending` (`id`, `statribute`, `value`) VALUES ('".$this->GetSheetID()."', '".$info['statribute']."', '".addslashes($info['value'])."')";
		    if (!mysql_query($sql, $this->holonet)){
			    $errors++;
		    }
	    }
	    
	    $sql = "UPDATE `character_sheets` SET `last_change` = '".time()."', `pending` = 0, `approved` = 0 WHERE `id` = '".$this->GetSheetID()."'";
		if (!$errors && mysql_query($sql, $this->holonet)){
			return 'Backup loaded as edit sheet.';
		} else {
			$arena = new Arena();
			return $arena->NEC(159);
		}	   
	}
	
	function LoadSaveFunction($id){
		$sql = "SELECT * FROM `character_sheet_records` WHERE `id` = '".$id."'";
	    $query = mysql_query($sql, $this->holonet);
	    
	    if (mysql_num_rows($query)){
		    $delsql = "DELETE FROM `character_sheet_pending` WHERE `id` = '".$this->GetSheetID()."'";
		    mysql_query($delsql, $this->holonet);
	    }
	    
	    $errors = 0;
	    
	    while($info = mysql_fetch_array($query)){
		    $sql = "INSERT INTO `character_sheet_pending` (`id`, `statribute`, `value`) VALUES ('".$this->GetSheetID()."', '".$info['statribute']."', '".addslashes($info['value'])."')";
		    if (!mysql_query($sql, $this->holonet)){
			    $errors++;
		    }
	    }
	    
	    $sql = "UPDATE `character_sheets` SET `last_change` = '".time()."', `pending` = 0, `approved` = 0 WHERE `id` = '".$this->GetSheetID()."'";
		if (!$errors && mysql_query($sql, $this->holonet)){
			return 'Auto-Save loaded as edit sheet.';
		} else {
			$arena = new Arena();
			return $arena->NEC(159);
		}	   
	}
}
?>