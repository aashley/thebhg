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
        $sql = "SELECT arena_irca_records.bhg_id, SUM(arena_irca_records.outcome) as points FROM arena_irca_records, arena_irca_match WHERE arena_irca_match.id = "
        	   ."arena_irca_records.match_id AND arena_irca_match.date_deleted = 0 AND arena_irca_match.match != '' GROUP BY `arena_irca_records.bhg_id` ORDER BY arena_irca_records.bhg_id";

        $query = mysql_query($sql, $this->connect);
        $total = "SELECT * FROM `arena_irca_match` WHERE `match_id` > 0 AND `date_deleted` = 0";
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