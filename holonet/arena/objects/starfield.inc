<?

 Class Starfield extends Arena {

	var $xp;
	var $creds;
	 
    function Starfield(){
        Arena::Arena();
    }

    function ShipName($bhg_id, $ship_id){
        $file = file('http://mall.thebhg.org/ssl/person-property.php?id='.$bhg_id);

        if (is_array($file)){
        
	        $work = $file[0];
	
	        $ships_raw = explode("<br>", $work);
	
	        $break = array();
	
	        foreach($ships_raw as $value){
	            $new = explode(" - ", $value);
	            array_push($break, $new[0]);
	        }
	
	        $data = array();
	
	        foreach($break as $value){
	            $new = explode("id=", $value);
	            array_shift($new);
	            $data[] = array_shift($new);
	        }
	
	        array_pop($data);
	
	        $ships = array();
	
	        foreach($data as $value){
	            $break = explode("\">", $value);
	            $new = explode("</a>", $break[1]);
	            $base = array($break[0] => $new[0]);
	            $ships = $ships+$base;
	        }
	        
	        if (array_key_exists($ship_id, $ships)){
	            return $ships[$ship_id];
	        } else {
		        return 'Decommissioned Ship';
	        }
        } else {
	        return 'Error Getting Ship Data!';
        }
    }

    function Build(){
	   $sql = "SELECT SUM(arena_starfield_records.xp) as xp, SUM(arena_starfield_records.credits) as credits FROM arena_starfield_records, arena_starfield_match WHERE arena_starfield_match.accepted = 1 "
                ."AND arena_starfield_match.id = arena_starfield_records.match_id AND arena_starfield_match.match_id > 0 AND arena_starfield_match.steward > 0 AND arena_starfield_match.date_deleted = 0 AND arena_starfield_match.is_dojo = '0'";
       
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        $this->creds = $info['credits'];
        $this->xp = $info['xp'];
    }
    
    function GetXP(){
	    return $this->xp;
    }
    
    function GetCreds(){
	    return $this->creds;
    }
    
    function Ships($bhg_id){
        $file = file('http://mall.thebhg.org/ssl/person-property.php?id='.$bhg_id);
        $return = array();

        if (is_array($file)){
        
	        $work = $file[0];
	
	        $ships_raw = explode("<br>", $work);
	
	        $break = array();
	
	        foreach($ships_raw as $value){
	            $new = explode(" - ", $value);
	            array_push($break, $new[0]);
	        }
	
	        $data = array();
	
	        foreach($break as $value){
	            $new = explode("id=", $value);
	            array_shift($new);
	            $data[] = array_shift($new);
	        }
	
	        array_pop($data);
	
	        foreach($data as $value){
	            $break = explode("\">", $value);
	            $new = explode("</a>", $break[1]);
	            $ship_data = array($break[0]=>$new[0]);
	            array_push($return, $ship_data);
	        }
	        
        } else {
	        
	        $return[0] = 'Error Getting Ship Data!';
	        
        }

        return $return;
    }
    
    function CurrentSkipper(){
        $sql = "SELECT * FROM `arena_skippers` WHERE `end_date` = '0'";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        return $info['bhg_id'];
    }
    
    function NewSkipper($bhg_id){
	    $current = new Skipper($this->CurrentSkipper());
	    $current->EndTerm();
	    
	    $sql = "SELECT * FROM `arena_skippers` WHERE `bhg_id` = '$bhg_id'";
	    $query = mysql_query($sql, $this->connect);
	    
	    if (mysql_num_rows($query)){
		    $info = mysql_fetch_array($query);
		    $sql = "UPDATE `arena_skippers` SET `start_date` = '".time()."', `end_date` = 0 WHERE `bhg_id` = '$bhg_id'";
	    } else {
	    	$sql = "INSERT INTO `arena_skippers` (`bhg_id`, `start_date`) VALUES ('$bhg_id', '".time()."')";
    	}
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function NewType($name, $description){
	    $sql = "INSERT INTO `arena_starfield_type` (`name`, `description`) VALUES ('".addslashes($name)."', '".addslashes($description)."')";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function NewSetting($name, $description){
	    $sql = "INSERT INTO `arena_starfield_setting` (`name`, `description`) VALUES ('".addslashes($name)."', '".addslashes($description)."')";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
    
    function NewRestriction($name, $description){
	    $sql = "INSERT INTO `arena_starfield_restrictions` (`name`, `description`) VALUES ('".addslashes($name)."', '".addslashes($description)."')";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }

    function Types(){
        $sql = "SELECT * FROM `arena_starfield_type` WHERE `date_deleted` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new StarfieldType($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function AllTypes(){
        $sql = "SELECT * FROM `arena_starfield_type`";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new StarfieldType($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function Settings(){
        $sql = "SELECT * FROM `arena_starfield_setting` WHERE `date_deleted` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Setting($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function AllSettings(){
        $sql = "SELECT * FROM `arena_starfield_setting`";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Setting($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function Restrictions(){
        $sql = "SELECT * FROM `arena_starfield_restrictions` WHERE `date_deleted` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Restriction($info['id']);
            array_push($return, $new);
        }

        return $return;
    }
    
    function AllRestrictions(){
        $sql = "SELECT * FROM `arena_starfield_restrictions`";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new Restriction($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function Locations(){
        $return = array();
        $query = mysql_query('SELECT `id`, `name` FROM `planets`', $this->lyarna);

            while ($info = mysql_fetch_array($query)){
                $new = new StarfieldLocation($info['id']);

                $return[$new->GetID()] = $new->GetName();
            }

        asort($return);

        return $return;

    }

    function Pending($bhg_id = 0){
        if ($bhg_id){
            $sql = "SELECT arena_starfield_records.match_id as id FROM arena_starfield_records, arena_starfield_match WHERE arena_starfield_records.bhg_id = '$bhg_id' AND "
                    ."arena_starfield_match.accepted = 0 AND arena_starfield_records.challenger = 0 AND arena_starfield_match.id = arena_starfield_records.match_id AND "
                    ."arena_starfield_match.date_deleted = 0";
        } else {
            $sql = "SELECT * FROM `arena_starfield_match` WHERE `accepted` = 1 AND `date_deleted` = 0 AND `end` = 0";
        }

        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new StarfieldMatch($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function Recent(){
        $sql = "SELECT * FROM `arena_starfield_match` WHERE `date_deleted` <= 1 ORDER BY `id` DESC LIMIT 20";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new StarfieldMatch($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function Unfinished(){
        $sql = "SELECT * FROM `arena_starfield_match` WHERE `date_deleted` = 0 AND `accepted` = 1 AND `end` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new StarfieldMatch($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

    function Unposted(){
        $sql = "SELECT * FROM `arena_starfield_match` WHERE `date_deleted` = 0 AND `accepted` = 1 AND `match_id` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new StarfieldMatch($info['id']);
            array_push($return, $new);
        }

        return $return;
    }

 }

?>