<?php

 Class IRCADetails extends IRCA {

    function IRCADetails(){
        Arena::Arena();
    }

    function Matches(){
        $sql = "SELECT * FROM `arena_irca_match` WHERE `date_deleted` = 0 AND `match` != '' ORDER BY `date` DESC";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new IRCAMatch($info['id']);
            array_push($return, $new);
        }

        return $return;

    }

    function Build() {
        $sql = "SELECT arena_irca_records.bhg_id, arena_irca_records.outcome FROM arena_irca_records, arena_irca_match WHERE arena_irca_match.id = "
        	   ."arena_irca_records.match_id AND arena_irca_match.date_deleted = 0 AND arena_irca_match.match != '' ORDER BY arena_irca_records.bhg_id";

        $query = mysql_query($sql, $this->connect);
        $return = array();
        $var = array();

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
            $put = array($key => $new);
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