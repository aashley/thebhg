<?

 Class Creature extends Survival {

    var $npc_string;
    var $npc_stats;
    var $npc_id;
    var $name;
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
			$this->name = array_shift($this->npc_stats);
        }

    }

    function GetID() {
        return $this->npc_id;
    }
    
    function GetName(){
	    $check = ($this->type->GetPoints() > 1.5);
	    
	    if ($this->type->GetPoints() < 1){
		    $namemod = 'Lesser ';
	    } elseif ($check){
		    $namemod = 'Elder ';
	    }
	    
	    return $namemod.mb_convert_case($this->name, MB_CASE_TITLE, "UTF-8");
    }
    
    function GetStats($table){
	    $check = ($this->type->GetPoints() > 1.5);

	    $table->AddRow('Name: ', $this->GetName());
	   
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
	    
	    $text = 'Name: '.$this->GetName();
	    
	    $text .= '<br />Difficulty: '.$this->type->GetName().'<br />';
	    
	    $sorted = $this->npc_stats;
	    arsort($sorted);
	    $highest = round(array_shift($sorted)*$this->type->GetPoints());
	    
	    foreach ($this->npc_stats as $name=>$stat){
		    $point = round($stat*$this->type->GetPoints());

		    $text .= '<br />'.$name.': '.$point;
	    }

	    $text .= '<br /><br />Description: '.nl2br(stripslashes($this->npc_string));
	    
	    return $text;
    }
    
    function Edit($stats, $string){
	    $sql = "UPDATE `arena_survival_npc` SET `stats` = '".serialize($stats)."', `string` = '".addslashes($string)."' WHERE `id` = '".$this->npc_id."'";
	    
	    if (mysql_query($sql, $this->connect)){
		    return true;
	    } else {
		    return false;
	    }
    }
 }

?>