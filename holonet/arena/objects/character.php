<?

 Class Character extends Sheet {

    var $cs_bhg_id;
    var $cs_id;
    var $cs_last_change;
    var $cs_approved;
    var $cs_person;
    var $cs_pending;
    var $cs_ban;
    var $cs_date_deleted;
    var $LastID;
    var $project;

    function Character($id) {
        Sheet::Sheet();
        
        $sql = "SELECT * FROM `character_sheets` WHERE `bhg_id` = '$id' AND `date_deleted` = 0";
        $query = mysql_query($sql, $this->holonet);

        $this->cs_person = new Person($id);
        
        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'cs_'.$key;
                $this->$key = stripslashes($value);
            }

        }
        
        $this->project = $this->GetSheetMod('base');

    }
    
    function UpdateCache(){
	    $sql = "SELECT * FROM `character_sheets` WHERE `bhg_id` = '".$this->cs_bhg_id."' AND `date_deleted` = 0";
        $query = mysql_query($sql, $this->holonet);
        
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
    
    function GetSheetID(){
	    return $this->cs_id;
    }
    
    function GetName($look = 'values', $id = 0, $col = 'id'){
	    
	    $stat = $this->Point(33, 'SHEET', $look, $id, $col);
	    
	    if (empty($stat)){
		    $name = $this->cs_person->GetName();
	    } else {
		    $name = $stat;
	    }
	    
	    return $name;
    }
    
    function GetDeleted(){
	    return ($this->cs_date_deleted > 0);
    }
    
    function DateDeleted(){
	    if ($this->GetDeleted()){
		    $date = getdate($this->cs_date_deleted);
		    return $date['month'] . ' ' . $date['mday'] . ', ' . $date['year'];
    	} else {
	    	return 'Not Deleted';
    	}
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
					    $return = 5;
				    } else {
				    	$return = 3;
			    	}
			    }
		    }
		    if (!$this->HasValue()){
			    if ($this->HasValue('pending')){
				    if ($this->cs_approved){
				    	$return = 4;
			    	} elseif ($this->cs_pending){
			    		$return = 6;
		    		} else {
			    		$return = 3;
		    		}
		    	} else {
			    	$return = -1;
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
	    $sql = "UPDATE `character_sheets` SET `ban` = '$date' WHERE `id` = '".$this->GetSheetID()."'";
	    $query = mysql_query($sql, $this->holonet);
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
    
    function EditBan($type = 'SYSTEM'){
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
    
    function GetSheetValues($value = 'values', $id = 0, $col = 'id'){
	    if ($id){
		    $id = $id;
	    } else {
		    $id = $this->GetSheetID();
	    }
	    $table = '`character_sheet_'.$value.'`';
	    $sql = "SELECT * FROM $table WHERE `$col` = '".$id."'";
	    $query = mysql_query($sql, $this->holonet);
	    $return = array();

	    while ($info = mysql_fetch_array($query)){
		    $return[$info['statribute']] = $info['value'];
	    }
	    
	    return $return;
    }
    
    function Point($stat, $output = 'SHEET', $look = 'values', $id = 0, $col = 'id'){
	    if ($id){
		    $id = $id;
	    } else {
		    $id = $this->GetSheetID();
	    }
	    $table = '`character_sheet_'.$look.'`';
	    $sql = "SELECT * FROM $table WHERE `$col` = '".$id."' AND `statribute` = '$stat'";
        $query = mysql_query($sql, $this->holonet);
        $info = mysql_fetch_array($query);
        $stat = new Statribute($stat);
        
        $build = $this->CaBuild();
        
        $val = $info['value'];
        if ($stat->IsInt()){
	        foreach ($build as $ref){
	        	foreach ($ref as $call=>$ar){
		        	if ($call == 'stat'){
			        	$val += $ar[$info['statribute']];
		        	}
	        	}
	    	}
	    	if ($val > 10){ $val = 10; }
	    	if ($val < 0) { $val = 0; }
    	}
        
        if ($output == 'SHEET'){
	        if ($stat->IsInt()){
		        $return = str_repeat('<img src="arena/images/X.png" alt="X" height=20 width=20>', $val);
		        $return .= str_repeat('<img src="arena/images/0.png" alt="0" height=20 width=20>', 10-$val);
	        	return $return;
	    	} else {
		    	return nl2br(stripslashes($info['value']));
	    	}
    	} elseif ($output == 'SYSTEM'){
	    	return $val;
    	}
    }
    
    function AwardCA($id){
	    $this->DeleteCA($id);
	    $sql = "INSERT INTO `character_sheet_ca` (`bhg_id`, `ca`) VALUES ('".$this->GetID()."', '$id')";
	    $query = mysql_query($sql, $this->holonet);
	    
	    $text = "You have been awarded a character attribute. This attribute modifies your stats, so you may want to go re-arrange things.";

        $from = "overseer@thebhg.org";
        $subject = "Character Attribute Awarded";

        $this->cs_person->SendEmail($from, $subject, $text);
	    
	    return ($query ? true : false);
    }
    
    function DeleteCA($id){
	    $sql = "UPDATE `character_sheet_ca` SET `date_deleted` = '".time()."' WHERE `bhg_id` = '".$this->GetID()."' AND `ca` = '$id'";
	    $query = mysql_query($sql, $this->holonet);
	    
	    $text = "The Registrar has removed a character attribute from your character.";

        $from = "overseer@thebhg.org";
        $subject = "Character Attribute Removed";
        
        $this->cs_person->SendEmail($from, $subject, $text);
	    
	    return ($query ? true : false);
    }
    
    function CABuild(){
	    $sql = "SELECT * FROM `character_sheet_ca` WHERE `bhg_id` = '".$this->GetID()."' AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->holonet);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $ca = $this->GetCa($info['ca']);
		    if (!$ca['date_deleted']){
		    	$return[] = $this->CharacterAttributes($info['ca']);
	    	}
	    }
	    
	    return $return;
    }
    
    function CAWrite(){
	    $sql = "SELECT * FROM `character_sheet_ca` WHERE `bhg_id` = '".$this->GetID()."' AND `date_deleted` = 0";
	    $query = mysql_query($sql, $this->holonet);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $ca = $this->GetCa($info['ca']);
		    if (!$ca['date_deleted']){
		    	$return[] = $info['ca'];
	    	}
	    }
	    
	    if (count($return)){
		    echo '<p>';
		    $table = new Table('', true);
		    $table->StartRow();
		    $table->AddHeader('Character Attributes', 2);
		    $table->EndRow();
		    
		    foreach ($return as $id){
			    $ca = $this->GetCA($id);
			    $stats = $this->GetCAValues($id);
			    $stat = '';			    
			    if (count($stats)){
				    $stat .= '<hr noshade height=1 width=50%>Stat Modifiers';
			    	foreach ($stats as $info){
				    	$c = ($info['mod'] > 0);
				    	$stat .= '<br />'.$info['fo']->GetName().' '.($c ? '+' : '').$info['mod'];
			    	}
		    	}
			    $table->AddRow('<div valign=top>'.$ca['name'].$stat.'</div>', $ca['description']);
		    }
		    
		    $table->EndRow();
		    $table->EndTable();
	    }
    }
    
    function GetValue($skill, $look = 'values', $render = 'SHEET', $id = 0, $col = 'id'){
	    $sql = "SELECT * FROM `cs_skill_equ` WHERE `skill` = '$skill'";
        $query = mysql_query($sql, $this->holonet);
        
        $build = $this->CaBuild();

	    $output = 0;
	    $denominator = 0;
        
        while($info = mysql_fetch_array($query)){
	        if ($this->Permit(1, $info['statribute'], $this->project)){
	        	$output += $this->Point($info['statribute'], 'SYSTEM', $look, $id, $col)*$info['modifier'];
	        	$denominator += $info['modifier'];
        	}
        }
        
        if ($denominator){
        	$value = round($output/$denominator);
    	} else {
	    	return 0;
    	}
    	
    	foreach ($build as $ref){
        	foreach ($ref as $call=>$ar){
	        	if ($call == 'skill'){
		        	$value += $ar[$skill];
	        	}
        	}
    	}
    	
    	if ($value > 10){ $value = 10; }
    	if ($value < 0) { $value = 0; }
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
	    $rewards[39] = 3;
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
		$query = mysql_query($sql, $this->holonet);
		
		$demsql = "SELECT * FROM `cs_demerit_points` WHERE `bhg_id` = '".$this->GetID()."'";
		$demquery = mysql_query($demsql, $this->holonet);
		
		return mysql_num_rows($query)-mysql_num_rows($demquery);
	}
	
	function GetExperiencePoints(){
	    $sql = "SELECT SUM(`points`) as points FROM `cs_experience` WHERE `bhg_id` = '".$this->GetID()."'";
		$query = mysql_query($sql, $this->holonet);
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
	    
	    $new = "INSERT INTO `character_sheet_record` VALUES ('', '".$this->GetID()."', '".time()."')";
	    $store = mysql_query($new, $this->holonet);
	    $id = mysql_insert_id($this->holonet);
	    $this->LastID = $id;
	    
	    $errors = array();
	    
	    //No errors, write the document to Pending Sheets
	    
	    for ($i = 1; $i <= 3; $i++){
		    foreach($compile[$i] as $key=>$value){
			    if (is_numeric($value)){
					$value = floor($value);
				} else {
					$value = addslashes($value);
				}
			    
				$sql = "DELETE FROM `character_sheet_pending` WHERE `id` = '".$this->GetSheetID()."' AND `statribute` = '$key'";
			    mysql_query($sql, $this->holonet);
				
			    $sql = "INSERT INTO `character_sheet_pending` VALUES ('".$this->GetSheetID()."', '$key', '$value')";
			    if (!mysql_query($sql, $this->holonet)){
				    $errors[] = 'Error Generated During Publish: '.mysql_error($this->holonet);
			    } else {				    
				    $sql = "INSERT INTO `character_sheet_records` VALUES ('".$this->LastID."', '$key', '$value')";
				    mysql_query($sql, $this->holonet);
			    }
		    }
	    }
	    
	    if (count($errors)){
		    $sql = "DELETE FROM `character_sheet_pending` WHERE `id` = '".$this->GetSheetID()."'";
			mysql_query($sql, $this->holonet);
			$errors[] = '<b>Problem publishing sheet. Changes not published, report this error ASAP</b>';
		    return implode('<br />', $errors);
	    }
	    
	    //No errors, update status
	    
	    $sql = "UPDATE `character_sheets` SET `last_change` = '".time()."', `pending` = 0, `approved` = 0 WHERE `id` = '".$this->GetSheetID()."'";
		if (mysql_query($sql, $this->holonet)){
			return 'Your character sheet has been saved. The Save number is '.$this->LastID.' for your records. You may submit it at any time for approval. Your sheet can not be approved until you submit it.';
		} else {
			return 'Error in update: '.mysql_error($this->holonet);
		}	    
    }
	
    function SubmitSheet(){
	    $sql = "UPDATE `character_sheets` SET `last_change` = '".time()."', `pending` = 1, `approved` = 0 WHERE `id` = '".$this->GetSheetID()."'";
		if (mysql_query($sql, $this->holonet)){
			$sheet = new Sheet();
            
            $text = "A new sheet has been submitted by ".$this->cs_person->GetName().". Please go and review it at your earliest convenience.";

            $from = "overseer@thebhg.org";
            $subject = "Character Pending Approval";

			return 'Your character sheet has been submitted for approval. It is now pending review by the Overseer or Adjunct.';
		} else {
			return 'Error in update: '.mysql_error($this->holonet);
		}	   
	}
	
	function XPEvent($points, $reason){
		$sql = "INSERT INTO `cs_experience` VALUES ('".$this->GetID()."', '$points', '".time()."', '".addslashes($reason)."')";
		if (mysql_query($sql, $this->holonet)){
			return true;
		} else {
			return false;
		}
	}
	
	function WriteXPEvents(){
		$sql = "SELECT * FROM `cs_experience` WHERE `bhg_id` = '".$this->GetID()."' ORDER BY `date` DESC";
		$query = mysql_query($sql, $this->holonet);
		
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
		if (mysql_query($sql, $this->holonet)){
			return true;
		} else {
			return false;
		}
	}
	
	function RemovePoint($reason){
		$sql = "INSERT INTO `cs_demerit_points` VALUES ('".$this->GetID()."', '".time()."', '".addslashes($reason)."')";
		if (mysql_query($sql, $this->holonet)){
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
		$query = mysql_query($sql, $this->holonet);
		
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
		$query = mysql_query($sql, $this->holonet);
		
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
	
	function Approve(){
	    $sql = "SELECT * FROM `character_sheet_pending` WHERE `id` = '".$this->GetSheetID()."'";
	    $query = mysql_query($sql, $this->holonet);
	    
	    if (mysql_num_rows($query)){
		    $delsql = "DELETE FROM `character_sheet_values` WHERE `id` = '".$this->GetSheetID()."'";
		    mysql_query($delsql, $this->holonet);
		    $delsql2 = "DELETE FROM `character_sheet_pending` WHERE `id` = '".$this->GetSheetID()."'";
		    mysql_query($delsql2, $this->holonet);
	    }
	    
	    while($info = mysql_fetch_array($query)){
		    $sql = "INSERT INTO `character_sheet_values` VALUES ('".$this->GetSheetID()."', '".$info['statribute']."', '".$info['value']."')";
		    mysql_query($sql, $this->holonet);
	    }
	    
	    $sql = "UPDATE `character_sheets` SET `last_change` = '".time()."', `pending` = 0, `approved` = 1 WHERE `id` = '".$this->GetSheetID()."'";
		if (mysql_query($sql, $this->holonet)){
			$sheet = new Sheet();
            $hunter = new Person($this->GetID());
            
            $text = $hunter->GetName().", your sheet has been approved by the RP staff.";

            $from = "overseer@thebhg.org";
            $subject = "Character Approved";

            $hunter->SendEmail($from, $subject, $text);
			return 'Sheet approved.';
		} else {
			return 'Error in update: '.mysql_error($this->holonet);
		}	   
	}
	
	function Deny($reason = ''){
		$sql = "UPDATE `character_sheets` SET `last_change` = '".time()."', `pending` = 0, `approved` = 1 WHERE `id` = '".$this->GetSheetID()."'";		
		if (mysql_query($sql, $this->holonet)){
			$sheet = new Sheet();
            $hunter = new Person($this->GetID());
            
            $text = $hunter->GetName().", your sheet has been denied by the RP staff.";
            
            if ($reason){
	            $text .= " Reason: ".$reason;
            }

            $from = "overseer@thebhg.org";
            $subject = "Character Denied";

            $hunter->SendEmail($from, $subject, $text);
			return 'Character Denied.';
		} else {
			return 'Error in update: '.mysql_error($this->holonet);
		}	   
	}
	
	function Kill($reason = ''){
	    
	    $sql = "UPDATE `character_sheets` SET `date_deleted` = '".time()."' WHERE `id` = '".$this->GetSheetID()."'";

		if (mysql_query($sql, $this->holonet)){
			$sheet = new Sheet();
            $hunter = new Person($this->GetID());
            
            $text = $hunter->GetName().", your sheet has been killed by the RP staff.";
            
            if ($reason){
	            $text .= " Reason: ".$reason;
            }

            $from = "overseer@thebhg.org";
            $subject = "Notice of Character Wipe";

            $hunter->SendEmail($from, $subject, $text);
			return 'Character Killed.';
		} else {
			$arena = new Arena();
			return $arena->NEC(165);
		}	   
	}
	
	function NewSheet(){
	    $sql = "INSERT INTO `character_sheets` VALUES ('', '".$this->GetID()."', '".time()."', 1, 0, 0, '')";
		if (mysql_query($sql, $this->holonet)){
			$this->UpdateCache();
			return true;
		} else {
			return false;
		}
	}
    
	function HasValue($look = 'values', $col = 'id', $id = 0){
		if ($id){
			$id = $id;
		} else {
			$id = $this->GetSheetID();
		}
		$table = '`character_sheet_'.$look.'`';
	    $sql = "SELECT * FROM $table WHERE `$col` = '".$id."'";
        $query = mysql_query($sql, $this->holonet);
        
        return (mysql_num_rows($query));
    }
	
	function ParseSheet($look = 'values', $id = 0, $col = 'id', $show_anyway = false){
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
		if ($look == 'cores'){ $names = false; } else { $namez = true; }
		if (!$url){ $url = 'arena/images/helmet.png'; } 
		if ($bio->GetAge()){ $age = $bio->GetAge(); }
		if ($bio->GetHeight()){ $height = $bio->GetHeight(); }		
		if ($bio->GetHomeworld()){ $homeworld = $bio->GetHomeworld(); }
		if ($bio->GetSex()){ $sex = $bio->GetSex(); }
		if ($bio->GetSpecies()){ $species = $bio->GetSpecies(); }
		if ($id == 0){ $id = $this->GetSheetID(); }

		if ($look != 'cores' || $show_anyway){
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
		}
		
		$table = new Table();
    	
    	$table->StartRow();
    	$table->AddHeader('Key', 2);
    	$table->EndRow();
    	
    	$table->AddRow('Hunter Placed Point', '<img src="arena/images/X.png">');
    	$table->AddRow('System Generated Point', '<img src="arena/images/bonus.png">');
    	
    	$table->EndTable();
		
    	if ($look != 'cores' || $show_anyway){ 
	    	
	    	echo '</td></tr><tr><td colspan=2 align=center>';
	    	
	    	$this->CAWrite();
	    	
	    	echo '</td></tr></table>'; }
    	
		hr();
		
		$table = new Table();
		
		$table->StartRow();
		$table->AddHeader('Dossier file for '.$this->GetName($look, $id, $col), 2);
		$table->EndRow();
		if ($look != 'cores' || $show_anyway){
			$table->AddRow('Visual Identification', '<img src='.$url.'>');
	    	$table->AddRow('Age', $age);
	    	$table->AddRow('Height', $height);
	    	$table->AddRow('Homeworld', $homeworld);
	    	$table->AddRow('Sex', $sex);
	    	$table->AddRow('Species', $species);
    	}
    	$project = $this->project;
    	
    	if ($this->HasValue($look, $col, $id)){
	    	foreach ($this->ModFields($project) as $i){
	    		$field = new Field($i);
		    	$table->StartRow();
				$table->AddHeader($field->GetName(), 2);
				$table->EndRow();
		    	foreach($this->GetStats($i) as $stat){
			    	if ($this->Permit(1, $stat->GetID(), $project)){
			    		$table->AddRow($stat->GetName(), $this->Point($stat->GetID(), 'SHEET', $look, $id, $col));
		    		}
		    	}
		    	foreach($this->GetSkills($i) as $skill){
			    	if ($this->Permit(2, $skill->GetID(), $project)){
			    		$table->AddRow($skill->GetName(), $this->GetValue($skill->GetID(), $look, 'SHEET', $id, $col));
		    		}
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