<?php

 Class RODetails extends Ladder {

    function RODetails(){
        Arena::Arena();
    }

    function ROs(){
        $sql = "SELECT * FROM `arena_ro` WHERE `date_deleted` = 0 ORDER BY `start` DESC";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new RunOn($info['id']);
            array_push($return, $new);
        }

        return $return;

    }


    function Build() {
       $sql = "SELECT arena_ro_hunters.bhg_id as bhg_id, arena_ro_hunters.creds as creds, arena_ro_hunters.first as first FROM arena_ro, arena_ro_hunters WHERE `graded` = 1 AND "
                    ."arena_ro.id = arena_ro_hunters.run_on AND arena_ro.date_deleted = 0";

        $query = mysql_query($sql, $this->connect);
        $return = array();
        $var = array();
        $total = "SELECT * FROM `arena_ro` WHERE `graded` = 1 AND `date_deleted` = 0";
        $qtotal = mysql_query($total, $this->connect);
        $total = mysql_num_rows($total);

        while ($result = mysql_fetch_array($query)){
            $var[$result['bhg_id']][] = $result['creds']+($result['first']*5);
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