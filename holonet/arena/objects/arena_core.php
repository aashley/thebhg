<?php

 Class Arena extends Roster {
	 
	var $holonet;
	var $lyarna;
	var $bastion;

    function Arena(){
	    $connects = array('holonet'=>array('name'=>'holonet', 'pass'=>'w0rdy'), 'lyarna'=>array('name'=>'lyarna', 'pass'=>'lyarnasys55'), 
	    			'bastion'=>array('name'=>'overseer', 'pass'=>'01c81257'));
	    
	    foreach ($connects as $name=>$data){
		    $this->$name = $this->Connect($data);
	    }

    }
    
    function Connect($info){
	    $connect = mysql_connect("localhost", "thebhg_".$info['name'], $info['pass']);
        mysql_select_db("thebhg_".$info['name'], $connect);
        
        return $connect;
    }
    
    function StorePendingXP($bhg_id, $reason, $xp, $by){
	    $sql = "INSERT INTO `ams_pending_xp` VALUES ('$bhg_id', '".addslashes($reason)."', '$xp', '$by')";
	    mysql_query($sql, $this->holonet);
    }		    
    
    function Ladder($activity, $bhg_id = 0){
	    $sql = "SELECT `ams_records.bhg_id` as `bhg_id`, `ams_records.xp` as `xp`, `ams_records.outcome` as `outcome`, `ams_records.creds` as `creds`, `ams_records.medal` as `medal`"
	    	." FROM `ams_records`, `ams_match` WHERE `ams_records.match` = `ams_match.id` AND `ams_match.type` = '$activity' AND `ams_match.date_deleted` = 0 AND"
	    	." `ams_records.date_deleted` = 0 AND `ams_records.outcome` > 0";
	    	
	    $query = mysql_query($sql, $this->holonet);
	    $return = array();
	    
	    while ($info = mysql_fetch_assoc($query)){
		    $outcome = new Obj('ams_specifics', $info['outcome'], 'holonet');
		    $return[$info['bhg_id']]['points'] += $outcome->Get(points);
		    $return[$info['bhg_id']]['xp'] += $info['xp'];
		    $return[$info['bhg_id']]['creds'] += $info['creds'];
		    $return[$info['bhg_id']]['medals'] += ($info['medal'] ? 1 : 0);
	    }
	    
	    print_r($return);
    }
	    
    
    function GetPayData($start, $end){
	    $table = "`arena_$table`";
	    $sql = "SELECT * FROM `ams_aides` WHERE (`end_date` = 0 OR (`end_date` <= '$end' AND `end_date` >= '$start')) AND `start_date` <= '$end'";
	    $query = mysql_query($sql, $this->holonet);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $sql = "SELECT * FROM `ams_aide_types` WHERE `id` = '".$info['aide']."' and `date_deleted` = 0";
		    $data = mysql_fetch_assoc(mysql_query($sql, $this->holonet));
		    
		    $person = new Person($info['bhg_id']);
		    $posi = $person->GetPosition();
		    if ($posi->GetID() != 9 && $posi->GetID() != 29){
				$return[] = array('end_date'=>$info['end_date'], 'start_date'=>$info['start_date'], 'bhg_id'=>$info['bhg_id'], 'month_pay'=>$data['salary']);
			}
	    }
	    
	    return $return;
    }
    
    function GetPendingXP(){
	    $sql = "SELECT * FROM `ams_pending_xp`";
	    $query = mysql_query($sql, $this->holonet);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $by = new Person($info['by']);
		    $kabal = $by->GetDivision();
		    $return[$kabal->GetName()][] = array('bhg_id'=>new Person($info['bhg_id']), 'by'=>$by, 'xp'=>$info['xp'], 'reason'=>stripslashes($info['reason']));
	    }
	    
	    ksort($return);
	    
	    return $return;
    }
    
    function RemovePendingXP(){
	    $sql = "DELETE FROM `ams_pending_xp`";
	    mysql_query($sql, $this->holonet);
    }
    
    function MyProperties($hunter){
	    $bhg_id = $hunter->GetID();
	    $divi = $hunter->GetDivision();
	    $posi = $hunter->GetPosition();
	    $division = $divi->GetID();
	    $position = $posi->GetID();
	    
	    $tables = array('complex', 'estate', 'hq', 'other', 'personal');
	    $return = array();
	    foreach ($tables as $table){
		    $sql = "SELECT * FROM `$table` WHERE (`division` = '$division' AND `position` = '$position') OR (`bhg_id` = '$bhg_id')";
		    $query = mysql_query($sql, $this->lyarna);
		    
		    while ($info = mysql_fetch_array($query)){
			    $return[] = array('name'=>$info['name'], 'posi'=>($info['position'] ? 1 : 0));
		    }
	    }
	    
	    return $return;
    }
    
    function NewRow($data){
	    if ($data['resource']){
	    	$res = $data['resource'];
    	} else {
	    	$res = 'holonet';
    	}
	    
	    $sql = "INSERT INTO `".$data['table']."` (`".implode('`, `', $data['fields'])."`) VALUES ('".implode("', '", $data['values'])."')";
	    $query = mysql_query($sql, $this->$res);

	    echo (mysql_error($this->$res) ? mysql_error($this->$res).'<br />' : '');
	    
	    return ($query ? mysql_insert_id($this->$res) : false);
    }
    
    function Search($data, $obj = true, $count = false){
	    $implode = array();
	    $return = array();
	    $order = array();
	    $select = array();
	    
	    if (is_array($data['search'])){
		    foreach ($data['search'] as $field=>$value){
			    $implode[] = "`".$field."` = '".$value."'";
		    }
	    }
	    
	    if (is_array($data['order'])){
		    foreach ($data['order'] as $field=>$updwn){
			    $order[] = "`".$field."` ".$updwn;
		    }
	    }
	    
	    if (is_array($data['select']) && !$obj){
	    	foreach ($data['select'] as $field=>$value){
		    	$name = '';
		    	if ($value){
			    	$name = $value;
		    	}
			    $select[] = "`".$field."` ".($name ? "as ".$name : '');
		    }
	    	$sel = implode(', ', $select);
    	} else {
	    	$sel = '*';
    	}
    	
    	if ($data['resource']){
	    	$res = $data['resource'];
    	} else {
	    	$res = 'holonet';
    	}
    	
	    $sql = "SELECT $sel FROM `".$data['table']."`".(count($implode) ? " WHERE ".implode(' AND ', $implode) : '').($data['group'] ? 'GROUP BY `'.$data['group'].'`' : '').(count($order) ? ' ORDER BY '.implode(', ', $order) : '').($data['limit'] ? ' LIMIT '.$data['limit'] : '');
		$query = mysql_query($sql, $this->$res);
		
		echo (mysql_error($this->$res) ? mysql_error($this->$res).'<br />' : '');
		
		if ($count){
			return mysql_num_rows($query);
		} else {
			while ($info = mysql_fetch_assoc($query)){
				if ($obj){
					$new = new Obj($data['table'], $info['id'], $res);
				} else {
					$new = $info;
				}
				$return[] = $new;
			}
			return $return;
		}
	}
	
	function NPCID(){
		$sql = "SELECT * FROM `ams_npc_id` WHERE `date_deleted` = 0";
		$query = mysql_query($sql, $this->holonet);
		
		$result = mysql_fetch_assoc($query);
		return $result['field'];
	}
	
	function Sheetie($bhg_id){
		$sql = "SELECT * FROM `ams_cs` WHERE `date_deleted` = 0";
		$query = mysql_query($sql, $this->holonet);
		
		while ($result = mysql_fetch_assoc($query)){
			$search = $this->Search(array('table'=>'ams_aides', 'search'=>array('end_date'=>'0', 'aide'=>$result['aide'])));
			foreach ($search as $obj){
				if ($obj->Get(bhg_id) == $bhg_id){
					return true;
				}
			}
		}
		
		return false;
	}
	
	function Locations(){
        $return = array();
        $locations = array('complex', 'estate', 'hq', 'personal', 'other');
        
        foreach ($locations as $location){ 
        
        	$sql = "SELECT * FROM `$location` WHERE `arena` = 1";

        	$query = mysql_query($sql, $this->lyarna);

	        while ($info = mysql_fetch_array($query)){
		        $planet = mysql_fetch_array(mysql_query("SELECT * FROM `planets` WHERE `id` = '".$info['planet']."'", $this->lyarna));
		        $new = serialize(array($info['planet']=>$info['id']));
				
		        $exp = explode(',', $planet['name']);
		        
	            $return[$new] = $exp[0] . ' - ' . $info['name'];
            }
        }
        
        asort($return);

        return $return;

    }
    
    function NewCreature($stats, $string){
	    $sql = "INSERT INTO `ams_creatures` (`stats`, `string`) VALUES ('".serialize($stats)."', '".addslashes($string)."')";
	    
	    if (mysql_query($sql, $this->holonet)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function Creatures(){
        $sql = "SELECT * FROM `ams_creatures` WHERE `date_deleted` = 0";
        $query = mysql_query($sql, $this->holonet);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Creature($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
			
 }

?>