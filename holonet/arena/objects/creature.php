<?

 Class Creature extends Arena {

    var $npc_string;
    var $npc_stats;
    var $npc_id;
    var $name;

    function Creature($id) {
        Arena::Arena();
        
        $sql = "SELECT * FROM `ams_creatures` WHERE id = '$id'";
        $query = mysql_query($sql, $this->holonet);

        if ($result = @mysql_fetch_array($query)) {

            foreach ($result as $key => $value) {
                $key = 'npc_'.$key;
                $this->$key = $value;
            }

            $this->npc_stats = unserialize($this->npc_stats);
            
			$this->name = array_shift($this->npc_stats);
        }

    }

    function GetID() {
        return $this->npc_id;
    }
    
    function GetName(){	    
	    return stripslashes(mb_convert_case($this->name, MB_CASE_TITLE, "UTF-8"));
    }
    
    function GetStats($table){
	    $table->AddRow('Name: ', $this->GetName());
	    
	    $sorted = $this->npc_stats;
	    arsort($sorted);
	    $highest = round(array_shift($sorted));
	    
	    foreach ($this->npc_stats as $name=>$stat){
		    $point = round($stat);
		    $value = str_repeat('<img src="arena/images/X.png" alt="X" height=20 width=20>', ($check ? $stat : round($point)));
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
	    $text = 'Name: '.$this->GetName();
	    
	    $sorted = $this->npc_stats;
	    arsort($sorted);
	    $highest = round(array_shift($sorted));
	    
	    foreach ($this->npc_stats as $name=>$stat){
		    $point = round($stat);

		    $text .= '<br />'.$name.': '.$point;
	    }

	    $text .= '<br /><br />Description: '.nl2br(stripslashes($this->npc_string));
	    
	    return $text;
    }
    
    function Edit($stats, $string){
	    $sql = "UPDATE `ams_creatures` SET `stats` = '".serialize($stats)."', `string` = '".addslashes($string)."' WHERE `id` = '".$this->npc_id."'";
	    
	    if (mysql_query($sql, $this->holonet)){
		    return true;
	    } else {
		    return false;
	    }
    }
 }

?>