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
	   
	    $sorted = $this->npc_stats;
	    arsort($sorted);
	    $highest = array_shift($sorted);
	    
	    foreach ($this->npc_stats as $name=>$stat){
		    $point = round($stat*$this->type->GetPoints());
		    $value = str_repeat('<img src="arena/images/X.png" alt="X" height=20 width=20>', round($point));
		    $value .= str_repeat('<img src="arena/images/0.png" alt="0" height=20 width=20>', round($highest-$point));
		    echo $highest-$point;
		    $table->AddRow($name, $value);
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