<?php
include_once('roster.inc');
include_once('citadel.inc');
include_once('library.inc');
include_once('objects/arena.php');

$arena = new Arena();
$citadel = new Citadel;
$roster = $arena->roster;
$mb = $arena->mb;
$sheet = new Sheet();

function arena_header() {
    echo '<table border=0 width="100%"><tr valign="top"><td width="90%">';
}

function coders(){
	return array(2650);
}

function NEC($error){
	global $arena;
	echo $arena->NEC($error);
}

function next_medal($person, $group) {
	global $mb;

	$mg = $mb->GetMedalGroup($group);
	if ($mg->GetDisplayType() != 0) {
		echo 'Numeric medal, leaving immediately.<br>';
		$medals = $mg->GetMedals();
		return $medals[0];
	}
	
	$medals = $person->GetMedals();
	if (count($medals)) {
		$orders = array();
		$group_medals = $mg->GetMedals();
		foreach ($group_medals as $medal) {
			$orders[$medal->GetOrder()] = 0;
		}
		foreach ($medals as $am) {
			$medal = $am->GetMedal();
			$mgroup = $medal->GetGroup();
			if ($mgroup->GetID() == $group) {
				$orders[$medal->GetOrder()]++;
			}
		}
		ksort($orders);
		$last = 0;
		foreach ($orders as $key=>$o) {
			if ($o < $last) {
				$order = $key;
				break;
			}
			$last = $o;
		}
		if (empty($order)) {
			$order = min(array_keys($orders));
		}
		
		$medals = $mg->GetMedals();
		foreach ($medals as $medal) {
			if ($medal->GetOrder() == $order) {
				return $medal;
			}
		}
		return $medals[0];
	}
	else {
		$medals = $mg->GetMedals();
		return $medals[0];
	}
}

function acn_nav(){
	echo 'Offline';
}

function atn_nav(){
	echo 'Offline';
}

function arena_footer($show_list = true) {
    global $roster, $arena;

    if ($show_list == false) {
        echo '</td></tr></table>';
        return;
    }

    echo '</td><td style="border-left: solid 1px black">';

    echo '<small><u>Challenge Netowrk</u><br />';

    echo '&nbsp;Offline';
    
    echo '<br /><u>Tracking Network</u><br />';

    atn_nav();
    
	echo '</small>';

  echo '</td></tr></table>';
}

function get_auth_data($hunter) {
    $pos = $hunter->GetPosition();
    $div = $hunter->GetDivision();

    $auth_data['id'] = $hunter->GetID();

    if ($hunter->GetID() == 2650){
	    $auth_data['coder'] = true;
	    $auth_data['cadre'] = true;
    } else {
	    $auth_data['coder'] = false;
	    $auth_data['cadre'] = false;
    }
    
    if ($pos->GetID() == 29 || $hunter->GetID() == 2650){
    	$auth_data['overseer'] = true;
	} else {
		$auth_data['overseer'] = false;
	}
    
    if ($pos->GetID() == 9 || $pos->GetID() == 29 || $hunter->GetID() == 2650) {
        $auth_data['rp'] = true;
    } else {
        $auth_data['rp'] = false;
    }
    
    $cadre = $hunter->GetCadre();
    $auth_data['cadre'] = false;
    if ($cadre){
	    if ($hunter->IsCadreLeader($cadre)){
		    $auth_data['cadre'] = true;
	    }
    }
    
    return $auth_data;
}

function admin_footer($auth_data) {
	global $roster, $arena, $citadel;
	
	$person = new Person($auth_data['id']);
	$posi = $person->GetPosition();
	
	if ($posi->GetID() == 29) {
		$tests = $citadel->GetExamsMarkedBy($arena->Overseer());
	} elseif ($posi->GetID() == 9){
		$tests = $citadel->GetExamsMarkedBy($arena->Adjunct());
	}
	
	echo '</td><td style="border-left: solid 1px black">';
	
	echo '<small>';
	
	echo '<br />System Offline';

    echo '</small></td></tr></table>';
}

?>