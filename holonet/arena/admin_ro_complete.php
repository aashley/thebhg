<?php
function title() {
    return 'Administration :: Run-Ons :: Grade Run-On';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['ro'];
}

function next_medal($person, $group) {
	global $mb;

	$mg = $mb->GetMedalGroup($group);
	if ($mg->GetDisplayType() != 0) {
		echo 'Numeric medal, leaving immediately.<br>';
		$medals = $mg->GetMedals();
		return $medals[0];
	}
	
	$medals = $person->GetMedals();
	if (count($medals)) {
		$orders = array();
		$group_medals = $mg->GetMedals();
		foreach ($group_medals as $medal) {
			$orders[$medal->GetOrder()] = 0;
		}
		foreach ($medals as $am) {
			$medal = $am->GetMedal();
			$mgroup = $medal->GetGroup();
			if ($mgroup->GetID() == $group) {
				$orders[$medal->GetOrder()]++;
			}
		}
		ksort($orders);
		$last = 0;
		foreach ($orders as $key=>$o) {
			if ($o < $last) {
				$order = $key;
				break;
			}
			$last = $o;
		}
		if (empty($order)) {
			$order = min(array_keys($orders));
		}
		
		$medals = $mg->GetMedals();
		foreach ($medals as $medal) {
			if ($medal->GetOrder() == $order) {
				return $medal;
			}
		}
		return $medals[0];
	}
	else {
		$medals = $mg->GetMedals();
		return $medals[0];
	}
}

function output() {
    global $arena, $auth_data, $hunter, $page, $roster, $sheet, $mb;

    arena_header();

    $ro = new RO();

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
    if (isset($_REQUEST['next'])) {
	    $run_on = new RunOn($_REQUEST['id']);
        
        $form = new Form($page);
        $form->AddHidden('id', $_REQUEST['id']);
        $form->AddHidden('hunters', $_REQUEST['hunters']);
            
        $form->table->StartRow();
        $form->table->AddHeader('Kabal');
        $form->table->AddHeader('Hunter');
        $form->table->AddHeader('Credits');
        $form->table->AddHeader('XP');
        $form->table->AddHeader('Posts');
        $form->table->AddHeader('Winner?');
        $form->table->EndRow();
        
        for ($i = 1; $i <= $_REQUEST['hunters']; $i++) {
            
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
	      	
	      	$form->table->AddCell("<input type=\"text\" name=\"xp$i\" value=\"0\" "
	      	."size=7 onFocus=\"if (this.value == '0') this.value = ''\" "
	      	."onBlur=\"if (this.value == '') this.value = '0'\">");
	      	
	      	$form->table->AddCell("<input type=\"text\" name=\"posts$i\" value=\"0\" "
	      	."size=7 onFocus=\"if (this.value == '0') this.value = ''\" "
	      	."onBlur=\"if (this.value == '') this.value = '0'\">");
	      	
	      	$form->table->AddCell("<input type=\"radio\" name=\"first\" value=\"$i\">");
	
			$form->table->EndRow();
        }

        $form->table->StartRow();
        $form->table->AddCell('<input type="submit" name="submit" value="Grade Run On">', 6);
        $form->table->EndRow();
        $form->EndForm();
    }
    elseif (isset($_REQUEST['submit'])) {
	    
	    $run_on = new RunOn($_REQUEST['id']);

	    $errors = 0;
	    
	    for ($i = 1; $i <= $_REQUEST['hunters']; $i++){
		    
		    $id = "person$i";
		    $xp = "xp$i";
		    $creds = "credits$i";
		    $posts = "posts$i";
		    if ($_REQUEST['first'] == $i){
		    	$first = 1;
		    	$awarded = $roster->GetPerson($_REQUEST[$id]);
				$mb->AwardMedal($awarded, $hunter, next_medal($awarded, 22), 'Best Hunter in the Run On: '.$run_on->GetName());
	    	} else {
		    	$first = 0;
	    	}
		    
	    	if ($_REQUEST[$id] > 0){
			    if (!$run_on->Grade($_REQUEST[$id], $_REQUEST[$xp], $_REQUEST[$creds], $first, $_REQUEST[$posts])){
				    $errors++;
			    }
			    $awarded = $roster->GetPerson($_REQUEST[$id]);
				$awarded->AddCredits($_REQUEST[$creds], 'Completion of the Run On: '.$run_on->GetName());
		    }
	    }
	    
	    if ($errors) {
	    	echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 125';
    	} else {
            echo 'Results added successfully.'; 
        }

    }
    else {

        if (count($ro->Pending())){
	        $form = new Form($page);
	        $form->StartSelect('Run-On:', 'id');
	        foreach ($ro->Pending() as $value) {
	            $form->AddOption($value->GetID(), $value->GetName());
	        }
	        $form->EndSelect();
	        $form->AddTextBox('Number of Participants: ', 'hunters', 5);
	        $form->AddSubmitButton('next', 'Next >>');
	        $form->EndForm();
        }
        else {
            echo 'No ungraded Run-Ons.';
        }

    }

    admin_footer($auth_data);
}
?>