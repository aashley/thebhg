<?php

Class Arena extends Roster {

    function Arena(){   
		$this->connect = mysql_connect('localhost', 'holonet', 'w0rdy');
			mysql_select_db('holonet', $this->connect);
    }
    
    function GetXP($id) {       
		$sql = "SELECT SUM(`points`) as points FROM `cs_experience` WHERE `bhg_id` = '".addslashes($id)."'";
		$query = mysql_query($sql, $this->connect);
		$return = mysql_fetch_array($query);
		
		return $return['points'];
    }
    
    function Build($division) {
	    $qualifier = 'outcome';
	    
	    switch ($division){
		    case 'arena':
		    	$sql = "SELECT arena_ladder_records.bhg_id, arena_ladder_records.outcome FROM arena_ladder_records, arena_ladder_match WHERE arena_ladder_match.accepted = 1 "
	                ."AND arena_ladder_match.id = arena_ladder_records.match_id AND arena_ladder_match.match_id > 0 AND arena_ladder_match.date_deleted = 0 "
	                ."ORDER BY arena_ladder_records.bhg_id";
		    break;
		    case 'irca':
        		$sql = "SELECT arena_irca_records.bhg_id, arena_irca_records.outcome FROM arena_irca_records, arena_irca_match WHERE arena_irca_match.id = "
        	   			."arena_irca_records.match_id AND arena_irca_match.date_deleted = 0 AND arena_irca_match.match != '' ORDER BY arena_irca_records.bhg_id";
        	break;
        	case 'sa':
        		$sql = "SELECT arena_starfield_records.bhg_id, arena_starfield_records.outcome FROM arena_starfield_records, arena_starfield_match WHERE arena_starfield_match.accepted = 1 "
	                ."AND arena_starfield_match.id = arena_starfield_records.match_id AND arena_starfield_match.match_id > 0 AND arena_starfield_match.date_deleted = 0 AND "
	                ."arena_starfield_match.match_id > 0 ORDER BY arena_starfield_records.bhg_id";
        	break;
        	case 'solo':
        		$sql = "SELECT * FROM `arena_solo_contracts` WHERE `bhg_id` > 0 ORDER BY `bhg_id` ASC";
        	break;
        	case 'lw':
        		$sql = "SELECT * FROM `arena_lw_contracts` WHERE `bhg_id` > 0 ORDER BY `bhg_id` ASC";
        	break;
    	}

        $query = mysql_query($sql, $this->connect);
        $return = array();
        $var = array();

        while ($result = mysql_fetch_array($query)){
            $var[$result['bhg_id']][] = $result[$qualifier];
        }

        $count = count($var);
        $i = 0;
        $keys = array_keys($var);

        while ($i < $count){
            $key = $keys[$i];
            $result = $var[$key];
            $new = array_sum($result);
            $put = array($key => $new);
            $return = $return + $put;
            $i++;
        }

        arsort($return, SORT_NUMERIC);
        reset($return);

        return $return;
    }

    function Ladder($division, $bhg_id) {
        $base = $this->Build($division);
        $place = 0;
        $return = array();
        
        foreach ($base as $value=>$points){
	        $place++;
	        $return[$value] = $place;
        }
        
        if (array_key_exists($bhg_id, $return)){
        	return $return[$bhg_id];
    	} else {
	    	return 'N/A (Hunter not ranked)';
    	}
    }
}
    
?>
