<?php
function title() {
    return 'Administration :: Tempestuous Group :: Remove Juror';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['tempy_mod'];
}

function output() {
    global $arena, $auth_data, $hunter, $page;
    
    arena_header();

    $petition = '';
    
	if (isset($_REQUEST['id'])){
		$petition = new Petition($_REQUEST['id']);
	}
	
	if (is_object($petition)){
		    
        if (rp_staff($hunter) || !$petition->Solidified()){
	        if ($petition->RemoveSignUp($_REQUEST['bhg_id'])){
		        echo "Successfully removed as juror.";
	        } else {
		        echo 'Error! <b>Please submit the following error code to the <a href="http://bugs.thebhg.org/">Bug Tracker</a></b><br />NEC Error Code: 40';
	        }
        } else {
	        echo "Can not remove juror.";
        }	        
    
    } else {
        
        echo "Error handling petition.";
        
    }

    admin_footer($auth_data);
}
?>