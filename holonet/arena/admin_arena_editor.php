<?php
function title() {
    return 'Administration :: Arena :: Match Editor';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;

    arena_header();

    $ladder = new Ladder();
    
    if (isset($_REQUEST['match_id'])){
	    $match = new Match($_REQUEST['match_id']);
	    $weapon_types = $ladder->WeaponTypes();
	    $locations = $ladder->Locations();
	    $types = $ladder->Rules();
    }

    if (isset($_REQUEST['next'])) {
        
        $type = $match->GetType();
        $weapon_type = $match->GetWeaponType();
        $location = $match->GetLocation();
        $i = 0;

        $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Data');
        $form->table->AddHeader('Value');
        $form->table->EndRow();

        $form->AddTextBox('Message Board ID:', 'mb_id', $match->GetMatchID(), 10);
        $form->AddHidden('match_id', $_REQUEST['match_id']);

        $form->AddTextBox('Match Name:', 'name', $match->GetName(), 50);

        $form->StartSelect('Number of Weapons:', 'num_weapon', $match->GetWeapons());
        while ($i <= 5) {
            $form->AddOption($i, $i);
            $i++;
        }
        $form->EndSelect();

        $i = 3;

        $form->StartSelect('Weapon Type:', 'weapon_type', $weapon_type->GetID());
        foreach($weapon_types as $value) {
            $form->AddOption($value->GetID(), $value->GetWeapon());
        }
        $form->EndSelect();
        
        $form->StartSelect('Location:', 'location', $location->LocationMesh());
        foreach ($locations as $lid=>$lname) {
            $form->AddOption($lid, $lname);
        }
        $form->EndSelect();

        $form->StartSelect('Rules:', 'rules', $type->GetID());
        foreach($types as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();

        $form->StartSelect('Number of Posts:', 'posts', $match->GetPosts());
        while ($i <= 5) {
            $form->AddOption($i, $i);
            $i++;
        }
        $form->EndSelect();

        $form->AddSubmitButton('submit', 'Edit Match');
        $form->EndForm();
        
        hr();
        
        $kabals_result = $roster->GetDivisions();
	    
			$kabals = array();
			$sheet = new Sheet();
	    
			foreach ($kabals_result as $kabal) {
	      
			      if ($kabal->GetID() != 9 && $kabal->GetID() != 16) {
			        
			        $kabals[$kabal->GetName()] = "<option value=\"".$kabal->GetID()."\">"
			          .$kabal->GetName()."</option>\n";
			      }
	      
	    	}
	    
			$kabals = implode('', $kabals);
			
			$hunters = array();
			$plebsheet = array();
			
			foreach ($sheet->SheetHolders(1) as $char) {
			     $hunters[$char->GetName()] = new Person($char->GetID());
	    	}
	    	
	    	ksort($hunters);
	    	
	    	foreach ($hunters as $name=>$person){
		    	$kabal = $person->GetDivision();
		    	$plebsheet[$kabal->GetID()][] = $person;
	    	}
	
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
	      
				$plebs = $plebsheet[$kabal->GetID()];
	      
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

	function swap_kabal(frm, id) {
		var kabal_list = eval("frm.kabal" + id);
		var person_list = eval("frm.person" + id);
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
	<?php
        
        $form = new Form($page);
        $form->table->StartRow();
        $form->table->AddHeader('Make Change');
        $form->table->AddHeader('Hunter');
        $form->table->AddHeader('Replace With', 2);
        $form->table->EndRow();

        $i = 1;
        
        foreach ($match->GetContenders() as $contender){
	        $form->table->StartRow();
	        $form->table->AddCell('<input type="checkbox" name="change['.$i.']" value=1>');
	        $form->table->AddCell($contender->GetName());
	     	$form->table->AddCell("<select name=\"kabal$i\" "
	        ."onChange=\"swap_kabal(this.form, $i)\">"
	        ."<option value=\"-1\">N/A</option>$kabals</select>");
	    
			$cell = "<select name=\"person$i\">";
	      
			$cell .= "<option value=\"-1\">N/A || Delete</option>";
	    
			$cell .= "</select>";
	    
			$form->table->AddCell($cell);   
	        $form->table->EndRow();
	        $i++;
        }
        $form->table->StartRow();
        $form->table->AddCell('<input type="checkbox" name="change['.$i.']" value=1>');
        $form->table->AddCell('<b>New Hunter</b>');
        $form->table->AddCell("<select name=\"kabal$i\" "
	        ."onChange=\"swap_kabal(this.form, $i)\">"
	        ."<option value=\"-1\">N/A</option>$kabals</select>");
	    
			$cell = "<select name=\"person$i\">";
	      
			$cell .= "<option value=\"-1\">N/A</option>";
	    
			$cell .= "</select>";
	    
			$form->table->AddCell($cell);  
        
        $form->AddHidden('persons', $i);

        $form->AddSubmitButton('hunters', 'Edit Hunters');
        $form->EndForm();
    }
    elseif (isset($_REQUEST['submit'])) {
        $local = explode("_", $_REQUEST['location']);
        $edit = $match->Edit($_REQUEST['name'], $local[0], $local[1], $_REQUEST['num_weapon'], $_REQUEST['weapon_type'], $_REQUEST['posts'], $_REQUEST['mb_id'], $_REQUEST['rules']);
        echo $edit;
    }
    else {
        $form = new Form($page);
        $form->StartSelect('Match:', 'match_id');
        foreach ($ladder->Unfinished() as $value) {
            $form->AddOption($value->GetID(), $value->GetName());
        }
        $form->EndSelect();
        $form->AddSubmitButton('next', 'Next >>');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>