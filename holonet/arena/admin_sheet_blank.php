<?php
function title() {
    return 'Administration :: General :: Insert Blank Sheet';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['aa'];
}

function output() {
    global $auth_data, $page, $roster;

    arena_header();
    
		$kabals_result = $roster->GetDivisions();
    
		$kabals = array();
    
		foreach ($kabals_result as $kabal) {
      
      if ($kabal->GetID() == 12) {
        
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
	<form name="award" method="post" action="<?=$PHP_SELF?>">
	<input type="hidden" name="module" value="<?=$module?>">
	<input type="hidden" name="page" value="<?=$page?>">
	Reason: <input type="text" name="reason" size=25>
	<?php
  
	$table = new Table('', true);
  
	$table->StartRow();
	$table->AddHeader('Kabal');
	$table->AddHeader('Person');
	$table->AddHeader('Credits');
	$table->EndRow();
  
	for ($i = 0; $i < $fields; $i++) {
    
    $table->StartRow();
      
			$table->AddCell("<select name=\"kabal$i\" "
        ."onChange=\"swap_kabal(this.form, $i)\">"
        ."<option value=\"-1\">N/A</option>$kabals</select>");
    
		$cell = "<select name=\"person$i\">";
      
			$cell .= "<option value=\"-1\">N/A</option>";
    
		$cell .= "</select>";
    
		$table->AddCell($cell);
    
		$table->AddCell("<input type=\"text\" name=\"credits$i\" value=\"0\" "
      ."size=7 onFocus=\"if (this.value == '0') this.value = ''\" "
      ."onBlur=\"if (this.value == '') this.value = '0'\">");
    
		$table->EndRow();
	}
  
	$table->EndTable();
  
	?>
	<input type="submit" value="Submit Credit Award" class="button" name="submit">&nbsp;<input type="reset" class="button">
	</form>
	<?php

    admin_footer($auth_data);
}
?>