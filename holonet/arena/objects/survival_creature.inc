<?

 Class Creature extends Survival {

    var $npc_string;
    var $npc_stats;
    var $npc_id;
    var $type;

    function Creature($id, $difficulty = 2) {
        Arena::Arena();

        $this->type = new SurvivalType($difficulty);
        
        $sql = "SELECT * FROM `arena_survival_npc` WHERE id = '$id'";
        $query = mysql_query($sql, $this->connect);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'npc_'.$key;
                $this->$key = stripslashes($value);
            }
            
            $this->npc_stats = unserialize($this->npc_stats);

        }

    }

    function GetID() {
        return $this->npc_id;
    }
    
    function GetStats($table){
	    if ($this->type->GetPoints() < 1){
		    $namemod = 'Lesser ';
	    } elseif ($this->type->GetPoints() > 1.5){
		    $namemod = 'Elder ';
	    }
	    
	    $stat = array_shift($this->npc_stats);
	    $table->AddRow('Name: ', $namemod.mb_convert_case($stat, MB_CASE_TITLE, "UTF-8"));
	    foreach ($this->npc_stats as $name=>$stat){
		    $table->AddRow($name, $stat*$this->type->GetPoints());
	    }
    }

    function BuildSheet(){
       $table = new Table('', true);
       
       $this->GetStats($table);
       $table->AddRow('Description: ', nl2br(stripslashes($this->npc_string)));
       $table->EndTable();
    }

 }

?>