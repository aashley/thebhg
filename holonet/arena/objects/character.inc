<?

 Class Character extends Sheet {

    var $cs_bhg_id;
    var $cs_last_change;
    var $cs_approved;
    var $cs_person;
    var $cs_pending;
    var $cs_ban;

    function Character($id) {
        Sheet::Sheet();
        
        $sql = "SELECT * FROM `character_sheets` WHERE `bhg_id` = '$id'";
        $query = mysql_query($sql, $this->connect);

        $this->cs_person = new Person($id);
        
        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'cs_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }
    
    function UpdateCache(){
	    $sql = "SELECT * FROM `character_sheets` WHERE `bhg_id` = '".$this->cs_bhg_id."'";
        $query = mysql_query($sql, $this->connect);
        
        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'cs_'.$key;
                $this->$key = stripslashes($value);
            }

        }
    }
    
    function GetID(){
	    return $this->cs_person->GetID();
    }
    
    function GetName($look = 'values', $id = 0, $col = 'bhg_id'){
	    
	    $stat = $this->Point(33, 'SHEET', $look, $id, $col);
	    
	    if (empty($stat)){
		    $name = $this->cs_person->GetName();
	    } else {
		    $name = $stat;
	    }
	    
	    return $name;
    }
    
    function LastEdit(){
	    $date = getdate($this->cs_last_change);
	    return $date['month'] . ' ' . $date['mday'] . ', ' . $date['year'];
    }
    
    function Status($output){
	    $status = array(1=>'Approved', 2=>'Not Created', 3=>'Edit in Progress', 5=>'Pending Approval', 4=>'Denied Character', 6=>'Pending Approval', -1=>'Blank Sheet');
	    if ($this->cs_bhg_id){
		    if ($this->cs_last_change){
			    if ($this->cs_approved){
				    $return = 1;
			    } else {
				    if ($this->cs_pending){
					    $return = 3;
				    } else {
				    	$return = 5;
			    	}
			    }
		    }
		    if (!$this->HasValue() && !$this->HasValue('pending')){
			    $return = -1;
		    }
		    if (!$this->HasValue()){
			    if ($this->cs_approved){
			    	$return = 4;
		    	} else {
			    	if (!$this->cs_pending){
			    		$return = 6;
		    		}
		    	}
	    	}
	    } else {
		    $return = 2;
	    }

	    if ($output == 'HUMAN'){
		    return $status[$return];
	    } elseif ($output == 'SYSTEM'){
		    return $return;
	    }
    }	    
    
    function Editable(){
	    if ($this->Status('SYSTEM') == 5 || $this->Status('SYSTEM') == 6 || $this->cs_ban > time()){
		    return false;
	    } else {
		    return true;
	    }
    }
    
    function IsNew(){
	    if ($this->Status('SYSTEM') == 2){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function InProgress(){
	    if ($this->Status('SYSTEM') == 3){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function PendingApproval(){
	    if ($this->Status('SYSTEM') == 5 || $this->Status('SYSTEM') == 6){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function Includeable(){
	    $inc = array(1,3,5);
	    if (in_array($this->Status('SYSTEM'), $inc)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function Ban($date){
	    $sql = "UPDATE `character_sheets` SET `ban` = '$date' WHERE `bhg_id` = '".$this->GetID()."'";
	    $query = mysql_query($sql, $this->connect);
	    return ($query ? true : false);
    }
    
    function GetBan($type = 'SYSTEM'){
	    if ($type == 'HUMAN'){
		    if ($this->cs_ban >= time()){
			    $date = getdate($this->cs_ban);
			    return $date['mon'].'/'.$date['mday'].'/'.$date['year'];
		    } else {
			    return 'No Edit Ban';
		    }
	    } else {
		    return $this->cs_ban;
	    }
    }
		    
    
    function GetSheetValues($value = 'values'){
	    $table = '`character_sheet_'.$value.'`';
	    $sql = "SELECT * FROM $table WHERE `bhg_id` = '".$this->GetID()."'";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();

	    while ($info = mysql_fetch_array($query)){
		    $return[$info['statribute']] = $info['value'];
	    }
	    
	    return $return;
    }
    
    function Point($stat, $output = 'SHEET', $look = 'values', $id = 0, $col = 'bhg_id'){
	    if ($id){
		    $id = $id;
	    } else {
		    $id = $this->GetID();
	    }
	    $table = '`character_sheet_'.$look.'`';
	    $sql = "SELECT * FROM $table WHERE `$col` = '".$id."' AND `statribute` = '$stat'";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);
        $stat = new Statribute($stat);
        
        if ($output == 'SHEET'){
	        if ($stat->IsInt()){
		        $return = str_repeat('<img src="arena/images/X.png" alt="X" height=20 width=20>', $info['value']);
		        $return .= str_repeat('<img src="arena/images/0.png" alt="0" height=20 width=20>', 10-$info['value']);
	        	return $return;
	    	} else {
		    	return nl2br(stripslashes($info['value']));
	    	}
    	} elseif ($output == 'SYSTEM'){
	    	return $info['value'];
    	}
    }
    
    function GetValue($skill, $look = 'values', $render = 'SHEET', $id, $col){
	    $sql = "SELECT * FROM `cs_skill_equ` WHERE `skill` = '$skill'";
        $query = mysql_query($sql, $this->connect);
        
        $output = 0;
        
        while($info = mysql_fetch_array($query)){
	        $output += $this->Point($info['statribute'], 'SYSTEM', $look, $id, $col)*$info['modifier'];
        }
        
        $sql = "SELECT SUM(`modifier`) as denominator FROM `cs_skill_equ` WHERE `skill` = '$skill'";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);
        
        $denominator = $info['denominator'];
        
        $value = round($output/$denominator);
        if ($render == 'SHEET'){
	        $return = str_repeat('<img src="arena/images/bonus.png" alt="*" height=20 width=20>', $value);
	        $return .= str_repeat('<img src="arena/images/0.png" alt="0" height=20 width=20>', 10-$value);
        } else {
	        $return = $value;
        }
    	return $return;
    }
	        
    function BonusPoints($disp = false){
	    $points = 0;
	    
	    $array = array();
	    
	    $positions = array();
	    $rewards = array();
	    
	    $history = $this->cs_person->GetHistory();
	    
	    $history->Load(0, 0, array(2, 3));
	    
	    //Build what we're looking for.
	    $positions[2] = array(1, 11, 10, 12);
	    $positions[3] = array(10, 9);
	    $rewards[21] = 5;
	    $rewards[211] = 2;
	    $rewards[210] = 2;
	    $rewards[212] = 1;
	    $rewards[310] = 4;
	    $rewards[39] = 2;
	    $awards = array();
	    
	    for ($i = 1; $i <= $history->Count(); $i++){
		    $hist = $history->GetItem();
		    $index1 = $hist->GetType().$hist->GetItem(1);
		    $index2 = $hist->GetType().$hist->GetItem(2);
		    if (array_key_exists($index1, $rewards)){
			    $awards[] = $rewards[$index1];
		    }
		    if (array_key_exists($index2, $rewards)){
			    $awards[] = $rewards[$index2];
		    }
		    $history->Next();		    
	    }
	    
		$awards = array_unique($awards);
		arsort($awards);
		$points += array_shift($awards);
    	
    	$array['Position'] = $points;
    	
    	//Get Rank Points
    	$rank = $this->cs_person->GetRank();
    	
    	if ($rank->GetWeight() <= 3){
	    	$points += 5;
    	} elseif ($rank->GetWeight() <= 7){
	    	$points += 4;
    	} elseif ($rank->GetWeight() <= 9){
	    	$points += 3;
    	} elseif ($rank->GetWeight() <= 11){
	    	$points += 2;
    	} elseif ($rank->GetWeight() <= 14){
	    	$points += 1;
    	} 
    	
    	$array['Rank'] = $points-$array['Position'];
    	
    	//Get Timein Points
    	$join = $this->cs_person->GetJoinDate();
    	$seconds = time()-$join;
    	$days = floor($seconds / 86400);
		$years = floor($days / 365);
		$days %= 365;
		$weeks = floor($days / 7);
		$days %= 7;
		
		if ($years){
			$points += $years;
			$points++;
		} else {
			if ($weeks >= 26){
				$points++;
			}
		}
		
		$array['Timein'] = $points-$array['Rank']-$array['Position'];
		
		//Get Medal Points
		$medals = $this->cs_person->GetMedals();
		$build = array();
		$medal_array = array(1, 4, 7, 8);
		
		foreach ($medals as $value){
			$medal = $value->GetMedal();
			$group = $medal->GetGroup();
			$build[] = $group->GetID();
		}
		
		$medals = array_unique($build);
		
		$hme = false;
		
		foreach ($medals as $medal){
			if (in_array($medal, $medal_array)){
				$points++;
			}
			
			if ($medal == 2 || $medal == 3){
				if ($hme == false){
					$points++;
					$hme = true;
				}
			}
		}
		
		$array['Medals'] = $points-$array['Rank']-$array['Position']-$array['Timein'];
	
		$points += $this->GetBonusPoints();
		
		$array['Bonus_Points'] = $points-$array['Rank']-$array['Position']-$array['Timein']-$array['Medals'];
		
		if ($disp){
			return $array;
		} else {
			return $points;
		}
    }
    
    function GetBonusPoints(){
	    $sql = "SELECT * FROM `cs_bonus_points` WHERE `bhg_id` = '".$this->GetID()."'";
		$query = mysql_query($sql, $this->connect);
		
		$demsql = "SELECT * FROM `cs_demerit_points` WHERE `bhg_id` = '".$this->GetID()."'";
		$demquery = mysql_query($demsql, $this->connect);
		
		return mysql_num_rows($query)-mysql_num_rows($demquery);
	}
	
	function GetExperiencePoints(){
	    $sql = "SELECT SUM(`points`) as points FROM `cs_experience` WHERE `bhg_id` = '".$this->GetID()."'";
		$query = mysql_query($sql, $this->connect);
		$return = mysql_fetch_array($query);
		
		return $return['points'];
	}
    
    function TotalPoints(){
	    return $this->ExpertisePoints()+$this->BonusPoints();
    }
	
    function SaveSheet($statributes, $expertises, $personalinfo){
		$errors = array();
		$compile = array(1=>$statributes, 2=>$expertises, 3=>$personalinfo);
		//Error Checking
		
	    if (array_sum($statributes) > $this->StatributePoints()){
		    $errors[] = 'You have used more Statribute Points than you are allowed. ('.array_sum($statributes).'/'.$this->StatributePoints().')'; 
	    }
	    
	    if (array_sum($expertises) > $this->TotalPoints()){
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
		    if (is_numeric($value)){
			    if ($value > 10){
				    $statribute = new Statribute($stat);
				    $errors[] = 'You have allocate more than 10 points to your '.$statribute->GetName().'.';
			    }
		    }
	    }
	    
	    if (count($errors)){
		    return implode('<br />', $errors);
	    }
	    
	    $errors = array();
	    
	    //No errors, write the document to Pending Sheets
	    
	    for ($i = 1; $i <= 3; $i++){
		    foreach($compile[$i] as $key=>$value){
			    if (is_numeric($value)){
					$value = floor($value);
				} else {
					$value = addslashes($value);
				}
				
			    $sql = "DELETE FROM `character_sheet_pending` WHERE `bhg_id` = '".$this->GetID()."' AND `statribute` = '$key'";
			    mysql_query($sql, $this->connect);
			    
			    $sql = "INSERT INTO `character_sheet_pending` VALUES ('".$this->GetID()."', '$key', '$value')";
			    if (!mysql_query($sql, $this->connect)){
				    $errors[] = 'Error Generated During Publish: '.mysql_error($this->connect);
			    }
		    }
	    }
	    
	    if (count($errors)){
		    $sql = "DELETE FROM `character_sheet_pending` WHERE `bhg_id` = '".$this->GetID()."'";
			mysql_query($sql, $this->connect);
			$errors[] = '<b>Problem publishing sheet. Changes not published, report this error ASAP</b>';
		    return implode('<br />', $errors);
	    }
	    
	    //No errors, update status
	    
	    $sql = "UPDATE `character_sheets` SET `last_change` = '".time()."', `pending` = 1, `approved` = 0 WHERE `bhg_id` = '".$this->GetID()."'";
		if (mysql_query($sql, $this->connect)){
			return 'Your character sheet has been saved. You may submit it at any time for approval. Your sheet can not be approved until you submit it.';
		} else {
			return 'Error in update: '.mysql_error($this->connect);
		}	    
    }
    
    function SubmitSheet(){
	    $sql = "UPDATE `character_sheets` SET `last_change` = '".time()."', `pending` = 0, `approved` = 0 WHERE `bhg_id` = '".$this->GetID()."'";
		if (mysql_query($sql, $this->connect)){
			$adjunct = $this->Adjunct();
            $overseer = $this->Overseer();
            
            $text = "A new sheet has been submitted. Please go and review it at your earliest convenience.\r\n\r\n-Office of Character Development";

            $from = "Office of Character Development <overseer@thebhg.org>";
            $subject = "Character Pending Approval";

            $adjunct->SendEmail($from, $subject, $text);
            $overseer->SendEmail($from, $subject, $text);
			return 'Your character sheet has been submitted for approval. It is now pending review by the Overseer or Adjunct.';
		} else {
			return 'Error in update: '.mysql_error($this->connect);
		}	   
	}
	
	function XPEvent($points, $reason){
		$sql = "INSERT INTO `cs_experience` VALUES ('".$this->GetID()."', '$points', '".time()."', '".addslashes($reason)."')";
		if (mysql_query($sql, $this->connect)){
			return true;
		} else {
			return false;
		}
	}
	
	function WriteXPEvents(){
		$sql = "SELECT * FROM `cs_experience` WHERE `bhg_id` = '".$this->GetID()."' ORDER BY `date` DESC";
		$query = mysql_query($sql, $this->connect);
		
		$table = new Table('', true);
		
		$table->StartRow();
		$table->AddHeader('Arena Experience', 3);
		$table->EndRow();
		
		if (mysql_num_rows($query)){
		
			$table->AddRow('Date', 'Points', 'Reason');
		
			while ($info = mysql_fetch_array($query)){
				$date = getdate($info['date']);
				if ($info['reason']){
					$reason = stripslashes($info['reason']);
				} else {
					$reason = 'No reason given.';
				}
				$table->AddRow($date['mon'].'/'.$date['mday'].'/'.$date['year'], $info['points'], $reason);
			}
		} else {
			$table->StartRow();
			$table->AddCell('No experience point history.');
			$table->EndRow();
		}
		
		$table->EndTable();
	}
	
	function BuyPoint(){
		if ($this->XPEvent(-350, 'Bonus Point Purchase')){
			if ($this->AddPoint('Bonus Point Purchase', 1)){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	function AddPoint($reason, $purchase = 0){
		$sql = "INSERT INTO `cs_bonus_points` VALUES ('".$this->GetID()."', '".time()."', '$purchase', '".addslashes($reason)."')";
		if (mysql_query($sql, $this->connect)){
			return true;
		} else {
			return false;
		}
	}
	
	function RemovePoint($reason){
		$sql = "INSERT INTO `cs_demerit_points` VALUES ('".$this->GetID()."', '".time()."', '".addslashes($reason)."')";
		if (mysql_query($sql, $this->connect)){
			return true;
		} else {
			return false;
		}
	}
	
	function WritePointEvents(){
		$table = new Table('', true);
		
		$awards = array();
		
		$table->StartRow();
		$table->AddHeader('Arena Points', 3);
		$table->EndRow();
		
		$sql = "SELECT * FROM `cs_bonus_points` WHERE `bhg_id` = '".$this->GetID()."' ORDER BY `date` DESC";
		$query = mysql_query($sql, $this->connect);
		
		while ($info = mysql_fetch_array($query)){
			$date = getdate($info['date']);
			if ($info['reason']){
				$reason = stripslashes($info['reason']);
			} else {
				$reason = 'No reason given.';
			}
			$awards[$info['date']][] = array('date'=>$date['mon'].'/'.$date['mday'].'/'.$date['year'], 'type'=>'Bonus Point', 'reason'=>$reason);
		}
		
		$sql = "SELECT * FROM `cs_demerit_points` WHERE `bhg_id` = '".$this->GetID()."' ORDER BY `date` DESC";
		$query = mysql_query($sql, $this->connect);
		
		while ($info = mysql_fetch_array($query)){
			$date = getdate($info['date']);
			if ($info['reason']){
				$reason = stripslashes($info['reason']);
			} else {
				$reason = 'No reason given.';
			}
			$awards[$info['date']][] = array('date'=>$date['mon'].'/'.$date['mday'].'/'.$date['year'], 'type'=>'Demerit Point', 'reason'=>$reason);
		}
		
		if (count($awards)){
			krsort($awards);
			$table->AddRow('Date', 'Type', 'Reason');
			foreach ($awards as $info){
				foreach ($info as $write){
					$table->AddRow($write['date'], $write['type'], $write['reason']);
				}
			}
		} else {
			$table->StartRow();
			$table->AddCell('No bonus point history.');
			$table->EndRow();
		}
		
		$table->EndTable();
	}
	
	function GetBackups(){
		$sql = "SELECT * FROM `character_sheet_backup` WHERE `bhg_id` = '".$this->GetID()."' ORDER BY `date` DESC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$date = getdate($info['date']);
			$return[$info['id']] = array('id'=>$info['id'], 'bhg_id'=>$info['bhg_id'], 'date'=>$date['mon'].'/'.$date['mday'].'/'.$date['year'], 'name'=>stripslashes($info['save_name']), 'share'=>0);
		}
		
		$sql = "SELECT * FROM `cs_shares` WHERE `bhg_id` = '".$this->GetID()."'";
		$query = mysql_query($sql, $this->connect);
		
		while ($mofo = mysql_fetch_array($query)){
			$sql = "SELECT * FROM `character_sheet_backup` WHERE `id` = '".$mofo['sheet']."'";
			$querya = mysql_query($sql, $this->connect);
			$info = mysql_fetch_array($querya);
			$date = getdate($info['date']);
			$return[$info['id']] = array('id'=>$info['id'], 'bhg_id'=>$this->GetID(), 'date'=>$date['mon'].'/'.$date['mday'].'/'.$date['year'], 'name'=>stripslashes($info['save_name']), 'share'=>1);
		}
		
		return $return;
	}
	
	function Backup($save_name, $from = 'values'){
	    $sql = "SELECT * FROM `character_sheet_$from` WHERE `bhg_id` = '".$this->GetID()."'";
	    $query = mysql_query($sql, $this->connect);
	    
	    $new = "INSERT INTO `character_sheet_backup` VALUES ('', '".$this->GetID()."', '".addslashes($save_name)."', '".time()."')";
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
		$sql = "SELECT * FROM `character_sheet_backup` WHERE `bhg_id` = '".$this->GetID()."' ORDER BY `date` DESC";
		$query = mysql_query($sql, $this->connect);
		$return = array();
		
		while ($info = mysql_fetch_array($query)){
			$sqla = "SELECT * FROM `cs_shares` WHERE `sheet` = '".$info['id']."'";
			$querya = mysql_query($sqla, $this->connect);
			$infer = mysql_fetch_array($querya);
			$return[] = array('sheet'=>$info['id'], 'hunter'=>$infer['bhg_id'], 'name'=>stripslashes($info['save_name']));
		}
		
		return $return;
	}		
	
	function Share($bhg_id, $sheet){
		$sql = "INSERT INTO `cs_shares` VALUES ('$bhg_id', '$sheet')";
		if (mysql_query($sql, $this->connect)){
			return 'Sheet shared successfully';
		} else {
			return 'Sheet shared failed';
		}
	}
	
	function RemoveShare($bhg_id, $sheet){
		$sql = "DELETE FROM `cs_shares` WHERE `bhg_id` = '$bhg_id' AND `sheet` = '$sheet'";
		if (mysql_query($sql, $this->connect)){
			return 'Sheet deshare successful';
		} else {
			return 'Sheet deshare failed';
		}
	}
	
	function DeleteBackup($id){
		$delsql = "DELETE FROM `character_sheet_backup` WHERE `id` = '".$id."'";
		mysql_query($delsql, $this->connect);

	    $delsql = "DELETE FROM `character_sheet_backups` WHERE `id` = '".$id."'";
	    mysql_query($delsql, $this->connect);
	    
	    $delsql = "DELETE FROM `cs_shares` WHERE `sheet` = '".$id."'";
	    mysql_query($delsql, $this->connect);
	}
	
	function LoadBackup($id){
		$sql = "SELECT * FROM `character_sheet_backups` WHERE `id` = '".$id."'";
	    $query = mysql_query($sql, $this->connect);
	    
	    if (mysql_num_rows($query)){
		    $delsql = "DELETE FROM `character_sheet_pending` WHERE `bhg_id` = '".$this->GetID()."'";
		    mysql_query($delsql, $this->connect);
	    }
	    
	    $errors = 0;
	    
	    while($info = mysql_fetch_array($query)){
		    $sql = "INSERT INTO `character_sheet_pending` VALUES ('".$this->GetID()."', '".$info['statribute']."', '".addslashes($info['value'])."')";
		    if (!mysql_query($sql, $this->connect)){
			    $errors++;
		    }
	    }
	    
	    $sql = "UPDATE `character_sheets` SET `last_change` = '".time()."', `pending` = 0, `approved` = 0 WHERE `bhg_id` = '".$this->GetID()."'";
		if (!$errors && mysql_query($sql, $this->connect)){
			return 'Backup loaded as edit sheet.';
		} else {
			$arena = new Arena();
			return $arena->NEC(159);
		}	   
	}
	
	function Approve(){
	    $sql = "SELECT * FROM `character_sheet_pending` WHERE `bhg_id` = '".$this->GetID()."'";
	    $query = mysql_query($sql, $this->connect);
	    
	    if (mysql_num_rows($query)){
		    $delsql = "DELETE FROM `character_sheet_values` WHERE `bhg_id` = '".$this->GetID()."'";
		    mysql_query($delsql, $this->connect);
		    $delsql2 = "DELETE FROM `character_sheet_pending` WHERE `bhg_id` = '".$this->GetID()."'";
		    mysql_query($delsql2, $this->connect);
	    }
	    
	    while($info = mysql_fetch_array($query)){
		    $sql = "INSERT INTO `character_sheet_values` VALUES ('".$this->GetID()."', '".$info['statribute']."', '".$info['value']."')";
		    mysql_query($sql, $this->connect);
	    }
	    
	    $sql = "UPDATE `character_sheets` SET `last_change` = '".time()."', `pending` = 0, `approved` = 1 WHERE `bhg_id` = '".$this->GetID()."'";
		if (mysql_query($sql, $this->connect)){
			$adjunct = $this->Adjunct();
            $overseer = $this->Overseer();
            $hunter = new Person($this->GetID());
            
            $text = $hunter->GetName().", your sheet has been approved by the RP staff.";

            $from = "Office of Character Development <overseer@thebhg.org>";
            $subject = "Character Approved";

            $adjunct->SendEmail($from, $subject, $text);
            $overseer->SendEmail($from, $subject, $text);
            $hunter->SendEmail($from, $subject, $text);
			return 'Sheet approved.';
		} else {
			return 'Error in update: '.mysql_error($this->connect);
		}	   
	}
	
	function Deny($reason = ''){
		$sql = "DELETE FROM `character_sheet_pending` WHERE `bhg_id` = '".$this->GetID()."'";
		mysql_query($sql, $this->connect);

		$sql = "UPDATE `character_sheets` SET `last_change` = '".time()."', `pending` = 0, `approved` = 1 WHERE `bhg_id` = '".$this->GetID()."'";		
		if (mysql_query($sql, $this->connect)){
			$adjunct = $this->Adjunct();
            $overseer = $this->Overseer();
            $hunter = new Person($this->GetID());
            
            $text = $hunter->GetName().", your sheet has been denied by the RP staff.";
            
            if ($reason){
	            $text .= "\r\n\r\nReason: ".$reason;
            }

            $from = "Office of Character Development <overseer@thebhg.org>";
            $subject = "Character Denied";

            $adjunct->SendEmail($from, $subject, $text);
            $overseer->SendEmail($from, $subject, $text);
            $hunter->SendEmail($from, $subject, $text);
			return 'Character Denied.';
		} else {
			return 'Error in update: '.mysql_error($this->connect);
		}	   
	}
	
	function Kill($reason = ''){
		$sql = "DELETE FROM `character_sheet_pending` WHERE `bhg_id` = '".$this->GetID()."'";
		mysql_query($sql, $this->connect);
		
	    $sql = "DELETE FROM `character_sheet_values` WHERE `bhg_id` = '".$this->GetID()."'";
	    mysql_query($sql, $this->connect);
	    
	    $sql = "DELETE FROM `character_sheets` WHERE `bhg_id` = '".$this->GetID()."'";

		if (mysql_query($sql, $this->connect)){
			$adjunct = $this->Adjunct();
            $overseer = $this->Overseer();
            $hunter = new Person($this->GetID());
            
            $text = $hunter->GetName().", your sheet has been killed by the RP staff.";
            
            if ($reason){
	            $text .= "\r\n\r\nReason: ".$reason;
            }

            $from = "Office of Character Assassinations<overseer@thebhg.org>";
            $subject = "Notice of Character Wipe";

            $adjunct->SendEmail($from, $subject, $text);
            $overseer->SendEmail($from, $subject, $text);
            $hunter->SendEmail($from, $subject, $text);
			return 'Character Killed.';
		} else {
			$arena = new Arena();
			return $arena->NEC(165);
		}	   
	}
	
	function NewSheet(){
	    $sql = "INSERT INTO `character_sheets` VALUES ('".$this->GetID()."', '".time()."', 1, 0, 0)";
		if (mysql_query($sql, $this->connect)){
			return true;
		} else {
			return false;
		}
	}
    
	function HasValue($look = 'values', $col = 'bhg_id', $id = 0){
		if ($id){
			$id = $id;
		} else {
			$id = $this->GetID();
		}
		$table = '`character_sheet_'.$look.'`';
	    $sql = "SELECT * FROM $table WHERE `$col` = '".$id."'";
        $query = mysql_query($sql, $this->connect);
        
        return (mysql_num_rows($query));
    }
	
	function ParseSheet($look = 'values', $id = 0, $col = 'bhg_id'){
		$this->UpdateCache();
		$bio = $this->cs_person->GetBioData();
		$division = $this->cs_person->GetDivision();
		$position = $this->cs_person->GetPosition();
		$rank = $this->cs_person->GetRank();
    	$url = $bio->GetImageURL();
		$unk = 'Unknown';
		$age = $unk;
		$height = $unk;
		$homeworld = $unk;
		$sex = $unk;
		$species = $unk;
		if (!$url){ $url = 'arena/images/helmet.png'; } 
		if ($bio->GetAge()){ $age = $bio->GetAge(); }
		if ($bio->GetHeight()){ $height = $bio->GetHeight(); }		
		if ($bio->GetHomeworld()){ $homeworld = $bio->GetHomeworld(); }
		if ($bio->GetSex()){ $sex = $bio->GetSex(); }
		if ($bio->GetSpecies()){ $species = $bio->GetSpecies(); }
		
		echo '<table border=0 width="100%"><tr valign="top"><td>';
		
		$table = new Table();
				$table->StartRow();
		$table->AddHeader('Personal History', 2);
		$table->EndRow();
		$table->AddRow('Bonus Points ', $this->GetBonusPoints());
		$points = $this->GetExperiencePoints();
		if (!$points){ $points = '0'; }
		$table->AddRow('Experience Points ', $points);
		$table->AddRow('Dossier Status', 'Currently listed as: <b>'.$this->Status('HUMAN').'</b>');
		$table->EndTable();
		
		echo '</td><td align="center">';
		
		$table = new Table();
    	
    	$table->StartRow();
    	$table->AddHeader('Key', 2);
    	$table->EndRow();
    	
    	$table->AddRow('Hunter Placed Point', '<img src="arena/images/X.png">');
    	$table->AddRow('System Generated Point', '<img src="arena/images/bonus.png">');
    	
    	$table->EndTable();
		
    	echo '</td></tr></table>';
    	
		hr();
		
		$table = new Table();
		
		$table->StartRow();
		$table->AddHeader('Dossier file for '.$rank->GetName().' '.$this->GetName($look, $id, $col), 2);
		$table->EndRow();
		$table->AddRow('Visual Identification', '<img src='.$url.'>');
    	$table->AddRow('Age', $age);
    	$table->AddRow('Height', $height);
    	$table->AddRow('Homeworld', $homeworld);
    	$table->AddRow('Sex', $sex);
    	$table->AddRow('Species', $species);
    	$table->AddRow('Division', '<a href="'.internal_link('division', array('id'=>$division->GetID()), 'roster').'">'.$division->GetName().'</a>');
    	$table->AddRow('Position', '<a href="'.internal_link('position', array('id'=>$position->GetID()), 'roster').'">'.$position->GetName().'</a>');
    	if ($this->HasValue($look, $col, $id)){
	    	for ($i = 1; $i <= 6; $i++){
		    	$field = new Field($i);
		    	$table->StartRow();
				$table->AddHeader($field->GetName(), 2);
				$table->EndRow();
		    	foreach($this->GetStats($i) as $stat){
			    	$table->AddRow($stat->GetName(), $this->Point($stat->GetID(), 'SHEET', $look, $id, $col));
		    	}
	    	}
	    	for ($i = 7; $i <= 9; $i++){
		    	$field = new Field($i);
		    	$table->StartRow();
				$table->AddHeader($field->GetName(), 2);
				$table->EndRow();
		    	foreach($this->GetSkills($i) as $skill){
			    	$table->AddRow($skill->GetName(), $this->GetValue($skill->GetID(), $look, 'SHEET', $id, $col));
		    	}
	    	}
			for ($i = 10; $i <= 11; $i++){
		    	$field = new Field($i);
		    	$table->StartRow();
				$table->AddHeader($field->GetName(), 2);
				$table->EndRow();
		    	foreach($this->GetStats($i) as $stat){
			    	$table->AddRow($stat->GetName(), $this->Point($stat->GetID(), 'SHEET', $look, $id, $col));
		    	}
	    	}
    	} else {
	    	$table->StartRow();
	    	$table->AddCell('This sheet has not yet been created', 2);
	    	$table->EndRow();
    	}    	
    	
    	$table->EndTable();

	}
    	
 }					

?>