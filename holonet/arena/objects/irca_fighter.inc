<?

 Class IRCAFighter extends IRCA {

    var $arena_bhg_id;
    var $arena_xp;
    var $arena_credits;
    var $arena_outcome;
    var $arena_match_id;

    function IRCAFighter($id, $match) {
        Arena::Arena();

        $sql = "SELECT * FROM `arena_irca_records` WHERE `bhg_id` = '$id' and `match_id` = '$match'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'arena_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }

    function GetID() {
        return $this->arena_bhg_id;
    }

    function GetName(){
        $person = new Person($this->arena_bhg_id);

        return $person->GetName();
    }

    function GetXP() {
        return $this->arena_xp;
    }

    function GetCredits() {
        return $this->arena_credits;
    }

    function GetMatch() {
        return new IRCAMatch($this->arena_match_id);
    }

    function GetScore() {
        return $this->arena_outcome;
    }

    function GetResult() {
	    $arena = new Arena();
	    
        return $arena->GetOutcome($this->GetScore());
    }

    function GetStats() {
        return new IRCAStats($this->arena_bhg_id);
    }

 }

?>