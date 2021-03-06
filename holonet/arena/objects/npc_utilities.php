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
        $stats = explode("\r\n", $blocktext);
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
    
    function GetName($string){
    	$npc = unserialize($string);
    	
    	return mb_convert_case($npc[first], MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($npc[last], MB_CASE_TITLE, "UTF-8");
	}
	
    function Construct($string){
	    $npc = unserialize($string);
	    
	    if (is_array($npc)){
		    $sheets = 'Name: '.mb_convert_case($npc[first], MB_CASE_TITLE, "UTF-8").' '.mb_convert_case($npc[last], MB_CASE_TITLE, "UTF-8")
		    		.'<br />Language: Galactic Basic<br />Species: '.$npc[species].'<br />Gender: '.$npc[sex].'<br />';
		    
		    $sheet = new Sheet();
	
		    foreach ($npc['field'] as $field){
			    if (is_array($npc[$field]['stats'])){
			    	foreach($npc[$field]['stats'] as $stat=>$value){
				    	$stat = new Statribute($stat);
				    	if ($stat->isint()){
				    		$sheets .= '<br />'.$stat->GetName().': '.$value;
			    		}
			    	}
		    	}
		    	if (is_array($npc[$field]['skills'])){
			    	foreach($npc[$field]['skills'] as $skill=>$value){
				    	$skill = new Skill($skill);
				    	$sheets .= '<br />'.$skill->GetName().': '.$value;
			    	}
		    	}
		    	$sheets .= '<br />';
	    	}
    	} else {
	    	$sheets = 'Somethings farked.';
    	}
	    
    	return $sheets;
    }

 }

?>
