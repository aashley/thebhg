<?php
function title() {
    return 'Administration :: General :: Remove Teta\'s Knives';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $auth_data, $hunter, $page, $sheet, $roster;

    arena_header();
    
    if (isset($_REQUEST['submit'])) {
		if ($arena->RemoveTeta($_REQUEST['challengee'])){
			echo 'Hunter got their pointy friends taken from them.';
		} else {
			echo 'Error.';
		}
		hr();
    }
	    
    foreach ($arena->GetTeta() as $hunter){	
		$hunter = new Person($hunter);
		$hunters[$hunter->GetID()] = $hunter->GetName();
	}
	
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
			
			foreach ($arena->GetTeta() as $hunter){	
				 $char = new Person($hunter);
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
	
	$form = new Form($page);
	
	$form->AddSectionTitle('Select Hunter to Piss Off');
	
	$form->table->StartRow();
	        $form->table->AddCell("<select name=\"kabal\" "
	        ."onChange=\"swap_kabal(this.form)\">"
	        ."<option value=\"-1\">N/A</option>$kabals</select>");
	
    $cell = "<select name=\"challengee\">";
    
			$cell .= "<option value=\"-1\" selected>N/A</option>\n";
    
		$cell .= "</select>";
    
		$form->table->AddCell($cell);

		$form->table->EndRow();
    
    $form->AddSubmitButton('submit', 'Steal Cutlery');
    $form->EndForm();

    admin_footer($auth_data);
}
?>