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
    
    $lyarna =& $arena->lyarna;
    
    mysql_select_db('thebhg_lyarna', $lyarna);
    
    arena_header();

    echo '<a href="' . internal_link($page, array('table'=>'complex')) . '">Complexes</a> | ';
    echo '<a href="' . internal_link($page, array('table'=>'estate')) . '">Estates</a> | ';
    echo '<a href="' . internal_link($page, array('table'=>'hq')) . '">Headquarters</a> | ';
    echo '<a href="' . internal_link($page, array('table'=>'personal')) . '">Personal</a> | ';
    echo '<a href="' . internal_link($page, array('table'=>'other')) . '">Other</a>';

    hr();
	
    if (isset($_REQUEST['submit'])) {
	    $error = false;
	    if ($_REQUEST['position'] > 0){
		    $sets = "`position` = '".$_REQUEST['position']."', `division` = '".$_REQUEST['division']."', `bhg_id` = '0'";
	    } elseif ($_REQUEST['bhg_id']) {
		    $sets = "`bhg_id` = '".$_REQUEST['bhg_id']."', `position` = '0', `division` = '0'";
	    }
	    
	    if ($sets){ 
		    $sql = "UPDATE " . $_REQUEST['table'] . " SET $sets WHERE `id` = '".$_REQUEST['property']."'";
            if (!mysql_query($sql, $lyarna)) {
                $error = true;	                
            }
        }
        
        if ($error){
			echo 'Error';
        } else {
	        echo 'System property upgraded.';
        }
    }
    elseif (isset($_REQUEST['property'])) {
	    $form = new Form($page);
	    foreach ($_REQUEST['property'] as $id=>$ex){
		    $form->AddSectionTitle('Set Owner for '.$_REQUEST['name'.$id]);
		    $GLOBALS['property'] = true;
		    include_once 'search.php';
		    $form->StartSelect('Position', 'position');
		    $form->AddOption(0, 'N/A');
		    foreach ($roster->GetPositions() as $position){
			    $form->AddOption($position->GetID(), $position->GetName());
		    }
		    $form->EndSelect();
		    $form->StartSelect('Division', 'division');
		    $form->AddOption(0, 'N/A');
		    foreach ($roster->GetDivisions() as $position){
			    $form->AddOption($position->GetID(), $position->GetName());
		    }
		    $form->EndSelect();
		    $form->AddHidden('table', $_REQUEST['table'.$id]);
		    $form->AddHidden('property', $_REQUEST['prop'.$id]);
	    }
	    $form->AddSubmitButton('submit', 'Submit');
	    $form->EndForm();
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
		$form->table->AddRow('Current Owner', 'Name', 'Listed Owner', '&nbsp');
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
		        $owner = '<b>Not Listed in System</b>';
	        }
	        $form->AddHidden('prop'.$i, $row['id']);
	        $form->AddHidden('name'.$i, $row['name']);
	        $form->AddHidden('table'.$i, $table);
	        $form->table->AddCell($owner);
	        $form->table->AddCell($row['name']);
	        $form->table->AddCell($row['owner']);
			$form->table->AddCell('<input type="submit" name="property['.$i.']" value="Edit">');
			$form->table->EndRow();
			$i++;
        }
        $form->EndForm();
    }

    mysql_select_db('thebhg_holonet', $lyarna);
    
    admin_footer($auth_data);
}
?>