<?php
include_once('roster.inc');
include_once('sheet.php');
$roster = new Roster('roster-69god');
$mb = new MedalBoard('roster-69god');

function roster_header() {
	echo '<table border=0 width="100%"><tr valign="top"><td width="90%">';
}

function roster_footer($show_list = true, $more_items = false) {
	global $roster;

	if ($show_list == false) {
		echo '</td></tr></table>';
		return;
	}

	echo '</td><td style="border-left: solid 1px black">';

	if ($more_items) {
		echo str_replace(' ', '&nbsp;', $more_items['title']) . '<small><br>';
		foreach ($more_items as $url=>$title) {
			if ($title == '') {
				echo '<br>';
			}
			elseif ($url != 'title') {
				echo "<br><a href=\"$url\">" . str_replace(' ', '&nbsp;', $title) . '</a>';
			}
		}
		echo '</small><br><br>';
	}
	
	echo 'Divisions<small>';
	
	$cats = $roster->GetDivisionCategories();
	foreach ($cats as $dc) {
		echo '<br>';
		$divs = $dc->GetDivisions();
		foreach ($divs as $div) {
			echo '<br><a href="' . internal_link('division', array('id' => $div->GetID())) . '">' . str_replace(' ', '&nbsp;', $div->GetName()) . '</a>';
		}
	}

	echo '</small>';

  $cadres = $roster->GetCadres();

  if ($cadres !== false) {
    
    echo '<br><br>Cadres<small><br>';

    foreach ($cadres as $cadre) {

      echo '<br><a href="' . internal_link('cadre', array('id' => $cadre->GetID())) . '">' . str_replace(' ', '&nbsp;', $cadre->GetName()) . '</a>';

    }

    echo '</small>';

  }
	
  echo '</td></tr></table>';
}

function get_auth_data($pleb) {
	$pos = $pleb->GetPosition();
	$div = $pleb->GetDivision();
  $rank = $pleb->GetRank();
  $baron = new Rank(12);

	$auth_data['id'] = $pleb->GetID();

	if ($pos->GetID() == 2 || $pleb->GetID() == 94 || $pleb->GetID() == 666) {
		$auth_data['underlord'] = true;
		$auth_data['commission'] = true;
		$auth_data['judicator'] = true;
		$auth_data['chief'] = true;
		$auth_data['warden'] = true;
		$auth_data['cs'] = true;
		$auth_data['sysadmin'] = true;
	} else {
		$auth_data['underlord'] = false;
		$auth_data['commission'] = false;
		$auth_data['judicator'] = false;
		$auth_data['chief'] = false;
		$auth_data['warden'] = false;
		$auth_data['cs'] = false;
		$auth_data['sysadmin'] = false;

		if ($div->GetID() == 10 || $div->GetID() == 9) {
			$auth_data['commission'] = true;
		}

		if ($pos->GetID() == 6 || $pos->getID() == 8) {
			$auth_data['judicator'] = true;
		} elseif ($pos->GetID() == 9 || $pos->GetID() == 29) {
			$auth_data['cs'] = true;
		} elseif ($pos->GetID() == 11) {
			$auth_data['chief'] = true;
		} elseif ($pos->GetID() == 10) {
			$auth_data['warden'] = true;
		}

	}
  
  if ($pleb->InCadre()) {
    $auth_data['cadre'] = true;
    if ($pleb->IsCadreLeader()) {
      $auth_data['cadre-leader'] = true;
    } else {
      $auth_data['cadre-leader'] = false;
    }
  } else {
    $auth_data['cadre'] = false;
  }

  if ($rank->GreaterThanOrEqual($baron)) {
    $auth_data['cadre-create'] = true;
  } else {
    $auth_data['cadre-create'] = false;
  }

	return $auth_data;
}

function admin_footer($auth_data) {
	echo '</td><td style="border-left: solid 1px black">Admin&nbsp;Menu<small><br><br>';
	echo '<b>Personal Details</b><br>';
	echo '<a href="' . internal_link('admin_my_details', array()) . '">Edit&nbsp;My&nbsp;Details</a><br>';
	echo '<a href="' . internal_link('admin_change_password', array()) . '">Change&nbsp;My&nbsp;Password</a><br>';
	echo '<a href="' . internal_link('admin_my_ipkc', array()) . '">Edit&nbsp;My&nbsp;IPKC</a><br>';
	echo '<a href="' . internal_link('admin_sheet', array('id'=>$auth_data['id']), 'arena') . '">Edit&nbsp;My&nbsp;Character&nbsp;Sheet</a><br>';
	if ($auth_data['underlord']) {
		echo '<br><b>Underlord&nbsp;Features</b><br>';
		echo '<a href="' . internal_link('admin_pending', array()) . '">Approve&nbsp;Credit&nbsp;Awards</a><br>';
		echo '<a href="' . internal_link('admin_pending_medal', array()) . '">Approve&nbsp;Medal&nbsp;Awards</a><br>';
		echo '<a href="' . internal_link('admin_new_member', array()) . '">New&nbsp;Members</a><br>';
		echo '<a href="' . internal_link('admin_transfer_members', array()) . '">Transfer&nbsp;Members</a><br>';
		echo '<a href="' . internal_link('admin_change_position', array()) . '">Change&nbsp;Positions</a><br>';
		echo '<a href="' . internal_link('admin_change_rank', array()) . '">Change&nbsp;Ranks</a><br>';
		echo '<a href="' . internal_link('admin_declare_awols', array()) . '">Declare&nbsp;AWOLs</a><br>';
		echo '<a href="' . internal_link('admin_approve_awols', array()) . '">Approve&nbsp;AWOLs</a><br>';
		echo '<a href="' . internal_link('admin_empty_uap', array()) . '">Empty&nbsp;Unassigned&nbsp;Pool</a><br>';
		echo '<a href="' . internal_link('admin_flush_wings', array()) . '">Flush&nbsp;Wings</a><br>';
		echo '<a href="' . internal_link('admin_assign_newbs', array()) . '">Assign&nbsp;New&nbsp;Hunters</a><br>';
		echo '<a href="' . internal_link('admin_salaries', array()) . '">Add&nbsp;Salaries</a><br>';
		echo '<a href="' . internal_link('admin_chief_bonus', array()) . '">Add&nbsp;Chief&nbsp;Bonuses</a><br>';
		echo '<a href="' . internal_link('admin_big_red_switch', array()) . '">Add&nbsp;Badges&nbsp;of&nbsp;Supremacy</a><br>';
	}
	if ($auth_data['commission']) {
		echo '<br><b>Commission&nbsp;Features</b><br>';
		echo '<a href="' . internal_link('admin_award', array()) . '">Award&nbsp;Credits</a><br>';
		echo '<a href="' . internal_link('admin_award_medal', array()) . '">Award&nbsp;Medal</a><br>';
		echo '<a href="' . internal_link('admin_email_members', array()) . '">E-Mail&nbsp;Members</a><br>';
		echo '<a href="' . internal_link('admin_add_report', array()) . '">Add Report</a><br>';
		echo '<a href="' . internal_link('admin_edit_report', array()) . '">Edit Report</a><br>';
	}
	if ($auth_data['judicator']) {
		echo '<br><b>Judicator&nbsp;Features</b><br>';
		echo '<a href="' . internal_link('admin_pending', array()) . '">Approve&nbsp;Credit&nbsp;Awards</a><br>';
		echo '<a href="' . internal_link('admin_pending_medal', array()) . '">Approve&nbsp;Medal&nbsp;Awards</a><br>';
		echo '<a href="' . internal_link('admin_chief_bonus', array()) . '">Add&nbsp;Chief&nbsp;Bonuses</a><br>';
		echo '<a href="' . internal_link('admin_big_red_switch', array()) . '">Add&nbsp;Badges&nbsp;of&nbsp;Supremacy</a><br>';
	}
	if ($auth_data['cs']) {
		echo '<br><b>Character&nbsp;Sheet&nbsp;Administration</b><br>';
		echo '<a href="' . internal_link('admin_character_sheet', array()) . '">Edit&nbsp;Character&nbsp;Sheets</a><br>';
		echo '<a href="' . internal_link('admin_manage_mf', array()) . '">Manage&nbsp;Merits&nbsp;&amp;&nbsp;Flaws</a><br>';
		echo '<a href="' . internal_link('admin_add_xp', array()) . '">Add&nbsp;Experience&nbsp;Points</a><br>';
	}
  // Cadre Admin functions only to barons and above, cadre application and
  // leave options to everyone
  echo '<br><b>Cadre Features</b><br>';
  if ($auth_data['cadre']) {

    if ($auth_data['cadre-leader']) {

      echo '<a href="' . internal_link('admin_cadre_edit', array()) . '">Edit&nbsp;Cadre&nbsp;Details</a><br>'
        .'<a href="'.internal_link('admin_cadre_buy_members', array()).'">Manage&nbsp;Membership</a><br>'
        .'<a href="'.internal_link('admin_cadre_close', array()).'">Close&nbsp;Cadre</a><br>';

    } else {

      echo '<a href="'.internal_link('admin_cadre_leave', array()).'">Leave&nbsp;Cadre</a><br>';

    }

  } else {

    if ($auth_data['cadre-create']) {
      
      // Person is not in a cadre and has permission to create new ones
      echo '<a href="' . internal_link('admin_cadre_create', array()) . '">Create&nbsp;Cadre</a><br>';

    } else {
      
      // Not in a cadre and cant create one

    }

    echo '<a href="' . internal_link('admin_cadre_apply', array()) . '">Apply&nbsp;to&nbsp;Cadre</a><br>';

  }
	if ($auth_data['chief']) {
		echo '<br><b>Chief&nbsp;Features</b><br>';
		echo '<a href="' . internal_link('admin_award', array()) . '">Award&nbsp;Credits</a><br>';
		echo '<a href="' . internal_link('admin_award_medal', array()) . '">Award&nbsp;Medal</a><br>';
		echo '<a href="' . internal_link('admin_edit_kabal', array()) . '">Edit&nbsp;Kabal&nbsp;Details</a><br>';
		echo '<a href="' . internal_link('admin_upload_kabal_logo', array()) . '">Upload&nbsp;New&nbsp;Kabal&nbsp;Logo</a><br>';
		echo '<a href="' . internal_link('admin_declare_awols', array()) . '">Declare&nbsp;AWOLs</a><br>';
		echo '<a href="' . internal_link('admin_email_members', array()) . '">E-Mail&nbsp;Members</a><br>';
		echo '<a href="' . internal_link('admin_add_report', array()) . '">Add Report</a><br>';
		echo '<a href="' . internal_link('admin_edit_report', array()) . '">Edit Report</a><br>';
		echo '<a href="http://ka.thebhg.org/manuals/admin_form.php">Chief Manual</a><br>';
	}
	if ($auth_data['warden']) {
		echo '<br><b>Warden&nbsp;Features</b><br>';
		echo '<a href="' . internal_link('admin_award', array()) . '">Award&nbsp;Credits</a><br>';
		echo '<a href="' . internal_link('admin_award_medal', array()) . '">Award&nbsp;Medal</a><br>';
		echo '<a href="' . internal_link('admin_email_members', array()) . '">E-Mail&nbsp;Members</a><br>';
		echo '<a href="' . internal_link('admin_add_report', array()) . '">Add Report</a><br>';
		echo '<a href="' . internal_link('admin_edit_report', array()) . '">Edit Report</a><br>';
		echo '<a href="http://ka.thebhg.org/manuals/admin_form.php">Warden Manual</a><br>';
	}
	if ($auth_data['sysadmin']) {
		echo '<br><b>System&nbsp;Administration</b><br>';
		echo '<a href="' . internal_link('admin_add_rank', array()) . '">Create&nbsp;New&nbsp;Rank</a><br>';
//		echo '<a href="' . internal_link('admin_edit_rank', array()) . '">Edit&nbsp;Existing&nbsp;Rank</a><br>';
		echo '<a href="' . internal_link('admin_add_position', array()) . '">Create&nbsp;New&nbsp;Position</a><br>';
//		echo '<a href="' . internal_link('admin_edit_position', array()) . '">Edit&nbsp;Existing&nbsp;Position</a><br>';
//		echo '<a href="' . internal_link('admin_create_division_category', array()) . '">Create&nbsp;New&nbsp;Category&nbsp;of&nbsp;Divisions</a><br>';
		echo '<a href="' . internal_link('admin_edit_division_category', array()) . '">Edit&nbsp;Existing&nbsp;Category&nbsp;of&nbsp;Divisions</a><br>';
		echo '<a href="' . internal_link('admin_create_division', array()) . '">Create&nbsp;New&nbsp;Division</a><br>';
		echo '<a href="' . internal_link('admin_edit_division', array()) . '">Edit&nbsp;Existing&nbsp;Division</a><br>';
		echo '<a href="' . internal_link('admin_delete_division', array()) . '">Delete&nbsp;Existing&nbsp;Division</a><br>';
//		echo '<a href="' . internal_link('admin_edit_settings', array()) . '">Edit&nbsp;System&nbsp;Settings</a>';
	}
	echo '</small></td></tr></table>';
}

function show_search_form() {
	$form = new Form('dosearch', 'post');
	$form->AddTextBox('Search For:', 'searchfor', '', 30);
	$form->StartSelect('Search On:', 'searchtype', 'searchname');
	$form->AddOption('searchid', 'ID Number');
	$form->AddOption('searchname', 'Name');
	$form->AddOption('searchemail', 'E-Mail Address');
	$form->AddOption('searchircnick', 'IRC Nick');
	$form->AddOption('searchposition', 'Position');
	$form->AddOption('searchrank', 'Rank');
	$form->EndSelect();
	$form->AddCheckBox('Include Disavowed:', 'disavowed', 'on');
	$form->AddSubmitButton('search', 'Search');
	$form->EndForm();
}

// Now some general ACC functions.
$email_headers = <<<EOH
X-Sender: Arena Challenge Centre <acc@thebhg.org>
Return-Path: Arena Challenge Centre <acc@thebhg.org>
From: Arena Challenge Centre <acc@thebhg.org>
X-Mailer: PHP
EOH;

$lyarna_db = mysql_connect("localhost", "thebhg_lyarna", "lyarnasys55");
mysql_select_db('thebhg_lyarna', $lyarna_db);

function acc_footer() {
	menu_sep();
	echo 'ACC&nbsp;Admin<small><br><br>';
	echo '<a href="' . internal_link('acc_admin_pending') . '">View&nbsp;Pending&nbsp;Challenges</a><br>';
	echo '<a href="' . internal_link('acc_admin_recent') . '">View&nbsp;Recent&nbsp;Challenges</a><br>';
	echo '<a href="' . internal_link('acc_admin_locations', array('table'=>'complex')) . '">Add/Remove&nbsp;Locations</a><br>';
/*	echo '<a href="' . internal_link('acc_admin_rules') . '">Edit&nbsp;Rules</a><br>';
	echo '<a href="' . internal_link('acc_admin_weapons') . '">Edit&nbsp;Weapon&nbsp;Types</a>';*/
	echo '</small>';
	menu_footer();
}
?>
