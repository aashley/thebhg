<?

 Class StarfieldStats extends Starfield {

    var $bhg_id;
    var $xp;
    var $credits;
    var $points;
    var $matches;

    function StarfieldStats($id) {
        Arena::Arena();

        $this->matches = mysql_num_rows(mysql_query("SELECT * FROM `arena_starfield_records` WHERE `bhg_id` = '$id' AND `date_deleted` = 0 AND `match_id` > 0", $this->connect));

        $sql = "SELECT SUM(`xp`) as xp, "
                ."SUM(`credits`) as credits, "
                ."SUM(`outcome`) as points "
                ."FROM `arena_starfield_records` WHERE `bhg_id` = '$id' AND `date_deleted` = 0";

        $query = mysql_query($sql, $this->connect);

        if ($result = mysql_fetch_array($query)) {

            $this->bhg_id = $id;
            $this->credits = $result['credits'];
            $this->xp = $result['xp'];
            $this->points = $result['points'];

        }

    }

    function ReadMatches(){
        $sql = "SELECT * FROM `arena_starfield_records` WHERE `bhg_id` = '".$this->bhg_id."' AND `date_deleted` = 0 ORDER BY `match_id`";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($result = mysql_fetch_array($query)){
            $new = new StarfieldMatch($result['match_id']);
            array_push($return, $new);
        }
        
        return $return;
    }

    function GetID() {
        return $this->bhg_id;
    }

    function GetXP() {
        if ($this->xp > 0){
            return $this->xp;
        } else {
            return 0;
        }
    }

    function GetCredits() {
        return $this->credits;
    }

    function GetPoints() {
        return $this->points;
    }

    function GetMatches() {
        return $this->matches;
    }

    function GetName(){
        $roster = $this->Roster();

        $person = $roster->GetPerson($this->bhg_id);

        return $person->GetName();
    }

    function GetImage(){

        $roster = $this->Roster();

        $person = $roster->GetPerson($this->bhg_id);
        $bio = $person->GetBioData();
        $img = $bio->GetImageURL();

        if ($img){
            return $img;
        } else {
            return "http://overseer.thebhg.org/ladder/sil.gif";
        }

    }

 }

?>