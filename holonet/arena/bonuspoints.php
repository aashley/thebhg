<?php

function Title(){
	return 'Bonus Points';
}

function auth($person) {
    global $hunter, $roster, $auth_data;
    
    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    $div = $person->GetDivision();
    return ($div->GetID() != 0 && $div->GetID() != 16);
}

function Output(){
	global $hunter, $page, $roster, $sheet;
	
	arena_header();
	
	if ($hunter->GetID() || $_REQUEST['id']){
		if ($_REQUEST['id']){
			$id = $_REQUEST['id'];
		} else {
			$id = $hunter->GetID();
		}
		$character = new Character($id);
		
		echo $character->BonusPoints().'<br />';
		
		foreach($character->BonusPoints(true) as $name=>$points){
			echo $name.' => '.$points.'<br />';
		}		
		
	}
    
    arena_footer();
}