<?php

function title() {
    return 'AMS Challenge Network :: IRC Arena :: Submit Match';
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

    echo 'Please enter in the stats of your match along with a log of the match for grading.';

    hr();

    $i = 1;
    $wtypes = $ladder->WeaponTypes();
    $locations = $ladder->Locations();
    $types = $ladder->Rules();
    
    $form = new Form('acn_irca_confirm');
    $form->table->StartRow();
    $form->table->AddHeader('So, the regualr arena moved to slow for ya? Well, at least you\'ve branched into Real Time fighting rather than the general slaughter of your co-workers.', 2);
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
    $i = 5;
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

    $form->StartSelect('Number of Actions:', 'posts');
    while ($i <= 15) {
        $form->AddOption($i, $i);
        $i++;
    }
    $form->EndSelect();
    
    $form->AddTextArea('Match Log:', 'match');

    $form->AddSubmitButton('submit', 'Submit');
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
