<?php
function title() {
    return 'Administration :: Twilight Gauntlet :: Choose Final Opponent';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['fin_ttg'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;
    
    arena_header();

    $ladder = new Ladder();
    $ttg = new TTG();

    $i = 1;
    $wtypes = $ladder->WeaponTypes();
    $locations = $ladder->Locations();
    $types = $ladder->Rules();
    
    $challenge = $ttg->FinalMatch($hunter->GetID());
    
    if ($challenge->GetID()){
	    
	    if (isset($_REQUEST['submit'])) {
		    
		    $control = new Control();
	
		    if ($challenge->CanStart()){
		    
		    	if ($_REQUEST['challengee'] != $hunter->GetID()+1) {
		            $local = explode("_", $_REQUEST['location']);
		            $person = new Person($_REQUEST['challengee']);
		            $name = 'Twilight Gauntlet: Final Match: '.$hunter->GetName().' vs. '.$person->GetID();
		            
		            $new = $control->OldMatch($_REQUEST['rules'], $local[0], $local[1], $_REQUEST['posts'],
		            $_REQUEST['num_weapon'], $hunter->GetID(), $_REQUEST['challengee'], $_REQUEST['type_weapon'], $_REQUEST['name'], 
		            time(), 0, $_REQUEST['mbid']);
		            
		            if ($new){              
			            
			            if ($challenge->FinalChallenge($control->LastInsert(), $_REQUEST['challengee'])){ 
		                	echo 'Final challenge made.';
	                	} else {
		                	echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 26';
	                	}    		                
		            }
		            else {
		                echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 27';
		            }
		            
		        } else {
			        echo "Please hit back and fix the hunters, as you have put the same hunter for both challenger and challengee.";
		        }
	        } else {		        
		        echo "This match not ready to be posted.";		        
	        }
    	}
	    else {
		    $form = new Form($page);
		
		    if (isset($_REQUEST['id'])){
				$id = $_REQUEST['id'];
			}
		    
		    $form->AddHidden('id', $id);
		    $form->AddHidden('posts', 2);
		    
		    $kabals_result = $roster->GetDivisions();
	    
			$kabals = array();
	    
			foreach ($kabals_result as $kabal) {
	      
			      if ($kabal->GetID() != 9 && $kabal->GetID() != 16) {
			        
			        $kabals[$kabal->GetName()] = "<option value=\"".$kabal->GetID()."\">"
			          .$kabal->GetName()."</option>\n";
			      }
	      
	    	}
	    
			$kabals = implode('', $kabals);
			
			$hunters = array();
			$plebsheet = array();
			
			foreach ($sheet->SheetHolders() as $char) {
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
		
		    $form->AddSubmitButton('submit', 'Make Final Challenge');
		    $form->EndForm();
	    }
	    
    } else {
	    
	    echo "You can not choose any final match.";
	    
    } 

    admin_footer($auth_data);
}
?>