<?

 Class LW_Contract extends LW_Solo {

    var $contract_id;
    var $contract_mb_id;
    var $contract_bhg_id;
    var $contract_grade;
    var $contract_creds;
    var $contract_xp;
    var $contract_requested;
    var $contract_completed;

    function LW_Contract($id) {
        Arena::Arena();

        $sql = "SELECT * FROM `arena_lw_contracts` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'contract_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }

    function GetID() {
        return $this->contract_id;
    }

    function GetLink(){
        return "<a href=http://boards.thebhg.org/index.php?op=view&topic=".$this->GetMBID().">Lone Wolf Contract ".$this->GetContractID()."</a>";
    }

    function ArenaLink(){
        return "<i><a href=http://boards.thebhg.org/index.php?op=view&topic=".$this->GetMBID().">Message Board Topic</a></i>";
    }

    function GetBHGID(){
        return $this->contract_bhg_id;
    }

    function GetContractID() {

        if ($this->contract_id < 100){
            if ($this->contract_id < 10){
                return "00".$this->contract_id;
            } else {
                return "0".$this->contract_id;
            }

        } else {
            return $this->contract_id;
        }
    }

    function GetMBID() {
        return $this->contract_mb_id;
    }

    function GetGrade() {
        return new Grade($this->contract_grade);
    }

    function GetGradeID(){
        return $this->contract_grade;
    }

    function GetDCO() {
        return ($this->contract_bhg_id == 0);
    }

    function GetTimeframe(){

        $timeframe = 60*60*24*7;

        $date = getdate(time()+$timeframe);
        return $date['mon']."/".$date['mday']."/".$date['year'];
    }

    function GetCompleted() {
        if ($this->contract_completed){
            $date = getdate($this->contract_completed);
            return "Completed On: ".$date['month']." ".$date['mday'].", ".$date['year'];
        } elseif ($this->GetDCO()) {
            return "<b>Dead Contract</b>";
        } else {
            return "<b>Pending</b>";
        }
    }

    function GetCredits() {
        return $this->contract_creds;
    }

    function GetXP() {
        return $this->contract_xp;
    }

    function GetNPC() {
        return new LW_NPC($this->contract_id);
    }

    function GetComplete() {
        return ($this->contract_completed > 0);
    }

    function GetHunter(){

        if ($this->GetDCO()){
            return false;
        } else {
            return new LW_Hunter($this->contract_bhg_id);
        }

    }
    
    function GetDCOs(){
	    $sql = "SELECT * FROM `arena_lw_dco` WHERE `contract` = '".$this->contract_id."' ORDER BY `date` ASC";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $new = new Person($info['bhg_id']);
		    $date = getdate($info['date']);
		    $return[] = array('date'=>$info['date'], 'hunter'=>$new, 'writedate'=>$date['mon']."/".$date['mday']."/".$date['year']);
	    }
	    
	    return $return;
    }
    
    function IsRequested() {
        return ($this->contract_requested == 0);
    }

    function SetMBID($mb_id) {
        $sql = "UPDATE `arena_lw_contracts` SET `mb_id` = '$mb_id' WHERE `id` = '".$this->contract_id."'";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }
    
    function DeDCO() {
        $sql = "UPDATE `arena_lw_contracts` SET `requested` = '0' WHERE `id` = '".$this->contract_id."'";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }

    function SetHunter($bhg_id, $requested = 0) {
        $sql = "UPDATE `arena_lw_contracts` SET `bhg_id` = '$bhg_id', `requested` = '$requested' WHERE `id` = '".$this->contract_id."'";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }
    
    function Retire($bhg_id) {	    
	    $sql = "INSERT INTO `arena_lw_retire` VALUES ('".$this->contract_id."', '".$this->contract_bhg_id."', '".time()."')";
	    mysql_query($sql, $this->connect);
	    
        $sql = "UPDATE `arena_lw_contracts` SET `bhg_id` = '$0' WHERE `id` = '".$this->contract_id."'";

        if (mysql_query($sql, $this->connect)) {

            return true;

        } else {

            return false;

        }

    }
    
    function GetRetires(){
	    $sql = "SELECT * FROM `arena_lw_retire` WHERE `contract` = '".$this->contract_id."' ORDER BY `date` ASC";
	    $query = mysql_query($sql, $this->connect);
	    $return = array();
	    
	    while ($info = mysql_fetch_array($query)){
		    $new = new Person($info['bhg_id']);
		    $date = getdate($info['date']);
		    $return[] = array('date'=>$info['date'], 'hunter'=>$new, 'writedate'=>$date['mon']."/".$date['mday']."/".$date['year']);
	    }
	    
	    return $return;
    }

    function Edit($bhg_id, $mbid){
        $sql = "UPDATE `arena_lw_contracts` SET ";
        $add = array("`id` = '".$this->contract_id."'");
        $return = "";

        if ($bhg_id != $this->contract_bhg_id){
            array_push($add, "`bhg_id` = '$bhg_id'");
            $return .= "Hunter Edited.<br />";
        }

        if ($mbid != $this->contract_mb_id){
            array_push($add, "`mb_id` = '$mbid'");
            $return .= "Message Board ID Edited.<br />";
        }

        $sql .= implode(', ', $add);

        $sql .= " WHERE `id` = '".$this->contract_id."'";

        if (mysql_query($sql, $this->connect)){

            return $return;

        } else {

            return 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 62';

        }

    }

    function Complete($creds, $xp, $grade) {
        $end = time();

        $sql = "UPDATE `arena_lw_contracts` SET `completed` = '".time()."', `creds` = '$creds', `xp` = '$xp', `grade` = '$grade' WHERE `id` = '".$this->contract_id."'";

        if (mysql_query($sql, $this->connect)) {

            $person = new Person($this->contract_bhg_id, 'fight-51-me');
            $person->AddCredits($creds, 'Lone Wolf Contract');
	        
            return true;

        } else {

            return false;

        }

    }

    function DCO() {
	    $sql = "INSERT INTO `arena_lw_dco` VALUES ('".$this->contract_id."', '".$this->contract_bhg_id."', '".time()."')";

	    $person = new Person($this->contract_bhg_id);
        $character = new Character($person->GetID());
        $character->XPEvent(-10, 'DCOing LW Contract '.$contract->GetContractID());
	    
        if (mysql_query($sql, $this->connect)) {

	        $sql = "UPDATE `arena_lw_contracts` SET `bhg_id` = '0' WHERE `id` = '".$this->contract_id."'";
	        $query = mysql_query($sql, $this->connect);
            
	        return ($query ? true : false);

        } else {

            return false;

        }

    }

 }

?>