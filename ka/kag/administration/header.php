<?php
include_once('../../Layout.inc');
include_once('../header.php');

$auth_info = auth();
$level = $auth_info['level'];
$user =& $auth_info['user'];

if ($level == 3) {
	$subarray = array(
		'<b>KAG Administration</b>'=>'',
		'Add New KAG'=>'kag/administration/add_kag.php',
		'Edit A KAG'=>'kag/administration/edit_kag.php',
		'Delete A KAG'=>'kag/administration/delete_kag.php',
		'Award KAG Credits/Medals'=>'kag/administration/award.php',
		'<b>Event Administration</b>'=>'',
		'Grade An Event'=>'kag/administration/grade_event.php',
		'Add Event To KAG'=>'kag/administration/add_kag_event.php',
		'Edit KAG Events'=>'kag/administration/edit_kag_events.php',
		'Delete Event From KAG'=>'kag/administration/delete_kag_event.php',
		'<b>Signup Administration</b>'=>'',
		'Edit KAG Signups'=>'kag/administration/edit_kag_signups.php',
		'Edit Rank Fees'=>'kag/administration/edit_rank_fees.php',
		'View Signups'=>'kag/administration/view_signups.php',
		'<b>E-mail Functions</b>'=>'',
		'E-mail Hunters By KAG'=>'kag/administration/email.php?by=kag',
		'E-mail Hunters By Event'=>'kag/administration/email.php?by=event'
	);
}
elseif ($level == 2) {
	$subarray = array(
		'Edit Signups'=>'kag/administration/edit_signups.php',
		'View Signups'=>'kag/administration/view_signups.php'
	);
}
elseif ($level == 1) {
	$subarray = array(
		'Edit Signups'=>'kag/administration/edit_signups.php'
	);
}
$subarray['<b>Back To KAG Home</b>'] = 'kag/index.php';

$medal_groups = array('bos'=>5, 'pos'=>6, 'ms'=>7);
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
