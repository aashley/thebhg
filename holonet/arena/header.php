<?php
include_once('roster.inc');
include_once('citadel.inc');
include_once('library.inc');
include_once('objects/arena.php');

$arena = new Arena();
$citadel = new Citadel;
$roster = new Roster('fight-51-me');
$mb = new MedalBoard('fight-51-me');
$sheet = new Sheet();

function Overseer(){
	global $roster;
    $search = $roster->SearchPosition('29');
    return (is_object($search[0]) ? $search[0] : false);
}

function Adjunct(){
	global $roster;
    $search = $roster->SearchPosition('9');
    return (is_object($search[0]) ? $search[0] : false);
}

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
	echo '&nbsp;Offline';
}

function atn_nav(){
	echo '&nbsp;Offline';
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

function ah($name){
	echo '<b>'.$name.'</b><br />';
}

function al($page, $name){
	echo '<a href="' . internal_link('admin_'.$page) . '">'.str_replace(' ', '&nbsp;', $name).'</a><br>';
}

$links = array(1=>array('System Admin'=>array('activities'=>'Activities', 'types'=>'Activity Types', 'aides'=>'Aide Positions')));

function links($id){
	global $links;
	foreach ($links[1] as $name=>$data){
		ah($name);
		foreach ($data as $page=>$name){
			al($page, $name);
		}
	}
}

function admin_footer($auth_data) {
	global $roster, $arena, $citadel;
	
	$person = new Person($auth_data['id']);
	$posi = $person->GetPosition();
	
	if ($posi->GetID() == 29) {
		$tests = $citadel->GetExamsMarkedBy(Overseer());
	} elseif ($posi->GetID() == 9){
		$tests = $citadel->GetExamsMarkedBy(Adjunct());
	}
	
	echo '</td><td style="border-left: solid 1px black">';
	
	echo '<small>';
	
	
	
	if ($auth_data['overseer']){
		links(1);
	}

    echo '</small></td></tr></table>';
}

?>