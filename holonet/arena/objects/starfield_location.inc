<?

 Class StarfieldLocation extends Starfield {

    var $arena_starfield_name;
    var $arena_starfield_id;

    function StarfieldLocation($id) {
        Arena::Arena();

        $sql = "SELECT `id`, `name` FROM `planets` WHERE `id` = '$id'";
        $query = mysql_query($sql, $this->lyarna);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'arena_starfield_'.$key;
                $this->$key = stripslashes($value);
            }

        }

    }

    function GetID() {
        return $this->arena_starfield_id;
    }

    function GetName() {
        return stripslashes($this->arena_starfield_name);
    }

    function GetLink() {
        return "http://lyarna.thebhg.org/planets/?id=".$this->GetID();
    }

    function GetSiteLink() {
        return "<a href=".$this->GetLink().">".$this->GetName()."</a> on [ lyarna.thebhg.org ]";
    }

    function GetUsed() {
        $sql = "SELECT * FROM `arena_starfield_match` WHERE `location` = '".$this->GetID()."'";
        $query = mysql_query($sql, $this->connect);

        return mysql_num_rows($query);
    }

 }

?>