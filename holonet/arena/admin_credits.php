<?php
function title() {
    return 'Administration :: General :: Award Credits';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['aa'];
}

function output() {
    global $arena, $auth_data, $hunter, $page, $roster, $arena;
    
    arena_header();

    if (isset($_REQUEST['submit'])){
	    
	    for ($i = 0; $i < 20; $i++) {
      
			$person = "person$i";
      
			$credits = "credits$i";
			
			if ($_REQUEST[$person]){
				$message = $arena->Tracker($hunter, 'CREDS', $_REQUEST[$credits]);
				$awarded = $roster->GetPerson($_REQUEST[$person]);
				$awarded->AddCredits($_REQUEST[$credits], $message.$_REQUEST['reason']);
			}
			
		}
		
		echo 'Credits Awarded.';
		
		hr();
	    
    }
    
    
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
	
	if (count($arena->CanBe()){
		$form->AddSectionTitle('Award As: ');
		$i = 0;
		
		foreach ($arena->CanBe() as $call=>$value){
			$form->AddRadioButton($value, 'use', $call, ($i ? '' : true));
			$i++;
		}
	}
	
	$form->table->StartRow();
	$form->table->AddCell('Reason');
	$form->table->AddCell('<input type="text" name="reason" size="50">', 2);
	$form->table->EndRow();
  
	$form->table->StartRow();
	$form->table->AddHeader('Kabal');
	$form->table->AddHeader('Person');
	$form->table->AddHeader('Credits');
	$form->table->EndRow();
  
	for ($i = 0; $i < 20; $i++) {
    
    	$form->table->StartRow();
      
		$form->table->AddCell("<select name=\"kabal$i\" "
        ."onChange=\"swap_kabal(this.form, $i)\">"
        ."<option value=\"-1\">N/A</option>$kabals</select>");
    
		$cell = "<select name=\"person$i\">";
      
		$cell .= "<option value=\"-1\">N/A</option>";
    
		$cell .= "</select>";
    
		$form->table->AddCell($cell);
    
		$form->table->AddCell("<input type=\"text\" name=\"credits$i\" value=\"0\" "
      	."size=7 onFocus=\"if (this.value == '0') this.value = ''\" "
      	."onBlur=\"if (this.value == '') this.value = '0'\">");
    
		$form->table->EndRow();
	}
  
	$form->table->StartRow();
	$form->table->AddCell('<input type="submit" name="submit" value="Submit Credit Awards" size="50">', 3);
	$form->table->EndRow();
	$form->EndForm();

    admin_footer($auth_data);
}
?>