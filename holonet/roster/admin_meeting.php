<?php
// Set the number of displayed fields here.
$fields = 50;

// Meeting credit amount.
$meetingCredits = 25000;

// Amount for someone who sent meeting credits to the Underlord.
$meetingProvider = 100000;

function title() {
	return 'Administration :: Add Meeting Credits';
}

function auth($person) {
	global $auth_data, $pleb, $roster;

	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return $auth_data['underlord'];
}

function output() {
	global $auth_data, $pleb, $roster, $page, $mb, $fields, $prefix, $module;

	roster_header();
  
	if ($_REQUEST['submit']) {

		$reason = 'attending the meeting on '.date('F j, Y', strtotime($_REQUEST['date']));

		for ($i = 0; $i < $fields; $i++) {
      
			$person = "person$i";
      
			$provided = "provided$i";
      
			if ($_REQUEST[$person] <= 0)
        continue;
      
			if (isset($_REQUEST[$provided]))
				$credits = $GLOBALS['meetingProvider'];
			else
				$credits = $GLOBALS['meetingCredits'];

			$awardee = $roster->GetPerson($_REQUEST[$person]);
			if ($awardee->AddCredits($credits, $reason))
				printf('Awarded %d credits to %s.<br />', $credits, htmlspecialchars($awardee->GetName()));
			else
				printf('Error awarding %d credits to %s.<br />', $credits, htmlspecialchars($awardee->GetName()));
      
		}

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
	Date (YYYY-MM-DD): <input type="text" name="date" size=25>
	<?php
	$table = new Table('', true);
  
	$table->StartRow();
	$table->AddHeader('Kabal');
	$table->AddHeader('Person');
	$table->AddHeader('Provided Credits to Underlord?');
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
    
		$table->AddCell("<center><input type=\"checkbox\" name=\"provided$i\" value=\"1\" /></center>");
    
		$table->EndRow();
	}
  
	$table->EndTable();
  
	?>
	<input type="submit" value="Add Meeting Credits" class="button" name="submit">&nbsp;<input type="reset" class="button">
	</form>
	<?php
	admin_footer($auth_data);
}
?>
