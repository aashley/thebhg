<?php

function title() {
    return 'AMS Challenge Network :: Dojo of Shadows :: Make Challenge';
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

    echo 'Welcome, ' . $hunter->GetName() . '.<br><br>';

    $i = 1;
    $wtypes = $ladder->WeaponTypes();
    
    $form = new Form('acn_dojo_confirm', 'post', '', '', 'Challenge Another Hunter');
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
      $plebs = array();
			$cell .= "<option value=\"-1\" selected>N/A</option>\n".implode("", $plebs);
    
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

    $form->StartSelect('Number of Posts:', 'posts');
    while ($i <= 5) {
        $form->AddOption($i, $i);
        $i++;
    }
    $form->EndSelect();

    $form->AddSubmitButton('submit', 'Challenge');
    $form->EndForm();

    arena_footer();

}
?>
