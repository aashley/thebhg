<?php
function title() {
    return 'Administration :: General :: Pay Arena Aides';
}

function auth($person) {
    global $auth_data, $hunter, $roster;

    $auth_data = get_auth_data($person);
    $hunter = $roster->GetPerson($person->GetID());
    return $auth_data['rp'];
}

function output() {
    global $arena, $auth_data, $hunter, $page, $roster;
    
    arena_header();

    if ($_REQUEST['aides']) {
		foreach ($_REQUEST['aides'] as $rid=>$credits) {
			$person = $roster->GetPerson($rid);
			$person->AddCredits($credits, 'RP Aide Salary');
		}
	}
	elseif ($_REQUEST['submit']) {
		$startut = parse_date_box('start');
		$endut = parse_date_box('end');
		$tables = array('solo_comissioners', 'dojo_masters', 'commentator', 'mission', 'overseer', 'rangers', 'registrar', 'skippers', 'stewards');
		$bitches = array();
		
		foreach ($tables as $table){
			$bitches[$table] = $arena->GetPayData($startut, $endut, $table);
		}
	    $aides = array();
	    
	    $pp = $endut - $startut;
	    $credits = round(350000*($pp/2678400));
	    
	    foreach ($bitches as $bitch){
		    foreach ($bitch as $pay){
			    if ($pay['end_date'] == 0 && $pay['start_date'] > $startut){
				    $time = $endut - $pay['start_date'];
				    echo '<br />END:'.$endut;
				    echo '<br />START:'.$startut;
				    echo '<br />START DATE:'.$pay['start_date'];
				    echo '<br />TIME:'.$time;
			    } elseif ($pay['end_date'] == 0 && $pay['start_date'] < $startut) {
				    $time = $endut - $startut;
			    } else {
				    if ($pay['start_date'] < $startut){
					    $time = $pay['end_date'] - $startut;
				    } else {
				    	$time = $pay['end_date'] - $pay['start_date'];
			    	}
		    	}
		    	
		    	$time = $time / $pp;
		    	
		    	$creds = round($time * $credits);
		    	
		      	if (isset($aides[$pay['bhg_id']])) {
		        	$aides[$pay['bhg_id']] += $creds;
		      	} else {
		        	$aides[$pay['bhg_id']] = $creds;
		      	}
			}
		}

		$form = new Form($page);
		$form->AddSectionTitle('Arena Aide Salaries');
			foreach ($aides as $rid=>$credits) {
				$hunter = $roster->GetPerson($rid);
				$form->AddTextBox($hunter->GetName(), "aides[$rid]", $credits);
			}
		$form->AddSubmitButton('submit', 'Pay Salaries');
		$form->EndForm();
	}
	else {
		$last_month_start = mktime(0, 0, 0, date('m') - 1, 1, date('Y'));
		$last_month_end = mktime(0, 0, 0, date('m'), 0, date('Y'));
		
		$form = new Form($page);
		$form->AddDateBox('Start Date:', 'start', $last_month_start);
		$form->AddDateBox('End Date:', 'end', $last_month_end);
		$form->AddSubmitButton('submit', 'Calculate Salaries');
		$form->EndForm();
	}

    admin_footer($auth_data);
}
?>