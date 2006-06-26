<?php
include_once('../../Layout.inc');
include_once('../header.php');

$auth_info = auth();
$level = $auth_info['level'];
$user =& $auth_info['user'];

$uploaddir = realpath(dirname($_SERVER['SCRIPT_FILENAME']).'/..').'/hunt_images/';

if ($level == 3) {
	$subarray = array(
		'<b>CG Administration</b>'=>'',
		'Add New CG'=>'cg/administration/add_cg.php',
		'Edit A CG'=>'cg/administration/edit_cg.php',
		'Delete A CG'=>'cg/administration/delete_cg.php',
		'Award CG Credits/Medals'=>'cg/administration/award.php',
		'<b>Event Administration</b>'=>'',
		'Grade An Event'=>'cg/administration/grade_event.php',
		'Add Event To CG'=>'cg/administration/add_cg_event.php',
		'Edit CG Events'=>'cg/administration/edit_cg_events.php',
		'Delete Event From CG'=>'cg/administration/delete_cg_event.php',
		'<b>Timed Event Types</b>'=>'',
		'Add Event Type'=>'cg/administration/add_type.php',
		'Edit Event Type'=>'cg/administration/edit_type.php',
		'<b>Signup Administration</b>'=>'',
		'Edit CG Signups'=>'cg/administration/edit_signups.php',
		'Edit Rank Fees'=>'cg/administration/edit_rank_fees.php',
		'View Signups'=>'cg/administration/view_signups.php',
		'<b>E-mail Functions</b>'=>'',
		'E-mail Hunters By CG'=>'cg/administration/email.php?by=cg',
		'E-mail Hunters By Event'=>'cg/administration/email.php?by=event',
		'<b>Test Functions</b>'=>'',
		'Submit for Event'=>'cg/administration/submit.php'
	);
}
elseif ($level == 2) {
	$subarray = array(
		'Edit Signups'=>'cg/administration/edit_signups.php',
		'View Signups'=>'cg/administration/view_signups.php',
		'Submit for Event'=>'cg/administration/submit.php'
	);
}
elseif ($level == 1) {
	$subarray = array(
		'Edit Signups'=>'cg/administration/edit_signups.php',
		'Submit for Event'=>'cg/administration/submit.php'
	);
}
$subarray['<b>Back To CG Home</b>'] = 'cg/index.php';

$medal_groups = array('cb'=>17, 'ms'=>7);
function next_medal(&$mb, $person, $group) {
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
?>
