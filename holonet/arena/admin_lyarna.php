<?php
function title() {
    return 'Administration :: Overseer Utilities :: Property Management';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $auth_data, $hunter, $page, $sheet, $roster;

    $lyarna = $arena->LyarnaConnect();
    
    arena_header();

    echo '<a href="' . internal_link($page, array('table'=>'complex')) . '">Complexes</a> | ';
    echo '<a href="' . internal_link($page, array('table'=>'estate')) . '">Estates</a> | ';
    echo '<a href="' . internal_link($page, array('table'=>'hq')) . '">Headquarters</a> | ';
    echo '<a href="' . internal_link($page, array('table'=>'personal')) . '">Personal</a> | ';
    echo '<a href="' . internal_link($page, array('table'=>'other')) . '">Other</a>';

    hr();

    if (isset($_REQUEST['submit'])) {
	    $error = false;
	    for ($i = 0; $i < $_REQUEST['runs']; $i++){
		    if ($_REQUEST['process'.$i]){
			    if ($_REQUEST['position'.$i] > 0){
				    $sets = "`position` = '".$_REQUEST['position'.$i]."', `division` = '".$_REQUEST['kabal'.$i]."'";
			    } elseif ($_REQUEST['person'.$i]) {
				    $sets = "`bhg_id` = '".$_REQUEST['person'.$i]."'";
			    }
			    
			    if ($sets){ 
				    $sql = "UPDATE " . $_REQUEST['table'] . " SET $sets WHERE `id` = '".$_REQUEST['property'.$i]."'";
		            if (!mysql_query($sql, $lyarna)) {
		                $error = true;	                
		            }
	            }
            }
        }
        
        if ($error){
	        NEC(170);
        } else {
	        echo 'System property upgraded.';
        }
    }
    else {
	    if (isset($_REQUEST['table'])){
		    $table = $_REQUEST['table'];
	    } else {
		    $table = 'complex';
	    }
        $form = new Form($page);
        $form->AddHidden('table', $table);
        $locations = mysql_query('SELECT * FROM ' . $table . ' ORDER BY name', $lyarna);        

		$form->table->AddRow('Mod', 'Current Owner', 'Name', 'Listed Owner', 'Division', 'Position', 'Hunter');
		$i = 0;
		
        while ($row = mysql_fetch_array($locations)) {
	        $form->table->StartRow();
	        if ($row['division']){
		        $divi = new Division($row['division']);
		        $position = new Position($row['position']);
		        $owner = $position->GetName().' of '.$divi->GetName();
	        } elseif ($row['bhg_id']){
		        $hunter = new Person($row['bhg_id']);
		        $owner = $hunter->GetName();
	        } else {
		        $owner = 'Not Listed in System';
	        }
	        $form->AddHidden('property'.$i, $row['id']);
		  	$form->table->AddCell('<input type="checkbox" name="process'.$i.'" value=1>');
	        $form->table->AddCell($owner);
	        $form->table->AddCell($row['name']);
	        $form->table->AddCell($row['owner']);
	        $form->table->AddCell("<select name=\"kabal$i\" "
	        ."onChange=\"swap_kabal(this.form, $i)\">"
	        ."<option value=\"-1\">N/A</option>$kabals</select>");

			$form->table->AddCell("<select name=\"position$i\">"
	        ."<option value=\"-1\">N/A</option>$positions</select>");
			$form->table->AddCell('<input type="text" name="person'.$i.'" value=1>');
			$form->table->EndRow();
			$i++;
        }
        $run = $i-1;
        $form->AddHidden('runs', $run);
        $form->table->StartRow();
        $form->table->AddCell('<input type="submit" name="submit" value="Update Properties">', 7);
        $form->table->EndRow();
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>