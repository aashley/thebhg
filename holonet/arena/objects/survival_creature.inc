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
	    $check = ($this->type->GetPoints() > 1.5);
	    
	    if ($this->type->GetPoints() < 1){
		    $namemod = 'Lesser ';
	    } elseif ($check){
		    $namemod = 'Elder ';
	    }
	    
	    $stat = array_shift($this->npc_stats);
	    $table->AddRow('Name: ', $namemod.mb_convert_case($stat, MB_CASE_TITLE, "UTF-8"));
	   
	    $table->AddRow('Difficulty: ', $this->type->GetName());
	    
	    $sorted = $this->npc_stats;
	    arsort($sorted);
	    $highest = round(array_shift($sorted)*$this->type->GetPoints());
	    
	    foreach ($this->npc_stats as $name=>$stat){
		    $point = round($stat*$this->type->GetPoints());
		    $value = str_repeat('<img src="arena/images/X.png" alt="X" height=20 width=20>', ($check ? $stat : round($point)));
		    if ($check){ $value .= str_repeat('<img src="arena/images/bonus.png" alt="*" height=20 width=20>', round($point-$stat)); }
		    $value .= str_repeat('<img src="arena/images/0.png" alt="0" height=20 width=20>', round($highest-$point));

		    $table->AddRow($name, $value);
	    }
    }

    function BuildSheet(){
       $table = new Table('', true);
       
       $this->GetStats($table);
       $table->AddRow('Description: ', nl2br(stripslashes($this->npc_string)));
       $table->EndTable();
    }
    
    function WriteSheet(){
	    $check = ($this->type->GetPoints() > 1.5);
	    
	    if ($this->type->GetPoints() < 1){
		    $namemod = 'Lesser ';
	    } elseif ($check){
		    $namemod = 'Elder ';
	    }
	    
	    $stat = array_shift($this->npc_stats);
	    $text = 'Name: '.$namemod.mb_convert_case($stat, MB_CASE_TITLE, "UTF-8");
	    
	    $text .= '<br />Difficulty: '.$this->type->GetName().'<br />';
	    
	    $sorted = $this->npc_stats;
	    arsort($sorted);
	    $highest = round(array_shift($sorted)*$this->type->GetPoints());
	    
	    foreach ($this->npc_stats as $name=>$stat){
		    $point = round($stat*$this->type->GetPoints());
		    $value = str_repeat('<img src="arena/images/X.png" alt="X" height=20 width=20>', ($check ? $stat : round($point)));
		    if ($check){ $value .= str_repeat('<img src="arena/images/bonus.png" alt="*" height=20 width=20>', round($point-$stat)); }
		    $value .= str_repeat('<img src="arena/images/0.png" alt="0" height=20 width=20>', round($highest-$point));

		    $text .= '<br />'.$name.$value;
	    }

	    $text .= '<br /><br />Description: '.nl2br(stripslashes($this->npc_string));
	    
	    return $text;
    }
 }

?>