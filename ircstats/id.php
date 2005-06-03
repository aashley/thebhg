<?php
error_reporting(E_NONE);

header('Content-type: text/plain');

include_once 'util.inc';
include_once 'roster.inc';
include_once 'arena.inc';
$roster = new Roster();
$arena = new Arena();

switch (strtolower($_REQUEST['value'])) {
	case 'god':
	case 'frood':
		$_REQUEST['value'] = 94;
		break;
	case 'satan':
	case 'bofh':
		$_REQUEST['value'] = 666;
		break;
	case 'graphics-god':
	case 'oxx':
		$_REQUEST['value'] = 257;
		$oxx = true;
		break;
	case '421':
		$_REQUEST['value'] = 3;
		break;
	case 'munky':
	case 'cock':
		$_REQUEST['value'] = 370;
		break;
	case 'e':
	case 'evil':
		$_REQUEST['value'] = 45;
		break;
	case 'tex':
		$_REQUEST['value'] = 1281;
		break;
	case 'balls':
		$_REQUEST['value'] = 168;
}

if (is_numeric($_REQUEST['value'])) {
	$plebs[] = $roster->GetPerson($_REQUEST['value']);
	$test = $plebs[0]->Error();
	if ($test > '') {
		array_pop($plebs);
	}
}
else {
	$plebs = $roster->SearchPosition($_REQUEST['value']);
	if (!$plebs) {
		if (strlen($_REQUEST['value']) < 3) {
			exit;
		}
		$plebs = $roster->SearchName($_REQUEST['value']);
		if (!$plebs) {
			$plebs = $roster->SearchIRCNick($_REQUEST['value']);
		}
	}
}

foreach ($plebs as $pleb) {
	$div = $pleb->GetDivision();
	if ($div->GetID() != 16 && $div->GetID() != 0) {
		$new_plebs[] = $pleb;
	}
}

$plebs = $new_plebs;

function output_function($pleb){
	global $oxx, $arena;
	
	$rank = $pleb->GetRank();
	$div = $pleb->GetDivision();
	
	if ($oxx){
		$RANK = 'Lord';
	} else {
		$RANK = $rank->GetName();
	}
	
	$STATOUT = $RANK . ' ' . $pleb->GetName() . ' of ' . $div->GetName() . ' (#' . $pleb->GetID() . '): ';
	
	switch($_REQUEST['flag']){
		case 1:
			$idline = $pleb->IDLine();
			if ($oxx) { $idline = preg_replace('"^[A-Z]+/"', 'LORD/', $idline); }
			return "\002BHG ID #" . $pleb->GetID() . "\002: " . $idline;
		break;
		case 2:
			return 'E-mail address for ' . $STATOUT . $pleb->GetEMail();
		break;
		case 3:
			if ($rank->IsUnlimitedCredits()) {
				$CREDS = 'N/A';
			} else {
				$CREDS = 'Rank Credits: ' . number_format($pleb->GetRankCredits()) . "; Account Balance: " . number_format($pleb->GetAccountBalance());
			}
			return 'Credits for ' . $STATOUT . $CREDS . '.';
		break;
		case 4:
			$TIMEIN = format_time(time() - $pleb->GetJoinDate(), FT_DAY);
			return 'Time in the BHG for ' . $STATOUT . $TIMEIN . '.';
		break; 
		case 5:
			return 'Unused XP for ' . $STATOUT . number_format($arena->GetXP($pleb->GetID())) . '.';
		break;
		case 6:
			return 'Arena Ladder Rank for ' . $STATOUT . $arena->Ladder('arena', $pleb->GetID()) . '.';
		break;
		case 7:
			return 'IRC Arena Ladder Rank for ' . $STATOUT . $arena->Ladder('irca', $pleb->GetID()) . '.';
		break;
		case 8:
			return 'Starfield Arena Ladder Rank for ' . $STATOUT . $arena->Ladder('sa', $pleb->GetID()) . '.';
		break;
		case 9:
			return 'Solo Mission Ladder Rank for ' . $STATOUT . $arena->Ladder('solo', $pleb->GetID()) . '.';
		break;
		case 10:
			return 'Lone Wolf Mission Ladder Rank for ' . $STATOUT . $arena->Ladder('lw', $pleb->GetID()) . '.';
		break;
		case 11:
			return 'Character Sheet for ' . $STATOUT . 'http://holonet.thebhg.org/index.php?module=arena&page=atn_general&id=' . $pleb->GetID();
		break;
		case 12:
			return 'Roster Information for ' . $STATOUT . 'http://holonet.thebhg.org/index.php?module=roster&page=hunter&id=' . $pleb->GetID();
		break;
	}
}

if (empty($plebs) || count($plebs) == 0) {
	echo "No matches have been found.";
}
elseif (count($plebs) > 10) {
	echo count($plebs) . " matches have been found. Please refine your search to see any meaningful output.";
}
elseif (count($plebs) > 3) {
	$names = array();
	foreach ($plebs as $pleb) {
		$names[] = $pleb->GetName() . ' (ID #' . $pleb->GetID() . ')';
	}
	echo count($plebs) . " matches have been found. These matches are: " . implode(', ', $names) . ". Please use a specific ID to see more information.";
}
else {
	$output = array();
	foreach ($plebs as $pleb) {
		$output[] = output_function($pleb);
	}
	echo implode("\n", $output);
}
?>
