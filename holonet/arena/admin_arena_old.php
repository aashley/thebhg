<?php

function title() {
    return 'Administration :: Arena :: Add Old Match';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $hunter, $roster, $page, $auth_data, $sheet;

    arena_header();

    $ladder = new Ladder();

    hr();

    $i = 1;
    $wtypes = $ladder->WeaponTypes();
    $locations = $ladder->Locations();
    $types = $ladder->Rules();
    
    if (isset($_REQUEST['submit'])){
	    
	    $control = new Control();

    	if ($_REQUEST['person1'] != $_REQUEST['person2']) {
            $local = explode("_", $_REQUEST['location']);

            $new = $control->OldMatch($_REQUEST['rules'], $local[0], $local[1], $_REQUEST['posts'],
            $_REQUEST['num_weapon'], $_REQUEST['person1'], $_REQUEST['person2'], $_REQUEST['type_weapon'], $_REQUEST['name'], 
            parse_date_box('start'), parse_date_box('end'), $_REQUEST['mbid'], $_REQUEST['dojo']);
            
            if ($new){               
                $form = new Form('admin_arena_complete');
                
                $form->table->AddRow('Match Added Successfully.');
                $form->AddHidden('id', $control->LastInsert());
                $form->AddHidden('add_xp', '1');
	
			    $form->AddSubmitButton('', 'Complete Insert >>');
			    $form->EndForm();
                
            }
            else {
                echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 72';
            }
            
        } else {
	        echo "Please hit back and fix the hunters, as you have put the same hunter for both challenger and challengee.";
        }
	    
    } 
    else {
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
	    
	    $form->AddTextBox('Message Board ID', 'mbid', '', 10);
	
	    for ($i = 1; $i <= 2; $i++){
		    $form->table->StartRow();
		    $form->table->AddCell("Select Hunter: <select name=\"kabal$i\" "
	        ."onChange=\"swap_kabal(this.form, $i)\">"
	        ."<option value=\"-1\">N/A</option>$kabals</select>");
	    
			$cell = "<select name=\"person$i\">";
	      
			$cell .= "<option value=\"-1\">N/A</option>";
	    
			$cell .= "</select>";
	    
			$form->table->AddCell($cell);
			$form->table->EndRow();
		}
	    
	    $form->AddTextBox('Match Name', 'name', '', 50);
	
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
	
	    $form->AddCheckBox('Is Dojo Match:', 'dojo', 1);
	    
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
	    
	    $form->AddDateBox('Match Start', 'start');
	    $form->AddDateBox('Match End', 'end');
	
	    $form->AddSubmitButton('submit', 'Challenge');
	    $form->EndForm();
    }

    admin_footer($auth_data);

}
?>
