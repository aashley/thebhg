<?php

 Class Tournament extends Arena {

	var $season;
	var $doubleelim;
	var $denied;
	var $activity;
	 
    function Tournament($activity, $id = 0){
        Arena::Arena();
        $this->activity = $activity;
        $this->CurrentSeason($id);
        $this->DoubleElim($id);
    }
    
	function Seasons(){
        $sql = "SELECT * FROM `ams_tourney_dates` WHERE `activity` = '".$this->activity."' ORDER BY `start`";
        $query = mysql_query($sql, $this->holonet);
        $return = array();
        
        while ($info = mysql_fetch_array($query)){
	        $return[] = $info['id'];
        }

        return $return;
    }
    
    function CurrentSeason($old = 0){
        if ($old){
            $this->season = $old;
        } else {
            $sql = "SELECT * FROM `ams_tourney_dates` WHERE `activity` = '".$this->activity."' ORDER BY `start` DESC LIMIT 1";
            $query = mysql_query($sql, $this->holonet);
            $info = mysql_fetch_array($query);
			
            $this->season = $info['id'];
        }

        return $this->season;
    }
    
    function DoubleElim(){
        $sql = "SELECT * FROM `ams_tourney_dates` WHERE `id` = '".$this->season."'";
        $query = mysql_query($sql, $this->holonet);
        $info = mysql_fetch_array($query);

        $this->doubleelim = $info['doubleelim'];

        return $this->doubleelim;
    }

    function SetSignup($start, $end, $double_elim, $activity){
        $sql = "INSERT INTO `ams_tourney_dates` (`start`, `end`, `doubleelim`, `activity`) VALUES ('$start', '$end', '$double_elim', '$activity')";

        if (mysql_query($sql, $this->holonet)){
            return true;
        } else {
            return false;
        }
    }
    
    function EditDE($to = 0){
	    $sql = "UPDATE `ams_tourney_dates` SET `doubleelim` = '$to' WHERE `id` = '".$this->season."'";
	    $query = mysql_query($sql, $this->holonet);
	    return ($query ? true : false);
    }

    function ValidSignup(){
        $sql = "SELECT * FROM `ams_tourney_dates` ORDER BY `start` DESC LIMIT 1";
        $query = mysql_query($sql, $this->holonet);
        $info = mysql_fetch_array($query);

        if ($info['start'] < time()){
            if ($info['end'] > time()){
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }

    }

    function Signup($bhg_id){
        if ($this->ValidSignup()){
            $sql = "SELECT * FROM `ams_tourney_data` WHERE `bhg_id` = '$bhg_id' AND `season` = '".$this->season."'";
            $query = mysql_query($sql, $this->holonet);
            if (mysql_num_rows($query) > 0){
	            $this->denied = 'You are already signed up for this tournament.';
                return false;
            } else {
                $sql = "INSERT INTO `ams_tourney_data` (`bhg_id`, `season`) VALUES ('$bhg_id', '".$this->season."')";
                if (mysql_query($sql, $this->holonet)){
                    return true;
                } else {
	                $arena = new Arena();
                    $this->denied = 'System error';
                    return false;
                }
            }
        } else {
	        $this->denied = 'Invalid signup dates.';
            return false;
        }
    }

    function GetBracketHunters(){
        $sql = "SELECT * FROM `ams_tourney_data` WHERE `round` = '".$this->CurrentRound()."' AND `season` = '".$this->season."'";
        $query = mysql_query($sql, $this->holonet);
        $total = mysql_num_rows($query);
        $return = array();

        while ($info = mysql_fetch_array($query)){
	        if ($info['bracket']){
	            $person = new Person($info['bhg_id']);
				$return[$info['bracket']][] = $person;
			}
        }
        
        return ((count($return) > 1) ? $return : array());
    }
    
    function GetHunters(){
        $sql = "SELECT * FROM `ams_tourney_data` WHERE `round` = '".$this->CurrentRound()."' AND `season` = '".$this->season."'";
        $query = mysql_query($sql, $this->holonet);
        $total = mysql_num_rows($query);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $person = new Person($info['bhg_id']);
			$return[] = $person;
        }
        
        return ((count($return) > 1) ? $return : array());
    }

    function CurrentRound(){
        $sql = "SELECT * FROM `ams_tourney_data` WHERE `season` = '".$this->season."' ORDER BY `round` DESC LIMIT 1";
        $query = mysql_query($sql, $this->holonet);
        $info = mysql_fetch_array($query);
        
        return $info['round'];
    }

    function RoundBrackets($round = 0){
	    if ($round){
		    $value = $round;
	    } else {
		    $value = $this->CurrentRound();
	    }
	    
        $sql = "SELECT * FROM `ams_tourney_data` WHERE `bracket` < '99' AND `round` = '".$value."' AND `season` = '".$this->season."' ORDER BY `bracket` DESC LIMIT 1";
        $query = mysql_query($sql, $this->holonet);
        $info = mysql_fetch_array($query);

        return $info['bracket'];
    }

    function Gladius($round){
        $sql = "SELECT * FROM `ams_tourney_data` WHERE `bracket` = '1' AND `round` = '$round' AND `season` = '".$this->season."'";
        $query = mysql_query($sql, $this->holonet);
        $info = mysql_fetch_array($query);

        if (mysql_num_rows($query) == 1){      
	        return $info['bhg_id'];
        } else {
        	return false;
    	}
    }
    
    function IsGladius($bhg_id){
        $sql = "SELECT * FROM `ams_tourney_gladius` WHERE `bhg_id` = '$bhg_id'";
        $query = mysql_query($sql, $this->holonet);
        
        return mysql_num_rows($query);
    }

    function Started(){
        $sql = "SELECT * FROM `ams_tourney_data` WHERE `bracket` > '0' AND `season` = '".$this->season."'";
        $query = mysql_query($sql, $this->holonet);

        return (mysql_num_rows($query) > 0);
    }

    function Ended(){
        $sql = "SELECT * FROM `ams_tourney_data` WHERE `bracket` = '1' AND `round` = '".$this->CurrentRound()."' AND `season` = '".$this->season."'";
        $query = mysql_query($sql, $this->holonet);

        return (mysql_num_rows($query) == 1);
    }
    
    function Randomize(){
        $sql = "SELECT * FROM `ams_tourney_data` WHERE `graded` > '0' AND round = '".$this->CurrentRound()."' AND `season` = '".$this->season."'";
        $query = mysql_query($sql, $this->holonet);

        if (mysql_num_rows($query) > 0){

            return false;

        } else {

            $sql = "UPDATE `ams_tourney_data` SET `bracket` = '0 WHERE round = '".$this->CurrentRound()."' AND `season` = '".$this->season."'";
            mysql_query($sql, $this->holonet);

            $sql = "SELECT * FROM `ams_tourney_data` WHERE round = '".$this->CurrentRound()."' AND `season` = '".$this->season."'";
            $query = mysql_query($sql, $this->holonet);

            $work = array();

            while ($info = mysql_fetch_array($query)){
               array_push($work, $info['bhg_id']);
            }
            
            $brackets = floor(count($work)/2);

            shuffle($work);
            
            if ($this->CurrentRound() > 0){
	            $round = $this->CurrentRound();
            } else {
	            $round = 1;
            }
            
            $start = $this->CurrentRound();
            
            for ($i = 1; $i <= $brackets; $i++){
                $piece1 = array_pop($work);
                $piece2 = array_pop($work);

                $person1 = new Person($piece1);
                $person2 = new Person($piece2);
                
                $sql = "UPDATE `ams_tourney_data` SET `bracket` = '$i', round = '".$round."' WHERE `bhg_id` = '$piece1' AND round = '".$start."' AND `season` = '".$this->season."'";
                mysql_query($sql, $this->holonet);
                $sql = "UPDATE `ams_tourney_data` SET `bracket` = '$i', round = '".$round."' WHERE `bhg_id` = '$piece2' AND round = '".$start."' AND `season` = '".$this->season."'";
                mysql_query($sql, $this->holonet);

            }

            if (count($work)){
                $pop = array_pop($work);

                $sql = "UPDATE `ams_tourney_data` SET `bracket` = '99', round = '".$round."' WHERE `bhg_id` = '$pop' AND round = '".$start."' AND `season` = '".$this->season."'";
                mysql_query($sql, $this->holonet);

            }
            
            return true;
        }
    }

    function RenderBrackets($round, $bracket, $table){
        $sql = "SELECT * FROM `ams_tourney_data` WHERE `bracket` = '$bracket' AND `round` = '$round' AND `season` = '".$this->season."'";
        $query = mysql_query($sql, $this->holonet);
		$array = array();

        while ($info = mysql_fetch_array($query)){
            array_push($array, $info);
        }
        
        $first = $array[0];
        $second = $array[1];

        $person1 = new Person($first['bhg_id']);
        $person2 = new Person($second['bhg_id']);

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
                $winner = $person2;
            } else {
                $winner = $person1;
            }
            $text = 'Result: ';
        } elseif (isset($tie)){       
            $winner = "Tie";
        } else {
	        $col = 2;
        }
        
        $table->StartRow();
        $table->AddHeader('<small>Bracket '.$bracket, 2);
        $table->EndRow();
        
        $table->StartRow();
        $table->AddCell('<small><a href="' . internal_link('atn_general', array('id'=>$person1->GetID())) . '">' . $person1->GetName() . '</a>', 2);
        $table->EndRow();
        
        $table->StartRow();
    	if ($col == 1){
	    	$table->AddCell('<small>'.$text);
    		if (is_object($winner)){
	    		$table->AddCell('<small>' . $winner->GetName());
    		} else {
	    		$table->AddCell('<small>'.$winner);
    		}
		} else {
			$table->AddCell('<small>vs.', 2);
		}
        $table->EndRow();
        
        $table->StartRow();
        $table->AddCell('<small><a href="' . internal_link('atn_general', array('id'=>$person2->GetID())) . '">' . $person2->GetName() . '</a>', 2);
        $table->EndRow();

    }

    function Bye(){
        $sql = "SELECT * FROM `ams_tourney_data` WHERE `bracket` = '99' AND `season` = '".$this->season."' AND `round` = '".$this->CurrentRound()."' ORDER BY `bracket` DESC LIMIT 1";
        $query = mysql_query($sql, $this->holonet);

        return (mysql_num_rows($query) > 0);
    }

    function ByeBracket($round, $table){
        $sql = "SELECT * FROM `ams_tourney_data` WHERE `bracket` = '99' AND `season` = '".$this->season."' AND `round` = '$round'";
        $query = mysql_query($sql, $this->holonet);
        $info = mysql_fetch_array($query);

        if (mysql_num_rows($query) > 0){

            $person = new Person($info['bhg_id']);

            $table->StartRow();
	        $table->AddHeader('<small>Bye', 2);
	        $table->EndRow();
	        
	        $table->StartRow();
	        $table->AddCell('<small><a href="' . internal_link('atn_general', array('id'=>$person->GetID())) . '">' . $person->GetName() . '</a>', 2);
	        $table->EndRow();
		}
    }
    
    function GladiusBracket($person, $table){
            $table->StartRow();
	        $table->AddHeader('<small>Gladius Prime', 2);
	        $table->EndRow();
	        
	        $table->StartRow();
	        $table->AddCell('<small><a href="' . internal_link('atn_general', array('id'=>$person->GetID())) . '">' . $person->GetName() . '</a>', 2);
	        $table->EndRow();
    }

    function RoundFinished(){
        $round = $this->CurrentRound();
        $bracket = $this->RoundBrackets();

        $sql = "SELECT * FROM `ams_tourney_data` WHERE `bracket` < 99 AND `round` = '$round' AND `graded` > '0' AND `season` = '".$this->season."' ORDER BY `bracket` DESC";
        $query = mysql_query($sql, $this->holonet);

		$finished = mysql_num_rows($query);

		$done = $finished/2;

        return ($done == $this->RoundBrackets());

    }

    function Win($bhg_id, $round, $bracket){
        $sql = "SELECT * FROM `ams_tourney_data` WHERE `bracket` = '$bracket' AND `round` = '$round' AND `bhg_id` != '$bhg_id' AND `season` = '".$this->season."'";
        $query = mysql_query($sql, $this->holonet);
        $info = mysql_fetch_array($query);

        $loser = $info['bhg_id'];
        $sql = "UPDATE `ams_tourney_data` SET `eliminated` = 1 WHERE `bhg_id` = '$loser' AND `bracket` = '$bracket' AND `round` = '$round' AND `season` = '".$this->season."'";

        if (mysql_query($sql, $this->holonet)){

            $sql = "UPDATE `ams_tourney_data` SET `graded` = 1 WHERE `bracket` = '$bracket' AND `round` = '$round' AND `season` = '".$this->season."'";

            if (mysql_query($sql, $this->holonet)){
	           		$sql = "UPDATE `ams_tourney_data` SET `graded` = 1, `eliminated` = 0 WHERE `bhg_id` = '$bhg_id' AND `bracket` = '$bracket' AND `round` = '$round' AND `season` = '".$this->season."'";

		            if (mysql_query($sql, $this->holonet)){			            
		                return true;
		            } else {
		                return false;
		            }

            } else {
                return false;
            }
        } else {
            return false;
        }

    }
    
    function DoubleDQ($round, $bracket){
	    $sql = "UPDATE `ams_tourney_data` SET `graded` = 1, `eliminated` = 1 WHERE `bracket` = '$bracket' AND `round` = '$round' AND `season` = '".$this->season."'";
	
	    if (mysql_query($sql, $this->holonet)){
	        return true;
	    } else {
	        return false;
	    }
    }
    
    function Tie($round, $bracket){
	    $sql = "UPDATE `ams_tourney_data` SET `graded` = 1, `eliminated` = 0 WHERE `bracket` = '$bracket' AND `round` = '$round' AND `season` = '".$this->season."'";
	
	    if (mysql_query($sql, $this->holonet)){
	        return true;
	    } else {
	        return false;
	    }
    }

    function RenderRound($table, $round = 0){
	    
	    if ($round == 0){
		    $round = $this->CurrentRound();
	    }
	    
        if ($this->Gladius($round)){

            $person = new Person($this->Gladius($round));

            $this->GladiusBracket($person, $table);

        } else {

            for ($i = 1; $i <= $this->RoundBrackets($round); $i++){

                $this->RenderBrackets($round, $i, $table);

            }

        }

        $this->ByeBracket($round, $table);
    }

    function NewRound(){
        if ($this->RoundFinished()){
            $round = $this->CurrentRound();
            $brackets = $this->RoundBrackets();
            $new_round = $round+1;
            $round_bye = 0;
            
            $sql = "SELECT * FROM `ams_tourney_data` WHERE `round` = '$round' AND `eliminated` = '0' AND `season` = '".$this->season."' ORDER BY `bracket` DESC";
            $query = mysql_query($sql, $this->holonet);
            $work = array();
            
            while ($info = mysql_fetch_array($query)){
                array_push($work, $info['bhg_id']);
            }
            
            if ($this->doubleelim){
	            $sql = "SELECT * FROM `ams_tourney_data` WHERE `round` = '$round' AND `eliminated` = '1' AND `bracket` != '$round_bye' AND `season` = '".$this->season."' ORDER BY `bhg_id` DESC";
	            $query = mysql_query($sql, $this->holonet);
	            
	            while ($info = mysql_fetch_array($query)){
		            $sql = "SELECT * FROM `ams_tourney_data` WHERE `bhg_id` = '".$info['bhg_id']."' AND `season` = '".$this->season."' AND `eliminated` = '1'";
		            $check = mysql_query($sql, $this->holonet);
	                if (mysql_num_rows($check) <= 1){
		                array_push($work, $info['bhg_id']);
	                }
	            }
            }
            
            shuffle($work);
			$brackets = floor(count($work)/2);

			if (!is_int(count($work)/2) && (count($work) > 1)){
                $bhg_id = array_pop($work);

                $sql = "INSERT INTO `ams_tourney_data` (`bhg_id`, `bracket`, `round`, `season`) VALUES ('$bhg_id', '99', '$new_round', '".$this->season."')";
                mysql_query($sql, $this->holonet);
            }
			
            for ($i = 1; $i <= $brackets; $i++){
                $piece1 = array_pop($work);
                $piece2 = array_pop($work);

                $person1 = new Person($piece1);
                $person2 = new Person($piece2);
                
                $sql = "INSERT INTO `ams_tourney_data` (`bracket`, `round`, `bhg_id`, `season`) VALUES ('$i', '$new_round', '$piece1', '".$this->season."')";
                mysql_query($sql, $this->holonet);
                $sql = "INSERT INTO `ams_tourney_data` (`bracket`, `round`, `bhg_id`, `season`) VALUES ('$i', '$new_round', '$piece2', '".$this->season."')";
                mysql_query($sql, $this->holonet);
            }

            if (count($work)){
                $pop = array_pop($work);

                $sql = "INSERT INTO `ams_tourney_data` (`bracket`, `round`, `bhg_id`, `season`) VALUES ('1', '$new_round', '$pop', '".$this->season."')";
                mysql_query($sql, $this->holonet);
                
		        $sql = "INSERT INTO `ams_tourney_gladius` VALUES ('".$this->season."', '$pop')";
		        mysql_query($sql, $this->holonet);  
            }
        }
    }
    
    function Organize($bracket_start, $hunter_start, $bracket_end, $hunter_end){
	    $sql = "UPDATE `ams_tourney_data` SET `bracket` = '$bracket_start' WHERE `season` = '".$this->season."' AND `round` = '".$this->CurrentRound()."' AND ".
		    	"`bhg_id` = '$hunter_start'";
		if (mysql_query($sql, $this->holonet)){
			$sql = "UPDATE `ams_tourney_data` SET `bracket` = '$bracket_end' WHERE `season` = '".$this->season."' AND `round` = '".$this->CurrentRound()."' AND ".
			    	"`bhg_id` = '$hunter_end'";
			if (mysql_query($sql, $this->holonet)){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
    }
    
    function GenerateTournament($season = '0'){
        $this->CurrentSeason($season);
        
        if ($this->CurrentRound()){ 
	        echo '<table border=0 width="100%"><tr valign="top" align="center"><td width=100%><small><u>Arena Tournament Brackets<u></td></tr><tr valign="top"></table>';
        	echo '<table border=0 cellpadding=3 cellspacing=3><tr valign="top"><td valign="top">';   	        
            for ($i = 1; $i <= $this->CurrentRound(); $i++){
	            $table = new Table('', true);
		            $table->StartRow();
			        $table->AddHeader('<small>Round '.$i, 2);
			        $table->EndRow();
                	$this->RenderRound($table, $i);
                $table->EndTable();
                if (is_int($i/5)){
	                echo '</td></tr>';
                }
                
                if ($i != $this->CurrentRound()){
	                echo '</td><td valign="top">';
                } else {
	                echo '</tr></table>';
                }
            }
        } else {    
           echo 'The tournament has not beung, hence, no brackets.';         
        }      
    }
    
    function AdminRound($table){
        for ($i = 1; $i <= $this->RoundBrackets(); $i++){
            $this->AdminBrackets($this->CurrentRound(), $i, $table);
        }
    }
    
    function AdminBrackets($round, $bracket, $table){
        $sql = "SELECT * FROM `ams_tourney_data` WHERE `bracket` = '$bracket' AND `round` = '$round' AND `season` = '".$this->season."'";
        $query = mysql_query($sql, $this->holonet);
		$array = array();

        while ($info = mysql_fetch_array($query)){
            array_push($array, $info);
        }
        
        $first = $array[0];
        $second = $array[1];
		$graded = '';
		$win1 = '';
		$win2 = '';
        
        if ($first['graded']){
	        $graded = " - Graded.";
	        if ($first['eliminated']){
		        if ($second['eliminated']){
			        $win1 = 'Double DQ';
			        $win2 = $win1;
		        } else {
			        $win2 = 'Winner';
			        $win1 = 'Loser';
		        }
	        } else {
		        if ($second['eliminated']){
			        $win1 = 'Winner';
			        $win2 = 'Loser';
		        } else {
			        $win1 = 'Tie';
			        $win2 = $win1;
		        }
	        }
        }
        
        $person1 = new Person($first['bhg_id']);
        $person2 = new Person($second['bhg_id']);
        
        $table->StartRow();
        $table->AddHeader('Bracket '.$bracket.$graded);
        $table->EndRow();
        
        $table->StartRow();
        $table->AddCell('<a href="'. internal_link('admin_tournament_win', array('id'=>$person1->GetID(), 'bracket'=>$bracket, 'act'=>$this->activity)) . '">' . $person1->GetName() . '</a>'.' ('.$win1.')');
        $table->EndRow();
        
        $table->StartRow();
	    $table->AddCell('<a href="'. internal_link('admin_tournament_ddq', array('id'=>$bracket, 'act'=>$this->activity)) . '">Double DQ</a> | <a href="'
	    		. internal_link('admin_tournament_tie', array('id'=>$bracket, 'act'=>$this->activity)) . '">Tie</a>');
        $table->EndRow();
        
        $table->StartRow();
        $table->AddCell('<a href="'. internal_link('admin_tournament_win', array('id'=>$person2->GetID(), 'bracket'=>$bracket, 'act'=>$this->activity)) . '">' . $person2->GetName() . '</a>'.' ('.$win2.')');
        $table->EndRow();

    }
    
    function AdminOrganize($form){
        for ($i = 1; $i <= $this->RoundBrackets(); $i++){
            $this->AdminBracket($this->CurrentRound(), $i, $form);
        }
        $this->AdminBuyCheck($form);
    }

    function AdminBuyCheck($form){
        $sql = "SELECT * FROM `ams_tourney_data` WHERE `bracket` = '99' AND `round` = '".$this->CurrentRound()."' AND `season` = '".$this->season."'";
        $query = mysql_query($sql, $this->holonet);
		$info = mysql_fetch_array($query);
        
        $person1 = new Person($info['bhg_id']);
        
        $form->table->StartRow();
        $form->table->AddHeader('Bye Bracket', 2);
        $form->table->EndRow();
        
        $form->AddRadioButton($person1->GetName(), 'bracket[99]', $person1->GetID());

    }
    
    function AdminBracket($round, $bracket, $form){
        $sql = "SELECT * FROM `ams_tourney_data` WHERE `bracket` = '$bracket' AND `round` = '$round' AND `season` = '".$this->season."'";
        $query = mysql_query($sql, $this->holonet);
		$array = array();

        while ($info = mysql_fetch_array($query)){
            array_push($array, $info);
        }
        
        $first = $array[0];
        $second = $array[1];
        
        $person1 = new Person($first['bhg_id']);
        $person2 = new Person($second['bhg_id']);
        $form->AddHidden('act', $this->activity);
        $form->table->StartRow();
        $form->table->AddHeader('Bracket '.$bracket, 2);
        $form->table->EndRow();
        
        $form->AddRadioButton($person1->GetName(), 'bracket['.$bracket.']', $person1->GetID());
        
        $form->table->StartRow();
        $form->table->AddCell('vs.', 2);
        $form->table->EndRow();
        
        $form->AddRadioButton($person2->GetName(), 'bracket['.$bracket.']', $person2->GetID());

    }
    
    function DeleteSignup($bhg_id){
        $sql = "DELETE FROM `ams_tourney_data` WHERE `bhg_id` = '$bhg_id' AND `season` = '".$this->season."' AND `round` = '".$this->CurrentRound()."'";
        if (mysql_query($sql, $this->holonet)){
            return true;
        } else {
            return false;
        }

    }
    
    function Wildcard($bhg_id){

        $sql = "INSERT INTO `ams_tourney_data` (`bhg_id`, `season`, `round`) VALUES ('$bhg_id', '".$this->season."', '".$this->CurrentRound()."')";
        if (mysql_query($sql, $this->holonet)){

            return true;

        } else {

            return false;

        }

    }
    
 }

?>