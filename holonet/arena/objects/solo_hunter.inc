<?

 Class Hunter extends Solo {

    var $bhg_id;
    var $creds;
    var $xp;

    function Hunter($bhg_id) {
        Arena::Arena();

        $sql = "SELECT SUM(xp) as xp, "
                ."SUM(creds) as credits "
                ."FROM `arena_solo_contracts` WHERE `bhg_id` = '$bhg_id' AND `completed` > 0";

        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        $this->creds = $info['credits'];
        $this->xp = $info['xp'];
        $this->bhg_id = $bhg_id;

    }

    function GetID() {
        return $this->bhg_id;
    }

    function GetName(){

        $person = new Person($this->bhg_id);

        return $person->GetName();
    }

    function GetXP() {
        return $this->xp;
    }

    function GetCredits() {
        return $this->creds;
    }

    function GetContracts() {
        return mysql_num_rows(mysql_query("SELECT * FROM `arena_solo_contracts` WHERE `bhg_id` = '".$this->bhg_id."' AND `completed` > 0", $this->connect));
    }

    function ReadContracts(){
        $sql = "SELECT * FROM `arena_solo_contracts` WHERE `bhg_id` = '".$this->bhg_id."' AND `completed` > 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($result = mysql_fetch_array($query)){
            $new = new Contract($result['id']);
            array_push($return, $new);
        }
        
        return $return;
    }

    function Notify($mbid){
                $text = "Your Solo Mission has been posted on the Message Boards. \n\nhttp://boards.thebhg.org/index.php?op=view&topic=$mbid\n\n Ric Gravant";

                $person = new Person($this->bhg_id);
                $from = "Bounty Office <adjunct@thebhg.org>";
                $subject = "Your Solo Mission is Ready";

                $person->SendEmail($from, $subject, $text);
    }

    function IsComissioner(){
        $sql = "SELECT * FROM `comissioners` WHERE `end_date` = 0";
        $query = mysql_query($sql, $this->connect);
        $info = mysql_fetch_array($query);

        return ($this->bhg_id == $info['bhg_id']);
    }

 }

?>