<?php

 Class Details extends Ladder {

    function Details(){
        Arena::Arena();
    }

    function Matches(){
        $sql = "SELECT * FROM `arena_ladder_match` WHERE `date_deleted` = 0 AND `match_id` > 0 ORDER BY `start` DESC";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Match($info['id']);
            array_push($return, $new);
        }

        return $return;

    }

    function Build() {
        $sql = "SELECT arena_ladder_records.bhg_id, arena_ladder_records.outcome FROM arena_ladder_records, arena_ladder_match WHERE arena_ladder_match.accepted = 1 "
                ."AND arena_ladder_match.id = arena_ladder_records.match_id AND arena_ladder_match.match_id > 0 AND arena_ladder_match.date_deleted = 0 "
                ."ORDER BY arena_ladder_records.bhg_id";

        $query = mysql_query($sql, $this->connect);
        $return = array();
        $var = array();
        $total = "SELECT * FROM `arena_ladder_match` WHERE `match_id` > 0 AND `date_deleted` = 0";
        $qtotal = mysql_query($total, $this->connect);
        $total = mysql_num_rows($total);

        while ($result = mysql_fetch_array($query)){
            $var[$result['bhg_id']][] = $result['outcome'];
        }

        $count = count($var);
        $i = 0;
        $keys = array_keys($var);

        while ($i < $count){
            $key = $keys[$i];
            $result = $var[$key];
            $new = array_sum($result);
            $put = array($key => $new/$total);
            $return = $return + $put;
            $i++;
        }

        arsort($return, SORT_NUMERIC);
        reset($return);

        return $return;
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