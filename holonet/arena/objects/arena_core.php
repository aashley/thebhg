<?php

 Class Arena extends Roster {
	 
	var $connect;
	var $lyarna;
	var $bastion;
	var $roster;
	var $mb;

    function Arena(){
	    $connects = array('connect'=>array('name'=>'holonet', 'pass'=>'w0rdy'), 'lyarna'=>array('name'=>'lyarna', 'pass'=>'lyarnasys55'), 
	    			'bastion'=>array('name'=>'overseer', 'pass'=>'01c81257'));
	    
	    foreach ($connects as $name=>$data){
		    $this->$name = $this->Connect($data);
	    }
	    
	    $this->roster = new Roster('fight-51-me');
		$this->mb = new MedalBoard('fight-51-me');
    }
    
    function Connect($info){
	    $connect = mysql_connect("localhost", "thebhg_".$info['name'], $info['pass']);
        mysql_select_db("thebhg_".$info['name'], $lyarna);
        
        return $connect;
    }
    
    function NewRow($data){
	    $sql = "INSERT INTO `".$data['table']."` (`".implode('`, `', $data['fields'])."`) VALUES ('".implode('', '', $data['values'])."')";
	    $query = mysql_query($sql, $this->$data['resource']);
	    
	    return ($query ? true : false);
    }
    
    function Search($data, $obj = true){
	    $implode = array();
	    $return = array();
	    $order = array();
	    $select = array();
	    
	    foreach ($data['search'] as $field=>$value){
		    $implode[] = "`".$field."` = '".$value."'";
	    }
	    
	    foreach ($data['order'] as $field=>$updwn){
		    $order[] = "`".$field."` ".$updwn;
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
    	
	    $sql = "SELECT $sel FROM `".$data['table']."` WHERE ".implode(' AND ', $implode).($data['group'] ? 'GROUP BY `'.$data['group'].'`' : '').(count($order) ? ' ORDER BY '.implode(', ', $order) : '');
		$query = mysql_query($sql, $this->$data['resource']);
		
		while ($info = mysql_fetch_assoc($query)){
			if ($obj){
				$new = new Obj($table, $info['id']);
			} else {
				$new = $info;
			}
			
			$return[] = $new;
		}
		
		return $return;
	}
	
	function Overseer(){
        $search = $this->roster->SearchPosition('29');
        return (is_object($search[0]) ? $search[0] : false);
    }

    function Adjunct(){
         $search = $this->roster->SearchPosition('9');
        return (is_object($search[0]) ? $search[0] : false);
    }
			
 }

?>