<?

 Class ROStats extends RO {

    var $bhg_id;
    var $xp;
    var $credits;
    var $medals;
    var $posts;
    var $ros;

    function ROStats($id) {
        Arena::Arena();

        $this->ros = mysql_num_rows(mysql_query("SELECT * FROM `arena_ro_hunters` WHERE `bhg_id` = '$id' AND `date_deleted` = 0", $this->connect));

        $sql = "SELECT SUM(`xp`) as xp, "
                ."SUM(`creds`) as credits, "
                ."SUM(`posts`) as posts, "
                ."SUM(`first`) as medals "
                ."FROM `arena_ro_hunters` WHERE `bhg_id` = '$id' AND `date_deleted` = 0";

        $query = mysql_query($sql, $this->connect);

        if ($result = mysql_fetch_array($query)) {

            $this->bhg_id = $id;
            $this->credits = $result['credits'];
            $this->xp = $result['xp'];
            $this->medals = $result['medals'];
            $this->posts = $result['posts'];

        }

    }

     function ReadRunOns(){
        $sql = "SELECT * FROM `arena_ro_hunters` WHERE `bhg_id` = '".$this->bhg_id."' AND `date_deleted` = 0 ORDER BY `run_on`";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($result = mysql_fetch_array($query)){
            $new = new RunOn($result['run_on']);
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

    function GetMedals() {
        return $this->medals;
    }
    
    function GetPosts() {
        return $this->posts;
    }

    function GetRunOns() {
        return $this->ros;
    }

    function GetName(){
        $person = new Person($this->bhg_id);

        return $person->GetName();
    }

 }

?>