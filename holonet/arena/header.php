<?php
include_once('roster.inc');
include_once('objects/arena.inc');
include_once('library.inc');
include_once('citadel.inc');

$roster = new Roster('fight-51-me');
$mb = new MedalBoard('fight-51-me');

function arena_header() {
    echo '<table border=0 width="100%"><tr valign="top"><td width="90%">';
}

function coders(){
	return array(2650);
}

function rp_staff($person){
	$position = $person->GetPosition();
	return ($position->GetID() == 9 || $position->GetID() == 29 || $person->GetID() == 2650);
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
	
}

function atn_nav(){
	
}

function arena_footer($show_list = true) {
    global $roster, $arena, $library;
    
    $shelf = new Shelf(6);

    if ($show_list == false) {
        echo '</td></tr></table>';
        return;
    }

    echo '</td><td style="border-left: solid 1px black">';

    echo '<u>AMS Challenge Netowrk</u><small><br />';

    echo '&nbsp;<a href="' . internal_link('acn_challenge') . '">Network&nbsp;Control</a><br />';

    echo '</small>';
    
    echo '<br /><u>AMS Tracking Network</u><small><br />';

    atn_nav();
    
    echo '<br /><u>Arena Manuals</u><small><br />';
    
    $shelf_title = str_replace(' ', '&nbsp;', $shelf->GetName());
	echo '&nbsp;<a href="' . internal_link('shelf', array('id'=>$shelf->GetID()), 'library') . '">' . $shelf_title . '</a><small>';
	foreach ($shelf->GetBooks() as $book) {
		echo '<br />';
		$title = str_replace(' ', '&nbsp;', $book->GetTitle());
		echo '&nbsp;&nbsp;<a href="' . internal_link('book', array('id'=>$book->GetID()), 'library') . '">' . $title . '</a>';
	}
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
        $auth_data['solo'] = true;
        $auth_data['tempy'] = true;
        $auth_data['elite'] = true;
        $auth_data['tempy_mod'] = true;   
        $auth_data['lw'] = true;   
        $auth_data['citadel'] = true;
        $auth_data['star'] = true;
        $auth_data['dojo'] = true;
        $auth_data['sheet'] = true;
        $auth_data['ro'] = true;
        $auth_data['aa'] = true;
        $auth_data['arena'] = true;
        $auth_data['irc'] = true;
        $auth_data['survival'] = true;
        $auth_data['ch'] = true;
    } else {
        $auth_data['rp'] = false;
        $auth_data['solo'] = false;
        $auth_data['tempy'] = false;
        $auth_data['elite'] = false;
        $auth_data['tempy_mod'] = false; 
        $auth_data['lw'] = false;  
        $auth_data['citadel'] = false;
        $auth_data['star'] = false; 
        $auth_data['dojo'] = false;  
        $auth_data['sheet'] = false; 
        $auth_data['ro'] = false; 
        $auth_data['aa'] = false;
        $auth_data['arena'] = false;
        $auth_data['irc'] = false;
        $auth_data['survival'] = false;
        $auth_data['ch'] = false;
    }
    
    return $auth_data;
}

function admin_footer($auth_data) {
	
	echo '</td><td style="border-left: solid 1px black">';
	
	echo '<small>';
	echo '<br /><b>External Links</b><br />';
	echo '&nbsp;<a href="' . internal_link('atn_general', array('id'=>$person->GetID())) . '">View&nbsp;My&nbsp;Profile</a><br />';
	echo '&nbsp;<a href="' . internal_link('acn_challenge', array('id'=>$person->GetID())) . '">Network&nbsp;Control</a><br />';
	echo '<br /><b>Hunter Options</b><br />';
	echo '&nbsp;<a href="' . internal_link('admin_sheet', array('id'=>$person->GetID())) . '">Edit&nbsp;My&nbsp;Sheet</a><br />';
	echo '&nbsp;<a href="' . internal_link('admin_sheet_backup', array('id'=>$person->GetID())) . '">Sheet&nbsp;Saves&nbsp;and&nbsp;Cores</a><br />';
	echo '&nbsp;<a href="' . internal_link('admin_sheet_core') . '">Edit&nbsp;Core&nbsp;Sheets</a><br />';

    echo '</small></td></tr></table>';
}

?>