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
    global $arena, $auth_data, $hunter, $page, $sheet, $roster;

    arena_header();
    
    if (isset($_REQUEST['submit'])) {
	    $character = new Character($_REQUEST['bhg_id']);
		if ($character->IsNew()){
			if (!$character->NewSheet()){
				NEC(158);
				admin_footer($auth_data);
				return;
			} else {
				echo 'Sheet created.';
			}
		} else {
			echo 'Character has a sheet.';
		}
    }
    else {
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
		
	<?
		$form = new Form($page);
    	$form->AddSectionTitle('Make Blank Sheet');
        $form->table->StartRow();
        $form->table->AddCell("<select name=\"kabal\" "
        ."onChange=\"swap_kabal(this.form)\">"
        ."<option value=\"-1\">N/A</option>$kabals</select>");
	
	    $cell = "<select name=\"bhg_id\">";
	    
		$cell .= "<option value=\"-1\" selected>N/A</option>\n";

		$cell .= "</select>";
    
		$form->table->AddCell($cell);

		$form->table->EndRow();
        $form->AddSubmitButton('submit', 'Insert Blank into AMS');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>