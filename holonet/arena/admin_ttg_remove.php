<?php
function title() {
    return 'Administration :: Twilight Gauntlet :: Resign Challenge';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['ttg'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;
    
    arena_header();

    $ttg = new TTG();

	$challenge = '';
    if (isset($_REQUEST['id'])){
    	$challenge = new Challenge($_REQUEST['id']);
	}
	    
    if (is_object($challenge)){
		    
        if (rp_staff($hunter) || $challenge->CanRemove()){
	        if ($challenge->PickUp($_REQUEST['bhg_id'])){
		        echo "Successfully removed as challenger.";
	        } else {
		        NEC(16);
	        }
        } else {
	        echo "Can not be removed as a challenger.";
        }	        
    
    } else {
        
        echo "You are currently not signed up for any challenges in the queue.";
        
    }

    admin_footer($auth_data);
}
?>