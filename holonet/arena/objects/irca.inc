<?

 Class IRCA extends Arena {

    function IRCA(){
        Arena::Arena();
    }

    function Ungraded(){
        $sql = "SELECT * FROM `arena_irca_match` WHERE `date_deleted` = 0 AND `graded` = 0 AND `match` != ''";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new IRCAMatch($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function Unfinished(){
        $sql = "SELECT * FROM `arena_irca_match` WHERE `date_deleted` = 0 AND `graded` = 0 AND `match` = ''";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new IRCAMatch($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function CurrentHC(){
        $sql = "SELECT * FROM `arena_commentator` WHERE `end_date` = '0'";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        return $info['bhg_id'];
    }
    
    function NewHC($bhg_id){
	    $current = new Commentator($this->CurrentHC());
	    $current->EndTerm();
	    
	    $sql = "SELECT * FROM `arena_commentator` WHERE `bhg_id` = '$bhg_id'";
	    $query = mysql_query($sql, $this->connect);
	    
	    if (mysql_num_rows($query)){
		    $info = mysql_fetch_array($query);
		    $sql = "UPDATE `arena_commentator` SET `start_date` = '".time()."', `end_date` = 0";
	    } else {
	    	$sql = "INSERT INTO `arena_commentator` (`bhg_id`, `start_date`) VALUES ('$bhg_id', '".time()."')";
    	}
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function WeaponTypes(){
        $sql = "SELECT * FROM `arena_ladder_weapons`";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new WeaponType($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function Locations(){
        $return = array();
        $names = array();
        $output = array();
        $locations = array('complex', 'estate', 'hq', 'personal', 'other');
        
        foreach ($locations as $location){ 
        
        	$sql = "SELECT * FROM $location WHERE `arena` = 1";

        	$query = mysql_query($sql, $this->lyarna);

	        while ($info = mysql_fetch_array($query)){
		        $new = new Location($info['id'], $location);
	
	            $return[$new->GetID()."_".$new->GetTable()] = $info['planet'];
	            $names[$new->GetID()."_".$new->GetTable()] = $new->GetName();
            }
            
        }
        
        asort($return);
        
        foreach ($return as $key=>$planet){
		    $planets = new StarfieldLocation($planet);
		    $name = explode(',', $planets->GetName());
	        $output[$key] = $name[0].' - '.$names[$key];
        }

        return $output;

    }

    function Rules(){
        $sql = "SELECT * FROM `arena_ladder_type`";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Type($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
 }

?>