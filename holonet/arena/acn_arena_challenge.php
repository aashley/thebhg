<?php

function title() {
    return 'AMS Challenge Network :: Arena :: Make Challenge';
}

function auth($person) {
    global $hunter, $roster, $auth_data;
    
    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    $div = $person->GetDivision();
    return ($div->GetID() != 0 && $div->GetID() != 16);
}

function output() {
    global $arena, $hunter, $roster, $page, $auth_data;

    arena_header();

    $ladder = new Ladder();
	$ttg = new TTG();
    
    echo 'Welcome, ' . $hunter->GetName() . '.<br><br>';

    $challenges = $ladder->Pending($hunter->GetID());

    if (count($challenges)) {
        $table = new Table('Pending Challenges', true);
        $table->StartRow();
        $table->AddHeader('Challenger');
        $table->AddHeader('Match Type');
        $table->AddHeader('Location');
        $table->AddHeader('Weapon Type');
        $table->AddHeader('Num. of Weapons');
        $table->AddHeader('Posts');
        if (in_array($hunter->GetID(), $ttg->Members())){
	        $table->AddHeader('Gauntlet Match');
        }
        $table->AddHeader('&nbsp;', 2);
        $table->EndRow();
        foreach($challenges as $value) {
            $type = $value->GetType();
            $challenger = $value->GetChallenger();
            $weapon = $value->GetWeaponType();
            $location = $value->GetLocation();
            $gauntlet = 'No';
            
            if ($value->IsTTG()){
	            $gauntlet = 'Yes';
            }
            
            $table->StartRow();
            $table->AddCell('<a href="' . internal_link('hunter', array('id'=>$challenger->GetID()), 'roster') . '">' . $challenger->GetName() . '</a>');
            $table->AddCell($type->GetName());
            $table->AddCell($location->GetName());
            $table->AddCell($weapon->GetWeapon());
            $table->AddCell($value->GetWeapons());
            $table->AddCell($value->GetPosts());
            if (in_array($hunter->GetID(), $ttg->Members())){
		        $table->AddCell($gauntlet);
	        }
            $table->AddCell('<a href="' . internal_link('acn_arena_accept', array('id'=>$value->GetID())) . '">Accept</a>');
            $table->AddCell('<a href="' . internal_link('acn_arena_decline', array('id'=>$value->GetID())) . '">Decline</a>');
            $table->EndRow();
        }
        $table->EndTable();
    }
    else {
        echo 'You have no challenges pending.';
    }

    hr();

    $i = 1;
    $wtypes = $ladder->WeaponTypes();
    $locations = $ladder->Locations();
    $types = $ladder->Rules();
    
    $form = new Form('acn_arena_confirm', 'post', '', '', 'Challenge Another Hunter');
    $form->table->StartRow();
    $form->table->AddHeader('Has another hunter irritated you? Perhaps they\'ve stolen your ship. Or, worse, your lawn gnome. Now you can challenge them to a fight in the Arena!', 2);
    $form->table->EndRow();

    $kabals_result = $roster->GetDivisions();
    
		$kabals = array();
    
		foreach ($kabals_result as $kabal) {
      
		      if ($kabal->GetID() != 9 && $kabal->GetID() != 16) {
		        
		        $kabals[$kabal->GetName()] = "<option value=\"".$kabal->GetID()."\">"
		          .$kabal->GetName()."</option>\n";
		      }
      
    	}
    
		$kabals = implode('', $kabals);
	?>
	<script language="JavaScript1.1" type="text/javascript">
	<!--
	function person(id, name) {
		this.id = id;
		this.name = name;
	}

	<?php
  
		reset($kabals_result);
    
	  $commindex = 0;
    
		foreach ($kabals_result as $kabal) {
      
			if ($kabal->GetID() == 16) {
        
				continue;
        
			}
      
			echo 'roster' . $kabal->GetID() . " = new Array();\n";
      
			$plebs = $kabal->GetMembers('name');
      
	    if (is_array($plebs)) {
        
	      $plebindex = 0;
        
        foreach ($plebs as $pleb) {
          
          $div_peeps[$pleb->GetName().':'.$plebindex] = 
            'roster'
            .(($kabal->GetID() == 9) 
              ? '10' 
              : $kabal->GetID()) 
            .'['.
            (($kabal->GetID() == 9 || $kabal->GetID() == 10) 
              ? $commindex++ 
              : $plebindex++)
            .'] = new person('.$pleb->GetID().', \''
            .str_replace("'", "\\'", shorten_string($pleb->GetName(), 40))
            ."');\n";
            
        }
        
        echo implode('', $div_peeps);
        
        unset($div_peeps);
        
	    }
      
		}
    
	?>

	function swap_kabal(frm) {
		var kabal_list = eval("frm.kabal");
		var person_list = eval("frm.challengee");
		var kabal = kabal_list.options[kabal_list.options.selectedIndex].value;
		if (kabal > 0) {
			var kabal_array = eval("roster" + kabal);
			var new_length = kabal_array.length;
			person_list.options.length = new_length;
			for (i = 0; i < new_length; i++) {
				person_list.options[i] = new Option(kabal_array[i].name, kabal_array[i].id, false, false);
			}
		}
		else {
			person_list.options.length = 1;
			person_list.options[0] = new Option("N/A", -1, false, false);
		}
	}

	// -->
	</script>
	<noscript>
	This page requires JavaScript to function properly.
	</noscript>
<?
        $form->table->StartRow();
        $form->table->AddCell("<select name=\"kabal\" "
        ."onChange=\"swap_kabal(this.form)\">"
        ."<option value=\"-1\">N/A</option>$kabals</select>");

    $cell = "<select name=\"challengee\">";
    
			$cell .= "<option value=\"-1\" selected>N/A</option>\n";
    
		$cell .= "</select>";
    
		$form->table->AddCell($cell);

		$form->table->EndRow();

    $form->StartSelect('Number of Weapons:', 'num_weapon');
    while ($i <= 5) {
        $form->AddOption($i, $i);
        $i++;
    }
    $i = 3;
    $form->EndSelect();
    $form->StartSelect('Weapon Type:', 'type_weapon');
    foreach($wtypes as $value) {
        $form->AddOption($value->GetID(), $value->GetWeapon());
    }
    $form->EndSelect();

    $form->StartSelect('Location:', 'location', $locations[array_rand($locations)]);
    foreach ($locations as $lid=>$lname) {
        $form->AddOption($lid, $lname);
    }
    $form->EndSelect();

    $form->StartSelect('Rules:', 'rules');
    foreach($types as $value) {
        $form->AddOption($value->GetID(), $value->GetName());
    }
    $form->EndSelect();

    $form->StartSelect('Number of Posts:', 'posts');
    while ($i <= 5) {
        $form->AddOption($i, $i);
        $i++;
    }
    $form->EndSelect();

    $form->AddSubmitButton('submit', 'Challenge');
    $form->EndForm();
    
    hr();

    $table = new Table('Explanation of Rules', true);
    $table->AddRow('Name', 'Description', 'Damage Allowed');
    foreach($types as $value) {
        $table->AddRow($value->GetName(), $value->GetDesc(), $value->GetRules());
    }
    $table->EndTable();

    arena_footer();

}
?>
