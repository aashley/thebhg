<?php

 Class NPC_Utilities extends Arena {

    function BuildSheet($string){
        $npc = explode("/", $string);

        $sheet = "Name: ".mb_convert_case($npc[34], MB_CASE_TITLE, "UTF-8")." ".mb_convert_case($npc[35], MB_CASE_TITLE, "UTF-8")
                ."<br />"."Language: Galactic Basic<br />"."Species: ".$npc[0]."<br />"."Gender: ".$npc[1]."<br /><br />"
                ."Dexterity: ".$npc[4]."<br />"."Strength: ".$npc[3]."<br />"."Senses: ".$npc[6]."<br />"."Stamina: ".$npc[5]."<br />"."Appearance: ".$npc[2]."<br /><br />"
                ."Conscience: ".$npc[9]."<br />"."Self Control: ".$npc[8]."<br />"."Courage: ".$npc[7]."<br /><br />"."Allies: ".$npc[10]."<br />"."Contacts: ".$npc[11]."<br />"
                ."Alternate ID: ".$npc[12]."<br /><br />"."Alertness: ".$npc[13]."<br />"."Brawl: ".$npc[14]."<br />"."Dodge: ".$npc[15]."<br />"
                ."Manipulate: ".$npc[16]."<br />"."Intimidation: ".$npc[19]."<br />"."Subterfuge: ".$npc[18]."<br />"."Stealth: ".$npc[17]."<br /><br />"
                ."Demolitions: ".$npc[22]."<br />"."Marksmanship: ".$npc[21]."<br />"."Melee: ".$npc[20]."<br />"."Piloting: ".$npc[26]."<br />"
                ."Security: ".$npc[23]."<br />"."Repair: ".$npc[25]."<br />"."Tracking: ".$npc[24]."<br /><br />"."Education: ".$npc[27]."<br />"
                ."Linguistics: ".$npc[28]."<br />"."Medicine: ".$npc[29]."<br />"."Poison: ".$npc[30]."<br />"."Politics: ".$npc[31]."<br />"
                ."Science: ".$npc[32]."<br />"."Technology: ".$npc[33]."<br /><br />";

        return $sheet;

    }

    function Parse($blocktext, $name){
        $stats = explode("\n", $blocktext);
        $i = 0;
        $count = count($stats);
        $pieces = array();
        $names = explode(" ", $name);

        while ($i < $count){
            $piece = $stats[$i];
            $new = explode(": ", $piece);
            array_push($pieces, trim($new[1]));

            $i++;
        }

        $string = $pieces[1]."/".$pieces[2]."/".$pieces[8]."/".$pieces[5]."/".$pieces[4]."/".$pieces[7]."/".$pieces[6]."/".$pieces[12]
                ."/".$pieces[11]."/".$pieces[10]."/".$pieces[14]."/".$pieces[15]."/".$pieces[16]."/".$pieces[18]."/".$pieces[19]
                ."/".$pieces[20]."/".$pieces[21]."/".$pieces[24]."/".$pieces[23]."/".$pieces[22]."/".$pieces[28]."/".$pieces[27]
                ."/".$pieces[26]."/".$pieces[30]."/".$pieces[32]."/".$pieces[31]."/".$pieces[29]."/".$pieces[34]."/".$pieces[35]
                ."/".$pieces[36]."/".$pieces[37]."/".$pieces[38]."/".$pieces[39]."/".$pieces[40]."/".$names[0]."/".$names[1];

        return $string;
    }
    
    function Construct($string){
	    $npc = explode("/", $string);
	    
	    $sheet = 'Name: '.mb_convert_case($npc[0], MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($npc[1], MB_CASE_TITLE, "UTF-8")
	    		.'<br />Language: Galactic Basic<br />Species: '.$npc[3].'<br />Gender: '.$npc[2];
	    $ref = 4;
	    
	    for ($i = 1; $i <= 11; $i++){
	    	$field = new Field($i);
		    $sheet .= '<br /><br />';
	    	foreach($sheet->GetStats($i) as $stat){
		    	if ($stat->IsInt()){
			    	if (isset($npc[$ref])){
				    	$value = $npc[$ref];
			    	} else {
				    	$value = 0;
			    	}
		    		$sheet .= $stat->GetName().': '.$value.'<br />';
		    		$ref++;
	    		}
	    	}
    	}
	    
    	return $sheet;
    }

 }

?>
