<?php
include_once('../../Layout.inc');
include_once('../header.php');

$auth_info = auth();
$level = $auth_info['level'];
$user =& $auth_info['user'];

$uploaddir = '/home/virtual/site5/fst/home/ka/public_html/kac/event_images/';

if ($level == 3) {
	$subarray = array(
		'<b>KAC Administration</b>'=>'',
		'View Current Season Info'=>'kac/stats.php?flag=kac',
		'Add New KAC'=>'kac/administration/admin.php?function=kac&flag=new',
		'Edit A KAC'=>'kac/administration/admin.php?function=kac&flag=edit',
		'End a KAC'=>'kac/administration/admin.php?function=kac&flag=end',
		'<b>Ladder Administration</b>'=>'',
		'Draw Initial Ladder'=>'kac/administration/admin.php?function=ladder&flag=start',
		'<b>Round Administration</b>'=>'',
		'Add New Rounds'=>'kac/administration/admin.php?function=round&flag=new',
		'Edit A Round'=>'kac/administration/admin.php?function=round&flag=edit',
		'<b>Event Administration</b>'=>'',
		'Grade An Event'=>'kac/administration/admin.php?function=events&flag=grade',
		'Add Event To KAC'=>'kac/administration/admin.php?function=events&flag=new',
		'Edit KAC Events'=>'kac/administration/admin.php?function=events&flag=edit',
		'<b>E-mail Functions</b>'=>'',
		'Notifiy Kabals'=>'kac/administration/admin.php?function=email&flag=kabals',
		'<b>KAC Core</b>'=>'',
		'Add New Event Type'=>'kac/administration/admin.php?function=event&flag=new',
		'Edit Event Type'=>'kac/administration/admin.php?function=event&flag=edit',
		'New Award Type'=>'kac/administration/admin.php?function=award&flag=new',
		'Edit Award Type'=>'kac/administration/admin.php?function=award&flag=edit',
	);
}
elseif ($level == 2) {
	$subarray = array(
		'Submit' => 'kac/administration/submit.php?function=submit&flag=events'
	);
}
elseif ($level == 1) {
	$subarray = array(
		'Submit' => 'kac/administration/submit.php?function=submit&flag=events'
	);
}
$subarray['<b>Back To KAC Home</b>'] = 'kac/index.php';

$medal_groups = array('kac'=>20, 'mov'=>21, 'ms'=>7);
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
