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
    
    function NewRow($data){
	    if ($data['resource']){
	    	$res = $data['resource'];
    	} else {
	    	$res = 'holonet';
    	}
	    
	    $sql = "INSERT INTO `".$data['table']."` (`".implode('`, `', $data['fields'])."`) VALUES ('".implode("', '", $data['values'])."')";
	    $query = mysql_query($sql, $this->$res);
	    
	    return ($query ? true : false);
    }
    
    function Search($data, $obj = true){
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
    	
	    $sql = "SELECT $sel FROM `".$data['table']."`".(count($implode) ? " WHERE ".implode(' AND ', $implode) : '').($data['group'] ? 'GROUP BY `'.$data['group'].'`' : '').(count($order) ? ' ORDER BY '.implode(', ', $order) : '');
		$query = mysql_query($sql, $this->$res);
		
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

?>