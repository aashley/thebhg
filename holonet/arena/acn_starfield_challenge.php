<?php

function title() {
    return 'AMS Challenge Network :: Starfield Arena :: Make Challenge';
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

    $starfield = new Starfield();
	$sheet = new Sheet();
	
    echo 'Welcome, ' . $hunter->GetName() . '.<br><br>';

    if ($sheet->HasSheet($hunter->GetID())){
	
	    $settings = $starfield->Settings();
	    $types = $starfield->Types();
	    $restrictions_type = $starfield->Restrictions();
	    $locations = $starfield->Locations();
		    
		if (isset($_REQUEST['next'])){
	
	        if ($_REQUEST['challengee'] == $hunter->GetID()){
	
	            echo "Sorry, bubbles. You can't challenge yourself to a Starfield Arena Match.";
	
	        } elseif ($_REQUEST['challengee'] == -1) {
		        
		        echo "You need to pick a challenger first, bud.";
		        
	        } else {
	
		        if (count($starfield->Ships($hunter->GetID())) AND count($starfield->Ships($_REQUEST['challengee']))){
		        
		            $i = 1;
		
		            $form = new Form('acn_starfield_confirm');
		
		            $form->StartSelect('Your Ship:', 'my_ship');
		                foreach ($starfield->Ships($hunter->GetID()) as $value){
			                $form->AddOption(key($value), current($value));
		                }
		            $form->EndSelect();
		            
		            $form->StartSelect('Opponent\'s Ship:', 'their_ship');
		                foreach ($starfield->Ships($_REQUEST['challengee']) as $value){
			                $form->AddOption(key($value), current($value));
		                }
		            $form->EndSelect();
		
		            $form->StartSelect('Match Type:', 'type');
		            foreach($types as $value) {
		                $form->AddOption($value->GetID(), $value->GetName());
		            }
		            $form->EndSelect();
		
		            $form->StartSelect('Settings:', 'setting');
		            foreach($settings as $value) {
		                $form->AddOption($value->GetID(), $value->GetName());
		            }
		            $form->EndSelect();
		
		            $i = 3;
		
		            $form->StartSelect('Number of Posts:', 'posts');
		            while ($i <= 5) {
		                $form->AddOption($i, $i);
		                $i++;
		            }
		            $form->EndSelect();
		
		            $form->StartSelect('Location:', 'location', $locations[array_rand($locations)]);
		            $form->AddOption(0, 'No Location Specified');
		            foreach ($locations as $lid=>$lname) {
		                $form->AddOption($lid, $lname);
		            }
		            $form->EndSelect();
		
		            $form->table->StartRow();
		            $form->table->AddCell('Restrictions', 2);
		            $form->table->EndRow();
		
		            foreach ($restrictions_type as $value) {
		                $form->AddCheckBox($value->GetName(), 'restriction[]', $value->GetID());
		            }
		
		            $form->AddHidden('challengee', $_REQUEST['challengee']);
		
		            $form->AddSubmitButton('submit', 'Challenge');
		            $form->EndForm();
		            
	            } else {
		            
		            echo "Sorry, you can not complete this challenge, as one or both of the contestants do not have ships to fight with.";
		            
	            }
	
	        }
	
	    } else {
	
	        $form = new Form($page);
	        $form->table->StartRow();
	        $form->table->AddHeader('Sick and tired of someone saying how damn awesome their ship is? Want to test out your piloting skill? Challenge another hunter to the Starfield Arena and do it!', 2);
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
			
	        $form->AddSubmitButton('next', 'Next >>');
	        $form->EndForm();
	
	    }
	
	
	    hr();
	
	    $table = new Table('Explanations', true);
	    $table->AddRow('Name', 'Description');
	
	    $table->StartRow();
	    $table->AddHeader('Match Types', 2);
	    $table->EndRow();
	    foreach($types as $value) {
	        $table->AddRow($value->GetName(), $value->GetDesc());
	    }
	
	    $table->StartRow();
	    $table->AddHeader('Match Settings', 2);
	    $table->EndRow();
	    foreach($settings as $value) {
	        $table->AddRow($value->GetName(), $value->GetDesc());
	    }
	
	    $table->StartRow();
	    $table->AddHeader('Match Restrictions', 2);
	    $table->EndRow();
	    foreach($restrictions_type as $value) {
	        $table->AddRow($value->GetName(), $value->GetDesc());
	    }
	
	    $table->EndTable();
    
    } else {	    
	    echo 'You need a Character Sheet to challenge anyone. <a href="'.internal_link('admin_sheet', array('id'=>$hunter->GetID())).'"><b>Make one now!</b></a>';
    }

    arena_footer($auth_data);

}
?>
