<?php

 Class Details extends Ladder {

    function Details(){
        Arena::Arena();
    }

    function Matches($add = ''){
        $sql = "SELECT * FROM `arena_ladder_match` WHERE `date_deleted` = 0 AND `match_id` > 0 $add ORDER BY `start` DESC";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Match($info['id']);
            array_push($return, $new);
        }

        return $return;

    }

    function Build() {
        $sql = "SELECT arena_ladder_records.bhg_id, SUM(arena_ladder_records.outcome) as points FROM arena_ladder_records, arena_ladder_match WHERE arena_ladder_match.accepted = 1 "
                ."AND arena_ladder_match.id = arena_ladder_records.match_id AND arena_ladder_match.match_id > 0 AND arena_ladder_match.date_deleted = 0 "
                ." GROUP BY arena_ladder_records.bhg_id ORDER BY arena_ladder_records.bhg_id";

        $query = mysql_query($sql, $this->connect);
        $total = "SELECT * FROM `arena_ladder_match` WHERE `match_id` > 0 AND `date_deleted` = 0";
        $qtotal = mysql_query($total, $this->connect);
        $total = mysql_num_rows($qtotal);
        $var = array();

        if (!$total){ $total = 1; }
        
        while ($result = mysql_fetch_array($query)){
            $var[$result['bhg_id']] = $result['points']/$total;
        }

        arsort($var, SORT_NUMERIC);
        reset($var);

        return $var;
    }
    
    function Search($bhg_id) {
        $base = $this->Build();
        $place = 0;
        $return = array();
        
        foreach ($base as $value=>$points){
	        $place++;
	        $return[$value] = $place;
        }
        
        if (array_key_exists($bhg_id, $return)){
        	return $return[$bhg_id];
    	} else {
	    	return false;
    	}
    }

 }

?>