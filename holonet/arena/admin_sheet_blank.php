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
      
      if ($kabal->GetID() != 9 && $kabal->GetID() != 16) {
        
        $kabals[$kabal->GetName()] = "<option value=\"".$kabal->GetID()."\">"
          .$kabal->GetName()."</option>\n";
      }
      
    }
    
		$kabals = implode('', $kabals);
	?>
	
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