<?

 Class StarfieldFighter extends Starfield {

    var $arena_starfield_bhg_id;
    var $arena_starfield_xp;
    var $arena_starfield_credits;
    var $arena_starfield_outcome;
    var $arena_starfield_match_id;
    var $arena_starfield_ship_id;

    function StarfieldFighter($id, $match) {
        Arena::Arena();

        $sql = "SELECT * FROM `arena_starfield_records` WHERE `bhg_id` = '$id' and `match_id` = '$match'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'arena_starfield_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }

    function GetID() {
        return $this->arena_starfield_bhg_id;
    }

    function GetName(){
        $person = new Person($this->arena_starfield_bhg_id);

        return $person->GetName();
    }

    function GetXP() {
        return $this->arena_starfield_xp;
    }

    function GetCredits() {
        return $this->arena_starfield_credits;
    }

    function GetMatch() {
        return new Match($this->arena_starfield_match_id);
    }

    function GetScore() {
        return $this->arena_starfield_outcome;
    }

    function GetResult() {
        return $this->GetOutcome($this->GetScore());
    }

    function GetStats() {
        return new Stats($this->arena_starfield_bhg_id);
    }

    function GetShipName(){
        return $this->ShipName($this->GetID(), $this->GetShipID());
    }

    function GetShipID(){
        return $this->arena_starfield_ship_id;
    }

    function GetShipLink(){
        return "<a href=http://mall.thebhg.org/ssl/index.php?frame=registries/item.php&id=".$this->GetShipID().">".$this->GetShipName()."</a>";
    }

    function GetShipMBLink(){
        return "[url=http://mall.thebhg.org/ssl/index.php?frame=registries/item.php&id=".$this->GetShipID()."]".$this->GetShipName()."[/url]";
    }

 }

?>