<?php
function title() {
    return 'Administration :: General :: Edit Arena Locations';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $auth_data, $hunter, $page, $contract;

    $lyarna = $arena->LyarnaConnect();
    
    arena_header();

    echo '<a href="' . internal_link($page, array('table'=>'complex')) . '">Complexes</a> | ';
    echo '<a href="' . internal_link($page, array('table'=>'estate')) . '">Estates</a> | ';
    echo '<a href="' . internal_link($page, array('table'=>'hq')) . '">Headquarters</a> | ';
    echo '<a href="' . internal_link($page, array('table'=>'personal')) . '">Personal</a> | ';
    echo '<a href="' . internal_link($page, array('table'=>'other')) . '">Other</a>';

    hr();

    if (isset($_REQUEST['submit'])) {
        if (isset($_REQUEST['locations'])) {
            if (mysql_query('UPDATE ' . $_REQUEST['table'] . ' SET arena=1 WHERE id IN (' . implode(', ', $_REQUEST['locations']) . ')', $lyarna) && mysql_query('UPDATE ' . $_REQUEST['table'] . ' SET arena=0 WHERE id NOT IN (' . implode(', ', $_REQUEST['locations']) . ')', $lyarna)) {
                echo 'Saved location list.';
            }
            else {
                NEC(66);
            }
        }
        else {
            if (mysql_query('UPDATE ' . $_REQUEST['table'] . ' SET arena=0', $lyarna)) {
                echo 'Saved location list.';
            }
            else {
                NEC(67);
            }
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
        $locations = mysql_query('SELECT id, name, arena FROM ' . $table . ' ORDER BY name', $lyarna);
        echo mysql_error();
        while ($row = mysql_fetch_array($locations)) {
            $form->AddCheckBox(stripslashes($row['name']), 'locations[]', $row['id'], $row['arena']);
        }
        $form->AddSubmitButton('submit', 'Update List');
        $form->EndForm();
    }

    admin_footer($auth_data);
}
?>