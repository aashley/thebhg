<?

 Class IRCA extends Arena {

    function IRCA(){
        Arena::Arena();
    }

    function Ungraded(){
        $sql = "SELECT * FROM `arena_irca_match` WHERE `date_deleted` = 0 AND `graded` = 0";
        $query = mysql_query($sql, $this->connect);
        $return = array();

        while ($info = mysql_fetch_array($query)){
            $new = new IRCAMatch($info['id']);
            array_push($return, $new);
        }

        return $return;
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
        $i = 0;

        while ($i < 5){

            if ($i == 0){
                $table = 'complex';
            } elseif ($i == 1){
                $table = 'estate';
            } elseif ($i == 2){
                $table = 'hq';
            } elseif ($i == 3){
	            $table = 'personal';
            } elseif ($i == 4){
	            $table = 'other';
            }
            
            $sql = "SELECT `id`, `name` FROM $table WHERE `arena` = 1";

            $query = mysql_query($sql, $this->lyarna);

            while ($info = mysql_fetch_array($query)){
                $new = new Location($info['id'], $table);

                $return[$new->GetID()."_".$new->GetTable()] = $new->GetName();
            }
            
            $i++;
        }

        asort($return);

        return $return;

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