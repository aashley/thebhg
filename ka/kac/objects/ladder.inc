<?php

 Class Ladder extends KA_1 {

	var $season;
	var $db_table;
	 
    function Ladder($id = 0){
        KA_1::KA_1();
        $this->db_table = 'kac_ladder';
        $this->CurrentSeason($id);
    }
    
	function Seasons(){
        $sql = "SELECT * FROM `kacs` ORDER BY `start`";
        $query = mysql_query($sql, $this->connect);
        $return = array();
        
        while ($info = mysql_fetch_array($query)){
	        $return[] = $info['id'];
        }

        return $return;
    }
    
    function CurrentSeason($old = '0'){

        if ($old){
            $this->season = $old;
        } else {
            $sql = "SELECT * FROM `kacs` ORDER BY `start` DESC LIMIT 1";
            $query = mysql_query($sql, $this->connect);
            $info = mysql_fetch_array($query);

            $this->season = $info['season_id'];
        }

        return $this->season;
    }
    
    function CanSubmit($kabal){
	    $sql = "SELECT * FROM `".$this->db_table."` WHERE `season` = '".$this->season."' AND `round` = '".$this->CurrentRound()."' AND `bracket` != '99' AND `kabal` = '$kabal'";
	    $query = mysql_query($sql, $this->connect);
	    
	    return (mysql_num_rows($query));
    }
    
    function CurrentRound(){
        $sql = "SELECT * FROM `".$this->db_table."` WHERE `season` = '".$this->season."' ORDER BY `round` DESC LIMIT 1";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);
        
        if ($info['round']){
	        return $info['round'];
        }
    }

    function GetKabals($round = 0){
	    if ($round){
		    $value = $round;
	    } else {
		    $value = $this->CurrentRound();
	    }
	    
        $sql = "SELECT * FROM `".$this->db_table."` WHERE `round` = '".$value."' AND `season` = '".$this->season."'";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
			$return[] = new Division($info['kabal']);
        }
        
        return $return;
    }

    function RoundBrackets($round = 0){
	    if ($round){
		    $value = $round;
	    } else {
		    $value = $this->CurrentRound();
	    }
	    
        $sql = "SELECT * FROM `".$this->db_table."` WHERE `bracket` < '99' AND `round` = '".$value."' AND `season` = '".$this->season
        		."' ORDER BY `bracket` DESC LIMIT 1";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        return $info['bracket'];
    }
    
    function RoundKabals($round = 0){
	    if ($round){
		    $value = $round;
	    } else {
		    $value = $this->CurrentRound();
	    }
	    
        $sql = "SELECT * FROM `".$this->db_table."` WHERE `bracket` < '99' AND `round` = '".$value."' AND `season` = '".$this->season."'";
        $query = mysql_query($sql, $this->connect);
        $kabals = array();
        
        while ($info = mysql_fetch_array($query)){
	        $kabals[] = new Division($info['kabal']);
        }

        return $kabals;
    }
    
    function CombatKabals($round = 0){
	    if ($round){
		    $value = $round;
	    } else {
		    $value = $this->CurrentRound();
	    }
	    
        $sql = "SELECT * FROM `".$this->db_table."` WHERE `bracket` < '99' AND `round` = '".$value."' AND `season` = '".$this->season."'";
        $query = mysql_query($sql, $this->connect);
        $kabals = array();
        
        while ($info = mysql_fetch_array($query)){
	        $kabals[$info['bracket']][] = $info['kabal'];
        }

        return $kabals;
    }

    function Champion($round){
        $sql = "SELECT * FROM `".$this->db_table."` WHERE `bracket` = '1' AND `round` = '$round' AND `season` = '".$this->season."'";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        if (mysql_num_rows($query) == 1){      
	        return $info['kabal'];
        } else {
        	return false;
    	}
    }
    
    function Started(){
        $sql = "SELECT * FROM `".$this->db_table."` WHERE `bracket` > '0' AND `season` = '".$this->season."'";
        $query = mysql_query($sql, $this->connect);

        return (mysql_num_rows($query) > 0);
    }

    function SetOpeningKabals(){
	    $ka = new KA_1();
	    $kac = $ka->KACBySeason($this->season);
        $kabals = $kac->KagInterface();
        $error = array();
        
        $resource = array();
        $i = 1;
        
        krsort($kabals);
        
        foreach($kabals as $kabal){
	        $resource[$i] = $kabal;
	        $i++;
        }
        
        $sql = "DELETE FROM `".$this->db_table."` WHERE `season` = '".$this->season."'";
        
        
        if (!mysql_query($sql, $this->connect)){
	        $error[] = 'Error from Database: '.mysql_error($this->connect);
    	}
    	
    	$pop = array_shift($resource);
    	
        $sql = "INSERT INTO `".$this->db_table."` (`bracket`, `kabal`, `round`, `season`) VALUES ('99', '$pop', '1', '".$this->season."')";	
        
        if (!mysql_query($sql, $this->connect)){
	        $error[] = 'Error from Database: '.mysql_error($this->connect);
    	}
        
        $brackets = floor(count($resource)/2);
        
        for ($i = 1; $i <= $brackets; $i++){
	        
	        if (is_int($i/2)){
		        $bracket = $i+1;
	        } elseif ($i == 1) {
		        $bracket = 1;
	        } else {
		        $bracket = $i-1;
	        }

            $piece1 = array_pop($resource);
            $piece2 = array_shift($resource);
            
            $sql = "INSERT INTO `".$this->db_table."` (`bracket`, `kabal`, `round`, `season`) VALUES ('$bracket', '$piece1', '1', '".$this->season."')";
            
            if (!mysql_query($sql, $this->connect)){
		        $error[] = 'Error from Database: '.mysql_error($this->connect);
	    	}
            
            $sql = "INSERT INTO `".$this->db_table."` (`bracket`, `kabal`, `round`, `season`) VALUES ('$bracket', '$piece2', '1', '".$this->season."')";
        	
        	if (!mysql_query($sql, $this->connect)){
		        $error[] = 'Error from Database: '.mysql_error($this->connect);
	    	}
        }
        
        $this->roster_error = implode('<br />', $error);
        
        $errors = count($error);
        return ($errors ? false : true);
    }

    function RenderBrackets($round, $bracket, $table){
        $sql = "SELECT * FROM `".$this->db_table."` WHERE `bracket` = '$bracket' AND `round` = '$round' AND `season` = '".$this->season."'";
        $query = mysql_query($sql, $this->connect);
		$array = array();

		$ka = new KA_1();
		$kac = $ka->KACBySeason($this->season);
		$round = $kac->RoundByID($round);
		
        $kabals = $round->GetKabalPoints();
		
        while ($info = mysql_fetch_array($query)){
            array_push($array, $info);
        }
        
        $first = $array[0];
        $second = $array[1];

        $kabal1 = new Division($first['kabal']);
        $kabal2 = new Division($second['kabal']);

        if ($second['eliminated']){
            if ($first['eliminated']){
                $double = true;
            } else {
                $use = true;
            }
        } else {
            if ($first['eliminated'] > 0){
                $use = true;
            } else { 
	            if ($first['graded']){
		            if ($second['graded']){
	            		$tie = true;
            		}
        		}
            }
        }
        
        $col = 1;
        $text = "Result: ";
        
        if (isset($double)){
            $winner = "Double DQ";
        } elseif (isset($use)){       
            if ($first['eliminated']){
                $winner = $kabal2;
            } else {
                $winner = $kabal1;
            }
            $text = 'Result: ';
        } elseif (isset($tie)){       
            $winner = "Tie";
        } else {
	        $col = 2;
        }
        
        $table->StartRow();
        $table->AddHeader('<small>Bracket ' . $bracket . '</small>', 2);
        $table->EndRow();
        
        $table->StartRow();
        $table->AddCell('<small><a href="/kac/stats.php?flag=kabal&season=' . $this->season . '&kabal=' . $kabal1->GetID() . '">' . $kabal1->GetName() 
        			. '</a> ('.number_format($kabals[$kabal1->GetID()]).')</small>', 2);
        $table->EndRow();
        
        $table->StartRow();
    	if ($col == 1){
	    	$table->AddCell('<small>' . $text . '</small>');
    		if (is_object($winner)){
	    		$table->AddCell('<small><a href="/kac/stats.php?flag=kabal&season=' . $this->season . '&kabal=' . $winner->GetID() . '">' 
	    			. $winner->GetName() . '</a> ('.number_format($kabals[$winner->GetID()]).')</small>', 2);
    		} else {
	    		$table->AddCell('<small>' . $winner . '</small>');
    		}
		} else {
			$table->AddCell('<small>vs.</small>', 2);
		}
        $table->EndRow();
        
        $table->StartRow();
        $table->AddCell('<small><a href="/kac/stats.php?flag=kabal&season=' . $this->season . '&kabal=' . $kabal2->GetID() . '">' . $kabal2->GetName() 
        			. '</a> ('.number_format($kabals[$kabal2->GetID()]).')</small>', 2);
        $table->EndRow();

    }

    function Bye(){
        $sql = "SELECT * FROM `".$this->db_table."` WHERE `bracket` = '99' AND `season` = '".$this->season."' AND `round` = '".$this->CurrentRound()
        		."' ORDER BY `bracket` DESC LIMIT 1";
        $query = mysql_query($sql, $this->connect);

        return (mysql_num_rows($query) > 0);
    }

    function ByeBracket($round, $table){
        $sql = "SELECT * FROM `".$this->db_table."` WHERE `bracket` = '99' AND `season` = '".$this->season."' AND `round` = '$round'";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        if (mysql_num_rows($query) > 0){

            $kabal = new Division($info['kabal']);

            $table->StartRow();
	        $table->AddHeader('<small>Distinguished Kabal</small>', 2);
	        $table->EndRow();
	        
	        $table->StartRow();
	        $table->AddCell('<small><a href="/kac/stats.php?flag=kabal&season=' . $this->season . '&kabal=' . $kabal->GetID() . '">' . $kabal->GetName() 
        			. '</a></small>', 2);
	        $table->EndRow();
		}
    }
    
    function ChampionBracket($kabal, $table){
            $table->StartRow();
	        $table->AddHeader('<small>Cup Winners</small>', 2);
	        $table->EndRow();
	        
	        $table->StartRow();
	        $table->AddCell('<small><a href="/kac/stats.php?flag=kabal&season=' . $this->season . '&kabal=' . $kabal->GetID() . '">' . $kabal->GetName() 
        			. '</a></small>', 2);
	        $table->EndRow();
    }

    function RoundFinished(){
        $round = $this->CurrentRound();
        
        $sql = "SELECT * FROM `".$this->db_table."` WHERE `bracket` < 99 AND `round` = '$round' AND `graded` = '0' AND `season` = '".$this->season
        		."' ORDER BY `bracket` DESC";        
        $query = mysql_query($sql, $this->connect);
        
        return (mysql_num_rows($query) == 0);

    }

    function Win($kabal, $round, $bracket){
	    $error = array();
	    $sql = "UPDATE `".$this->db_table."` SET `eliminated` = 1, `graded` = 1 WHERE `bracket` = '$bracket' AND `round` = '$round'"
	    		." AND `season` = '".$this->season."'";
	    
	    if (mysql_query($sql, $this->connect)){
		    $sql = "UPDATE `".$this->db_table."` SET `eliminated` = 0 WHERE `bracket` = '$bracket' AND `round` = '$round'"
		    		." AND `season` = '".$this->season."' AND `kabal` = '$kabal'";
		    		if (!mysql_query($sql, $this->connect)){
			    		$error[] = 'Error from Database: '.mysql_error($this->connect);
		    		}
	    } else {
		    $error[] = 'Error from Database: '.mysql_error($this->connect);
	    }
        
        $this->roster_error = implode('<br />', $error);
        
        $errors = count($error);
        return ($errors ? false : true);

    }

    function RenderRound($table, $round = 0){
	    
	    if ($round == 0){
		    $round = $this->CurrentRound();
	    }
	    
        if ($this->Champion($round)){

            $kabal = new Division($this->Champion($round));

            $this->ChampionBracket($kabal, $table);

        } else {

            for ($i = 1; $i <= $this->RoundBrackets($round); $i++){

                $this->RenderBrackets($round, $i, $table);

            }

        }

        $this->ByeBracket($round, $table);
    }

    function NewRound(){
        if ($this->RoundFinished()){
	        $error = array();
            $round = $this->CurrentRound();
            $brackets = $this->RoundBrackets();
            $new_round = $round+1;
            $round_bye = 0;
            
            $sql = "SELECT * FROM `".$this->db_table."` WHERE `round` = '$round' AND `eliminated` = '0' AND `season` = '".$this->season."'";
            $query = mysql_query($sql, $this->connect);
            $work = array();
            
            while ($info = mysql_fetch_array($query)){
                $work[$info['bracket']] = $info['kabal'];
            }
            
			$brackets = floor(count($work)/2);
			
            for ($i = 1; $i <= $brackets; $i++){
                $piece1 = array_pop($work);
                $piece2 = array_pop($work);
                
                $sql = "INSERT INTO `".$this->db_table."` (`bracket`, `round`, `kabal`, `season`) VALUES ('$i', '$new_round', '$piece1', '"
                		.$this->season."')";
                
                if (!mysql_query($sql, $this->connect)){
			        $error[] = 'Error from Database: '.mysql_error($this->connect);
		    	}
                
                $sql = "INSERT INTO `".$this->db_table."` (`bracket`, `round`, `kabal`, `season`) VALUES ('$i', '$new_round', '$piece2', '"
                		.$this->season."')";
               	
                if (!mysql_query($sql, $this->connect)){
			        $error[] = 'Error from Database: '.mysql_error($this->connect);
		    	}
            }

            if (count($work)){
                $pop = array_pop($work);

                $sql = "INSERT INTO `".$this->db_table."` (`bracket`, `round`, `kabal`, `season`) VALUES ('1', '$new_round', '$pop', '".$this->season."')";
                mysql_query($sql, $this->connect);
            }
            $this->roster_error = implode('<br />', $error);
        
	        $errors = count($error);
	        return ($errors ? false : true);
        } else {
	        return true;
        }
    }
    
    function GenerateLadder($season = '0', $ref = ''){
        $this->CurrentSeason($season);
        
        $table = '<table style="border: 0; width: 100%;">';
        $tr = '<tr style="vertical-align: top; text-align: center;">';
        $td = '<td style="width: 100%;">';
        $tdc = '</td>';
        $trc = '</tr>';
        $tablec = '</table>';
        
        if ($ref){
	        $ssn = $ref;
        } else {
	        $ssn = $this->season;
        }
        
        if ($this->CurrentRound()){ 
	        echo $table.$tr.$td.'KAC Ladder - <a href="/kac/stats.php?flag=kac&season='.$this->season.'">Season '.$ssn.'</a>'.$tdc.$trc.$tablec;	        
            for ($i = $this->CurrentRound(); $i >= 1; $i--){
	            $table = new Table('', true);
	            $table->StartRow();
		        $table->AddCell('<center><i><small>Round ' . $i . '</small></i></center>', 2);
		        $table->EndRow();
            	$this->RenderRound($table, $i);
                $table->EndTable();
            }
        } else {    
           echo 'Season data not found.';         
        }   
        
    }
    
 }

?>