<?php
function title() {
    return 'Network Error Codes';
}

function output() {
    global $arena, $db;

    arena_header();

   	echo "The NEC is the quality control system of the Arena Network. The NEC is a complete list of all possible errors which may occur within the Arena Network System. These are used for debugging the AMS when problems arise. If you have a problem, please submit the NEC <b>Number</b> only.";
    hr();
    
    $sql = "SELECT * FROM `arena_errors` ORDER BY `id`";
    $query = mysql_query($sql, $db);
    
    $table = new Table('Error Codes', true);
    $table->AddRow('NEC ID', 'Page', 'Error');
    
    while ($info = mysql_fetch_array($query)){
	    $table->AddRow($info['id'], $info['page'], 'Error from '.$info['class'].'() on '.$info['function'].'()');
    }

    $table->EndTable();
    
    hr();
    
    echo '<a href="' . internal_link('admin_nec') . '">Admin</a>';
    
    arena_footer();
}
?>