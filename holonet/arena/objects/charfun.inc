<?

 Class Charex extends Character {
	 
	function Charex($bhg_id){
		Character::Character($bhg_id);
	}
	 
	function SaveCore($statributes, $expertises, $personalinfo, $coreid = 0){
		$errors = array();
		$compile = array(1=>$statributes, 2=>$expertises, 3=>$personalinfo);
		//Error Checking
		
	    if (array_sum($statributes) > $this->StatributePoints()){
		    $errors[] = 'You have used more Statribute Points than you are allowed. ('.array_sum($statributes).'/'.$this->StatributePoints().')'; 
	    }
	    
	    if (array_sum($expertises) > $this->ExpertisePoints()){
			$errors[] = 'You have used more Expertise Points than you are allowed. ('.array_sum($expertises).'/'.$this->TotalPoints().')'; 
	    }
	     
	    foreach($statributes as $stat=>$value){
		    if ($value == 0){
			    $statribute = new Statribute($stat);
			    $errors[] = 'You must allocate at least 1 point to your '.$statribute->GetName().'.';
		    }
		    if ($value > 10){
			    $statribute = new Statribute($stat);
			    $errors[] = 'You have allocate more than 10 points to your '.$statribute->GetName().'.';
		    }
	    }
	    
	    foreach($expertises as $stat=>$value){
		    if ($value > 10){
			    $statribute = new Statribute($stat);
			    $errors[] = 'You have allocate more than 10 points to your '.$statribute->GetName().' expertise.';
		    }
	    }
	    
	    foreach($personalinfo as $stat=>$value){
		    $statribute = new Statribute($stat);
		    if (is_numeric($value) && $statribute->IsInt()){
			    if ($value > 10){
				    $errors[] = 'You have allocate more than 10 points to your '.$statribute->GetName().'.';
			    }
		    }
	    }
	    
	    if (count($errors)){
		    return implode('<br />', $errors);
	    }
	    
	    $errors = array();
	    
	    //No errors, write the document to Pending Sheets
	    
	    if ($coreid){
			$sql = "DELETE FROM `character_sheet_cores` WHERE `id` = '$coreid'";
			mysql_query($sql, $this->connect);
			$id = $coreid;
		} else {
			$new = "INSERT INTO `character_sheet_core` VALUES ('', '".$this->GetID()."', 0, '".time()."', '', '')";
		    $store = mysql_query($new, $this->connect);
		    $id = mysql_insert_id($this->connect);
		    $errors = array();
	    }
	    
	    $this->LastID = $id;
	    
	    for ($i = 1; $i <= 3; $i++){
		    foreach($compile[$i] as $key=>$value){
			    if (is_numeric($value)){
					$value = floor($value);
				} else {
					$value = addslashes($value);
				}
				
			    $sql = "INSERT INTO `character_sheet_cores` VALUES ('".$id."', '$key', '$value')";
			    if (!mysql_query($sql, $this->connect)){
				    $errors[] = 'Error Generated During Publish: '.mysql_error($this->connect);
			    }
		    }
	    }
	    
	    if (count($errors)){
		    $sql = "DELETE FROM `character_sheet_cores` WHERE `id` = '".$id."'";
			mysql_query($sql, $this->connect);
			$errors[] = '<b>Problem publishing sheet. Changes not published, report this error ASAP</b>';
		    return implode('<br />', $errors);
	    }
	    
	    //No errors, update status
	    
	    return 'Your core sheet has been saved.';	    
    }
    
    function SubmitCore($id){
	    $sql = "UPDATE `character_sheet_core` SET `pending` = '1', `approved` = 0 WHERE `id` = '$id'";
		if (mysql_query($sql, $this->connect)){
			$sheet = new Sheet();
			$registrar = new Person($sheet->CurrentRegistrar()); 
            
            $text = "A new CORE sheet has been submitted for approval.";

            $from = "overseer@thebhg.org";
            $subject = "Character Pending Approval";

            $registrar->SendEmail($from, $subject, $text);
			return 'Your CORE sheet has been submitted for approval. It is now pending review by the Overseer or Adjunct.';
		} else {
			return 'Error in update: '.mysql_error($this->connect);
		}	   
	}
    
	function DeleteCore($coreid){		
	    $sql = "UPDATE `character_sheet_core` SET `date_deleted` = '".time()."' WHERE `id` = '$coreid'";		
		if (mysql_query($sql, $this->connect)){
			return 'Your CORE sheet has been deleted.';
		} else {
			return 'Error in delete: '.mysql_error($this->connect);
		}	   
	}
	
	function ApproveCore($id){	    
	    $sql = "UPDATE `character_sheet_core` SET `date` = '".time()."', `pending` = 0, `approved` = 1 WHERE `id` = '".$id."'";
		if (mysql_query($sql, $this->connect)){
			$sheet = new Sheet(); 
			$registrar = new Person($sheet->CurrentRegistrar()); 
            $hunter = new Person($this->GetID());
            
            $text = $hunter->GetName().", one of your CORE sheet has been approved by the RP staff.";

            $from = "overseer@thebhg.org";
            $subject = "CORE Character Approved";

            $registrar->SendEmail($from, $subject, $text);
            $hunter->SendEmail($from, $subject, $text);
			return 'Sheet approved.';
		} else {
			return 'Error in update: '.mysql_error($this->connect);
		}	   
	}
	
	function DenyCore($id, $reason = ''){
		$sql = "UPDATE `character_sheet_core` SET `date` = '".time()."', `pending` = 0, `approved` = 0 WHERE `id` = '".$id."'";		
		if (mysql_query($sql, $this->connect)){
			$sheet = new Sheet();
			$registrar = new Person($sheet->CurrentRegistrar()); 
            $hunter = new Person($this->GetID());
            
            $text = $hunter->GetName().", one of your CORE sheet has been denied by the RP staff.";
            
            if ($reason){
	            $text .= "\r\n\r\nReason: ".$reason;
            }

            $from = "overseer@thebhg.org";
            $subject = "CORE Character Denied";

            $registrar->SendEmail($from, $subject, $text);
            $hunter->SendEmail($from, $subject, $text);
			return 'Character Denied.';
		} else {
			return 'Error in update: '.mysql_error($this->connect);
		}	   
	}
	
	function GetBackups(){
		$sql = "SELECT * FROM `character_sheet_backup` WHERE `bhg_id` = '".$this->GetID()."' AND `date_deleted` = 0 ORDER BY `date` DESC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$date = getdate($info['date']);
			$return[$info['id']] = array('id'=>$info['id'], 'bhg_id'=>$info['bhg_id'], 'date'=>$date['mon'].'/'.$date['mday'].'/'.$date['year'], 'name'=>stripslashes($info['save_name']), 'share'=>0);
		}
		
		$sql = "SELECT * FROM `cs_shares` WHERE `bhg_id` = '".$this->GetID()."' AND `date_deleted` = 0";
		$query = mysql_query($sql, $this->connect);
		
		while ($mofo = mysql_fetch_array($query)){
			$sql = "SELECT * FROM `character_sheet_backup` WHERE `id` = '".$mofo['sheet']."' AND `date_deleted` = 0";
			$querya = mysql_query($sql, $this->connect);
			$info = mysql_fetch_array($querya);
			$date = getdate($info['date']);
			$return[$info['id']] = array('id'=>$info['id'], 'bhg_id'=>$this->GetID(), 'date'=>$date['mon'].'/'.$date['mday'].'/'.$date['year'], 'name'=>stripslashes($info['save_name']), 'share'=>1);
		}
		
		return $return;
	}
	
	function GetSaveFunctions(){
		$sql = "SELECT * FROM `character_sheet_record` WHERE `bhg_id` = '".$this->GetID()."' ORDER BY `date` DESC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$date = getdate($info['date']);
			$return[$info['id']] = array('id'=>$info['id'], 'bhg_id'=>$info['bhg_id'], 'date'=>$date['mon'].'/'.$date['mday'].'/'.$date['year']);
		}
		
		return $return;
	}
	
	function GetCores(){
		$sql = "SELECT * FROM `character_sheet_core` WHERE `bhg_id` = '".$this->GetID()."' AND `date_deleted` = 0 ORDER BY `date` DESC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$date = getdate($info['date']);
			$return[$info['id']] = array('id'=>$info['id'], 'bhg_id'=>$info['bhg_id'], 'date'=>$date['mon'].'/'.$date['mday'].'/'.$date['year'], 'name'=>stripslashes($info['save_name']), 'app'=>$info['approved'], 'pending'=>$info['pending']);
		}
		
		return $return;
	}
	
	function Backup($save_name, $from = 'values', $id = 0){
		if (!$id){
			$id = $this->GetSheetID();
		}
	    $sql = "SELECT * FROM `character_sheet_$from` WHERE `id` = '".$id."'";
	    $query = mysql_query($sql, $this->connect);
	    
	    $new = "INSERT INTO `character_sheet_backup` VALUES ('', '".$this->GetID()."', '".addslashes($save_name)."', '".time()."', '')";
	    $store = mysql_query($new, $this->connect);
	    $id = mysql_insert_id($this->connect);
	    $errors = 0;
	    
	    while($info = mysql_fetch_array($query)){
		    $sql = "INSERT INTO `character_sheet_backups` VALUES ('$id', '".$info['statribute']."', '".addslashes($info['value'])."')";
		    if (!mysql_query($sql, $this->connect)){
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
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$sqla = "SELECT * FROM `cs_shares` WHERE `sheet` = '".$info['id']."' AND `date_deleted` = 0";
			$querya = mysql_query($sqla, $this->connect);
			$infer = mysql_fetch_array($querya);
			if (mysql_num_rows($querya)){
				$return[] = array('id'=>$info['id'], 'hunter'=>$infer['bhg_id'], 'name'=>stripslashes($info['save_name']));
			}
		}
		
		return $return;
	}		
	
	function Share($bhg_id, $sheet){
		$sql = "INSERT INTO `cs_shares` VALUES ('$bhg_id', '$sheet', '')";
		if (mysql_query($sql, $this->connect)){
			return 'Sheet shared successfully';
		} else {
			return 'Sheet shared failed';
		}
	}
	
	function RemoveShare($bhg_id, $sheet){
		$sql = "UPDATE `cs_shares` SET `date_deleted` = '".time()."' WHERE `bhg_id` = '$bhg_id' AND `sheet` = '$sheet'";
		if (mysql_query($sql, $this->connect)){
			return 'Sheet deshare successful';
		} else {
			return 'Sheet deshare failed';
		}
	}
	
	function DeleteBackup($id){
		$delsql = "UPDATE `character_sheet_backup` SET `date_deleted` = '".time()."' WHERE `id` = '".$id."'";
		mysql_query($delsql, $this->connect);
	    
	    $delsql = "UPDATE `cs_shares` SET `date_deleted` = '".time()."' WHERE `sheet` = '".$id."'";
	    mysql_query($delsql, $this->connect);
	}
	
	function LoadBackup($id){
		$sql = "SELECT * FROM `character_sheet_backups` WHERE `id` = '".$id."'";
	    $query = mysql_query($sql, $this->connect);
	    
	    if (mysql_num_rows($query)){
		    $delsql = "DELETE FROM `character_sheet_pending` WHERE `id` = '".$this->GetSheetID()."'";
		    mysql_query($delsql, $this->connect);
	    }
	    
	    $errors = 0;
	    
	    while($info = mysql_fetch_array($query)){
		    $sql = "INSERT INTO `character_sheet_pending` VALUES ('".$this->GetSheetID()."', '".$info['statribute']."', '".addslashes($info['value'])."')";
		    if (!mysql_query($sql, $this->connect)){
			    $errors++;
		    }
	    }
	    
	    $sql = "UPDATE `character_sheets` SET `last_change` = '".time()."', `pending` = 0, `approved` = 0 WHERE `id` = '".$this->GetSheetID()."'";
		if (!$errors && mysql_query($sql, $this->connect)){
			return 'Backup loaded as edit sheet.';
		} else {
			$arena = new Arena();
			return $arena->NEC(159);
		}	   
	}
	
	function LoadSaveFunction($id){
		$sql = "SELECT * FROM `character_sheet_records` WHERE `id` = '".$id."'";
	    $query = mysql_query($sql, $this->connect);
	    
	    if (mysql_num_rows($query)){
		    $delsql = "DELETE FROM `character_sheet_pending` WHERE `id` = '".$this->GetSheetID()."'";
		    mysql_query($delsql, $this->connect);
	    }
	    
	    $errors = 0;
	    
	    while($info = mysql_fetch_array($query)){
		    $sql = "INSERT INTO `character_sheet_pending` VALUES ('".$this->GetSheetID()."', '".$info['statribute']."', '".addslashes($info['value'])."')";
		    if (!mysql_query($sql, $this->connect)){
			    $errors++;
		    }
	    }
	    
	    $sql = "UPDATE `character_sheets` SET `last_change` = '".time()."', `pending` = 0, `approved` = 0 WHERE `id` = '".$this->GetSheetID()."'";
		if (!$errors && mysql_query($sql, $this->connect)){
			return 'Auto-Save loaded as edit sheet.';
		} else {
			$arena = new Arena();
			return $arena->NEC(159);
		}	   
	}
	
	function LoadCore($id){
		$sql = "SELECT * FROM `character_sheet_cores` WHERE `id` = '".$id."'";
	    $query = mysql_query($sql, $this->connect);
	    
	    if (mysql_num_rows($query)){
		    $delsql = "DELETE FROM `character_sheet_pending` WHERE `id` = '".$this->GetSheetID()."'";
		    mysql_query($delsql, $this->connect);
	    }
	    
	    $errors = 0;
	    
	    while($info = mysql_fetch_array($query)){
		    $sql = "INSERT INTO `character_sheet_pending` VALUES ('".$this->GetSheetID()."', '".$info['statribute']."', '".addslashes($info['value'])."')";
		    if (!mysql_query($sql, $this->connect)){
			    $errors++;
		    }
	    }
	    
	    $sql = "UPDATE `character_sheets` SET `last_change` = '".time()."', `pending` = 0, `approved` = 0 WHERE `id` = '".$this->GetSheetID()."'";
		if (!$errors && mysql_query($sql, $this->connect)){
			return 'CORE loaded as edit sheet.';
		} else {
			$arena = new Arena();
			return $arena->NEC(159);
		}	   
	}