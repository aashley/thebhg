<?php
include_once('roster.inc');
include_once('sheet.php');
$roster = new Roster('roster-69god');
$mb = new MedalBoard('roster-69god');

function roster_header() {
}

function roster_footer($show_list = true, $more_items = false) {
	global $roster;

	if ($show_list == false) {
		return;
	}

	if ($more_items) {
		$items = array();
		foreach ($more_items as $url=>$title) {
			$items[$title] = $url;
		}
		addMenu($more_items['title'], $items);
	}
	
	$items = array();
	$cats = $roster->GetDivisionCategories();
	foreach ($cats as $dc) {
		$divs = $dc->GetDivisions();
		foreach ($divs as $div) {
			$items[$div->getName()] = internal_link('division', array('id' => $div->GetID()));
		}
	}
	addMenu('Divisions', $items);

  $cadres = $roster->GetCadres();
  if ($cadres !== false) {
		$items = array();
    foreach ($cadres as $cadre) {
			$items[$cadre->getName()] = internal_link('cadre', array('id' => $cadre->GetID()));
    }
		addMenu('Cadres', $items);
  }
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
	addMenu('Personal Details',
			array('Edit My Details' => internal_link('admin_my_details', array()),
				'Change My Password' => internal_link('admin_change_password', array()),
				'Edit My IPKC' => internal_link('admin_my_ipkc', array())));
	
	if ($auth_data['underlord']) {
		addMenu('Underlord: Awards',
			array('Approve Credit Awards' => internal_link('admin_pending', array()),
			      'Approve Medal Awards' => internal_link('admin_pending_medal', array()),
			      'Directly Award Credits' => internal_link('admin_direct_credits', array()),
			      'Directly Award Medals' => internal_link('admin_direct_medals', array()),
			      'Add Meeting Credits' => internal_link('admin_meeting', array()),
			      'Add Salaries' => internal_link('admin_salaries', array()),
			      'Add Chief Bonuses' => internal_link('admin_chief_bonus', array())));

		addMenu('Underlord: AWOLs/UAP',
			array('Declare AWOLs' => internal_link('admin_declare_awols', array()),
			      'Approve AWOLs' => internal_link('admin_approve_awols', array()),
			      'Empty Unassigned Pool' => internal_link('admin_empty_uap', array())));

		addMenu('Underlord: Citadel',
			array('New Members' => internal_link('admin_new_member', array()),
			      'Flush Wings' => internal_link('admin_flush_wings', array()),
			      'Assign New Hunters' => internal_link('admin_assign_newbs', array())));
		
		addMenu('Underlord: Moves',
			array('Transfer Members' => internal_link('admin_transfer_members', array()),
			      'Change Positions' => internal_link('admin_change_position', array()),
			      'Change Ranks' => internal_link('admin_change_rank', array())));
		
		addMenu('Underlord: Miscellaneous',
			array('Edit Hunter Details' => internal_link('admin_their_details', array())));
	}

	if ($auth_data['commission']) {
		addMenu('Commission Features',
				array('Award Credits' => internal_link('admin_award', array()),
					'Award Medal' => internal_link('admin_award_medal', array()),
					'E-Mail Members' => internal_link('admin_email_members', array()),
					'Add Report' => internal_link('admin_add_report', array()),
					'Edit Report' => internal_link('admin_edit_report', array())));
	}
	
	if ($auth_data['judicator']) {
		addMenu('Kabal Authority Features',
				array('Approve Credit Awards' => internal_link('admin_pending', array()),
					'Approve Medal Awards' => internal_link('admin_pending_medal', array()),
					'Add Chief Bonuses' => internal_link('admin_chief_bonus', array()),
					'Add Badges of Sumpremacy' => internal_link('admin_big_red_switch', array())));
	}
	
/*	if ($auth_data['cs']) {
		echo '<br><b>Character&nbsp;Sheet&nbsp;Administration</b><br>';
		echo '<a href="' . internal_link('admin_character_sheet', array()) . '">Edit&nbsp;Character&nbsp;Sheets</a><br>';
		echo '<a href="' . internal_link('admin_manage_mf', array()) . '">Manage&nbsp;Merits&nbsp;&amp;&nbsp;Flaws</a><br>';
		echo '<a href="' . internal_link('admin_add_xp', array()) . '">Add&nbsp;Experience&nbsp;Points</a><br>';
	}*/

  // Cadre Admin functions only to barons and above, cadre application and
  // leave options to everyone
	$items = array();
  if ($auth_data['cadre']) {

    if ($auth_data['cadre-leader']) {

			$items['Edit Cadre Details'] = internal_link('admin_cadre_edit', array());
			$items['E-mail Cadre Members'] = internal_link('admin_cadre_email', array());
      $items['Manage Membership'] = internal_link('admin_cadre_buy_members', array());
      $items['Close Cadre'] = internal_link('admin_cadre_close', array());

    } else {

      $items['Leave Cadre'] = internal_link('admin_cadre_leave', array());

    }

  } else {

    if ($auth_data['cadre-create']) {
      
      // Person is not in a cadre and has permission to create new ones
      $items['Create Cadre'] = internal_link('admin_cadre_create', array());

    } else {
      
      // Not in a cadre and cant create one

    }

    $items['Apply to Cadre'] = internal_link('admin_cadre_apply', array());

  }
	addMenu('Cadre Features', $items);

	if ($auth_data['chief']) {
		addMenu('Chief Features',
				array('Award Credits' => internal_link('admin_award', array()),
					'Award Medals' => internal_link('admin_award_medal', array()),
					'Edit Kabal Details' => internal_link('admin_edit_kabal', array()),
					'Upload New Kabal Logo' => internal_link('admin_upload_kabal_logo', array()),
					'Declare AWOLs' => internal_link('admin_declare_awols', array()),
					'E-Mail Members' => internal_link('admin_email_members', array()),
					'Add Report' => internal_link('admin_add_report', array()),
					'Edit Report' => internal_link('admin_edit_report', array()),
					'Chief Manual' => internal_link('book', array('id' => 16), 'library')));
	}
	if ($auth_data['warden']) {
		addMenu('Warden Features',
				array('Award Credits' => internal_link('admin_award', array()),
					'Award Medals' => internal_link('admin_award_medal', array()),
					'E-Mail Members' => internal_link('admin_email_members', array()),
					'Add Report' => internal_link('admin_add_report', array()),
					'Edit Report' => internal_link('admin_edit_report', array()),
					'Warden Manual' => internal_link('book', array('id' => 16), 'library')));
	}
	if ($auth_data['sysadmin']) {
		addMenu('System Administration',
				array('Create New Rank' => internal_link('admin_add_rank', array()),
					// 'Edit Existing Rank' => internal_link('admin_edit_rank', array()),
					'Create New Position' => internal_link('admin_add_position', array()),
					// 'Edit Existing Position' => internal_link('admin_edit_position', array()),
					// 'Create New Category' => internal_link('admin_create_division_category', array()),
					'Edit Existing Category of Divisions' => internal_link('admin_edit_division_category', array()),
					'Create New Division' => internal_link('admin_create_division', array()),
					'Edit Existing Division' => internal_link('admin_edit_division', array()),
					'Delete Existing Division' => internal_link('admin_delete_division', array()),
					// 'Edit System Settings' => internal_link('admin_edit_settings', array()),
					));
	}
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
