	<?php
include_once('roster.inc');
include_once('citadel.inc');
include_once('library.inc');
include_once('objects/arena.php');

$arena = new Arena();
$citadel = new Citadel();
$roster = new Roster('fight-51-me');
$mb = new MedalBoard('fight-51-me');
$sheet = new Sheet();

function Strategist(){
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
	return array(94, 2650);
}

function mb_link($id){
	return "<a href='http://boards.thebhg.org/Topic/$id'>$id</a>";
}

function linky($id){
	return "http://boards.thebhg.org/Topic/$id";
}

function from(){
	return 'arena@thebhg.org';
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
	addMenu('Challenge Network', array('View Activities'=>internal_link('acn')));
}

function atn_nav(){
	global $roster, $arena;
	
	$cats = $roster->GetDivisionCategories();
	$app = array();
    foreach ($cats as $dc) {
        $divs = $dc->GetDivisions();
        foreach ($divs as $div) {
	        if ($div->GetID() != 16){
            	$app[$div->GetName()] = internal_link('atn_division', array('id' => $div->GetID()));
        	}
        }
    }
    addMenu('Divisions', $app);
    
    $lists = array();
    $activities = array();

    $tables = array(1=>'ams_activities', 0=>'ams_list_types');
    foreach ($tables as $id=>$table){
	    $app = array();
    	$gblname = '';
	    $gblname = ($id ? 'Activities' : 'Lists');
	    foreach ($arena->Search(array('table'=>$table, 'search'=>array('date_deleted'=>'0'))) as $axs){		    
		    if ($id){
			    $app[$axs->Get('name')] = internal_link('atn_activity', array('id'=>$axs->Get('id')));
	    	} else {
		    	$app[$axs->Get('name')] = internal_link('atn_list', array('id'=>$axs->Get('id')));
	    	}
	    }
	    addMenu($gblname, $app);
    }
}

function arena_footer() {
    global $roster, $arena;

    acn_nav();

    atn_nav();

  echo '</td></tr></table>';
}

$links = array(1=>array('System Admin'=>array('activities'=>'Activities', 'types'=>'Activity Types', 'aides'=>'Aide Positions', 'specifics'=>'Event Specifics',
		'rulegrade'=>'Rules and Grades', 'access'=>'System Access', 'builder'=>'Event Builder', 'lists'=>'Member Lists', 'restrict'=>'Activity Restrictions',
		'mod'=>'Add CS Modifcation', 'mod_mod'=>'Modify CS Modifcation', 'mod_ss'=>'Modify Mod Skill/Stats')));

$links[2] = array('Management'=>array('hr'=>'Manage Aides', 'location'=>'Arena Locations', 'approve_xp'=>'Approve CH XP', 'salaries'=>'Compile Salaries'));

$links[5] = array('Activities'=>array());

$links[11] = array('Aide Functions'=>array('npc'=>'Generate NPC', 'xp'=>'Experience Points'));

$links[6] = array('List Management'=>array());

$links[3] = array('Character Sheets'=>array('sheet_list'=>'Edit Character Sheets', 'cas'=>'Manage Character Attributes'));
				
$links[4] = array('Character Sheet Admin'=>array('field'=>'Create New Field', 'stat'=>'Create New Statribute', 
				'skill'=>'Create New Skill', 'equation'=>'Create New Variable', 'sheet_ss'=>'Modify Shown Stats', 
				'sheet_fo'=>'Modify Field Order', 'ca'=>'Create Character Attribute', 'ca_stats'=>'Attribute Stat Modifier', 
				'edit_ca'=>'Edit Character Attribute'));			 

$links[9] = array('Strategist Utilities'=>array('creds'=>'Award Credits', 'lyarna'=>'Property Management', 'bp'=>'Bonus Points', 'demerit'=>'Demerit Points', 'backup_manage'=>'Manage Backups'));

$links[10] = array('Chief Functions'=>array('npc'=>'Generate NPC', 'xp'=>'Experience Points'));

function get_auth_data($hunter) {
	global $lists, $activities, $arena;
    $pos = $hunter->GetPosition();
    $div = $hunter->GetDivision();

    $auth_data['id'] = $hunter->GetID();

    if ($hunter->GetID() == 2650){
	    $auth_data['coder'] = true;
	    $auth_data['sheet'] = true;
    } else {
	    $auth_data['coder'] = false;
	    $auth_data['sheet'] = false;
    }
    
    if ($pos->GetID() == 29 || $hunter->GetID() == 2650 || $pos->GetID() == 2){
	    $auth_data['coder'] = true;
    	$auth_data['overseer'] = true;
    	$auth_data['sheet'] = true;
    	$auth_data['ch'] = true;
	} else {
		$auth_data['overseer'] = false;
		$auth_data['ch'] = false;
	}
	
	if ($pos->GetID() == 11 || $pos->GetID() == 10 || $pos->GetID() == 12){
    	$auth_data['ch'] = true;
	}
    
	$list = false;
    $aide = false;
    
    $lists = array();
    $activities = array();
    $acts = array();
    $listy = array();
    
    $search = $arena->Search(array('table'=>'ams_aides', 'search'=>array('end_date'=>'0', 'bhg_id'=>$hunter->GetID())));
    foreach ($search as $obj){
	    $access = $arena->Search(array('table'=>'ams_access', 'search'=>array('date_deleted'=>'0', 'aide'=>$obj->Get('aide'))));
	    foreach ($access as $axs){
		    $ac = new Obj('ams_activities', $axs->Get('activity'), 'holonet');
		    if (!$ac->Get('date_deleted')){
			    if (!$aide){
				    $aide = true;
			    }
			    if ($axs->Get('list')){
				    $li = new Obj('ams_list_types', $axs->Get('list'), 'holonet');
				    if (!$li->Get('date_deleted') && !$list){
					    $list = true;
				    }
				    $lists[] = $li;
			    }
			    $activities[] = $ac;
		    }
	    }
    }
    
    $auth_data['aide'] = $aide;
    $auth_data['list'] = $list;
    
    if ($pos->GetID() == 9 || $pos->GetID() == 29 || $hunter->GetID() == 2650) {
        $auth_data['rp'] = true;
        $auth_data['aide'] = true;
        $auth_data['list'] = true;
        $auth_data['sheet'] = true;
        $auth_data['coder'] = true;
        $activities = $arena->Search(array('table'=>'ams_activities', 'search'=>array('date_deleted'=>'0')));
		$lists = $arena->Search(array('table'=>'ams_list_types', 'search'=>array('date_deleted'=>'0')));
    } else {
        $auth_data['rp'] = false;
        $auth_data['sheet'] = false;
    }
    
    $auth_data['lists'] = array();
    $auth_data['activities'] = array();
    
    if ($arena->Sheetie($hunter->GetID())){
	    $auth_data['sheet'] = true;
    }
    foreach($lists as $list){
	    $auth_data['lists'][] = $list->Get('id');
    }
    foreach($activities as $act){
	    $auth_data['activities'][] = $act->Get('id');
    }
    
    return $auth_data;
}

function links($id){
	global $links;
	$app = array();
	$glbname = '';
	foreach ($links[$id] as $name=>$data){
		$glbname = $name;
		foreach ($data as $page=>$name){
			$app[$name] = internal_link('admin_'.$page);
		}
	}
	addMenu($glbname, $app);
}

function external($auth_data){
	$app = array();
	$app['Pending Challenges'] = internal_link('acn');
	$app['My Profile'] = internal_link('atn_general', array('id'=>$auth_data['id']));
	addMenu('External Links', $app);
}

function idlink($id){
	global $links;
	$app = array();
	$glbname = '';
	foreach ($links[$id] as $name=>$data){
		$glbname = $name;
		foreach ($data as $page=>$blurb){
			foreach ($blurb as $id=>$stuff){
				foreach ($stuff as $idn=>$name){
					if (!$idn){
						$idn = 'id';
					}
					$app[$name] = internal_link('admin_'.$page, array($idn=>$id));
				}
			}
		}
	}
	addMenu($glbname, $app);
}

function admin_footer($auth_data) {
	global $roster, $arena, $citadel, $activities, $lists, $links;
	
	$links[7] = array('Hunter Options'=>array('sheet'=>array($auth_data['id']=>array('bhg_id'=>'Edit My Sheet')), 'sheet_backup'=>array($auth_data['id']=>array('bhg_id'=>'Saves and Backups'))));
	
	$person = new Person($auth_data['id']);
	$posi = $person->GetPosition();
	
	if ($posi->GetID() == 29) {
		$tests = $citadel->GetExamsMarkedBy(Strategist());
	} elseif ($posi->GetID() == 9){
		$tests = $citadel->GetExamsMarkedBy(Adjunct());
	} elseif ($person->GetID() == 94){
		$tests = $citadel->GetExamsMarkedBy(94);
	}
	
	external($auth_data);
	
	idlink(7);
	
	if ($auth_data['ch']){
		links(10);
	}
	
	if ($auth_data['coder']){
		links(1);
	}
	
	if ($auth_data['overseer']){
		links(9);
	}
	
	if ($auth_data['rp']){
		
		if (is_array($tests)){
			$app = array();		
		    foreach ($tests as $value){
			    $app[$value->CountPending().' '.$value->GetAbbrev().' exams.'] = 'http://citadel.thebhg.org/admin/grade/'. $value->GetAbbrev();
		    }
			addMenu('Pending&nbsp;Citadel&nbsp;Exams', $app);
		}
		
		links(2);
	}
	
	if ($auth_data['sheet']){
		links(3);
		links(4);
	}
	
	if ($auth_data['aide']){
		if (count($activities)) { 
			$app = array();
			foreach ($activities as $obj){
				$app[$obj->Get('name')] = internal_link('admin_activity', array('id'=>$obj->Get('id')));
			}
			addMenu('Activities', $app);
			
			links(11);
		}
	}
	
	if ($auth_data['list']){
		if (count($lists)) { 
			$app = array();
			foreach ($lists as $obj){
				$app[$obj->Get('name')] = internal_link('admin_list', array('id'=>$obj->Get('id')));
			}
			addMenu('Member Lists', $app);
		}
	}

    echo '</td></tr></table>';
}

?>
