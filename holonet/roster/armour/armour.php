<?php
// Change this for special occasions.
$show_aotw = false;

ob_start();

// Array of locations, widths, and heights.
$medals_info = array(
	'odp' => array(346, 66, 27, 16),
	'me' => array(350, 175, 53, 39),
	'hm' => array(288, 336, 38, 38),
	'boh' => array(287, 265, 36, 30),
	'gp' => array(519, 166, 23, 46),
	'sp' => array(502, 125, 24, 45),
	'lc' => array(342, 122, 83, 59),
	'hp-left' => array(216, 44, 63, 42),
	'hp-right' => array(379, 50, 62, 47),
	'ms' => array(279, 323, 62, 63),
	'p-left' => array(219, 355, 61, 44),
	'p-right' => array(337, 367, 73, 42),
	'bos' => array(279, 168, 49, 53),
	'aotw' => array(15, 318, 124, 113),
	'ghp' => array(331, 257, 70, 50),
	'fhp' => array(287, 59, 32, 25),
	'cb-left' => array(111, 257, 91, 85),
	'cb-right' => array(462, 25, 117, 99),
	'kac' => array(477, 263, 154, 168),
	'm' => array(418, 211, 65, 165),
	'scb' => array(199, 273, 65, 80),
	'kl' => array(5, 5, 44, 100)
);

$pos_colours = array(
	'aj' => 'b76b01',
	'ch' => '825e87',
	'cra' => '77c6c6',
	'dp' => '000000',
	'fh' => '3f0545',
	'gh' => '3f0545',
	'h' => '3f0545',
	'jud' => 'feff6c',
	'marl' => 'dc2f9c',
	'pr' => '938e2f',
	'sp' => '2201b7',
	't' => 'ffffff',
	'tact' => 'b70101',
	'u' => '168702',
	'x' => '6b0505'
);

$rank_colours = array(
	'appr' => '8e8e8e',
	'asan' => '835176',
	'asst' => '84265e',
	'bld' => '315f39',
	'brn' => 'e60000',
	'card' => 'ffffff',
	'count' => 'ffda24',
	'dp' => '1900a6',
	'duke' => '837d11',
	'elt' => '00e5e6',
	'hmstr' => '954a11',
	'jrny' => 'b62d98',
	'mrc' => '31e051',
	'mstr' => '000000',
	'prm' => '5e0000',
	'ven' => '97aba3'
);

header('Content-Type: image/jpeg');
header('Expires: ' . date('r', time() + (86400 * 7)));
include('roster.inc');

$roster = new Roster();
$mb = new MedalBoard();
$person = $roster->GetPerson($_REQUEST['id']);
$name = $person->GetName();

$freq = count_chars($name, 1);
foreach ($freq as $key=>$frequency) {
	if ($key > 127 || $key < 32) {
		$name = str_replace(chr($key), '', $name);
		$s_idline = str_replace(chr($key), '', $s_idline);
	}
}

$ams = $person->GetMedals();
foreach ($ams as $am) {
	$medal = $am->GetMedal();
	$group = $medal->GetGroup();
	if ($group->GetMultiple() && count($group->GetMedals()) == 1) {
		$medals[$group->GetID()]++;
	}
	elseif (empty($medals[$group->GetID()]) || $morder[$group->GetID()] < $medal->GetOrder()) {
		$medals[$group->GetID()] = $medal->GetAbbrev();
		$morder[$group->GetID()] = $medal->GetOrder();
	}
}

$img = imagecreatefromjpeg('blank.jpg');

// Division
$division = $person->GetDivision();
$div = strtolower($division->GetName());
$div_array = explode(' ', $div);
if (is_array($div_array)) {
	$div = $div_array[0];
}
if (file_exists("division/$div.png")) {
	$temp_img = imagecreatefrompng("division/$div.png");
	imagecopy($img, $temp_img, 101, 157, 0, 0, 82, 34);
	imagedestroy($temp_img);
}

// Rank
$rank_obj = $person->GetRank();
$rank = strtolower($rank_obj->GetAbbrev());
if (file_exists("rank/$rank.png")) {
	$temp_img = imagecreatefrompng("rank/$rank.png");
	imagecopy($img, $temp_img, 114, 112, 0, 0, 84, 33);
	imagedestroy($temp_img);
}

// Position
$position = $person->GetPosition();
$pos = strtolower($position->GetAbbrev());
if (file_exists("position/$pos.png")) {
	$temp_img = imagecreatefrompng("position/$pos.png");
	imagecopy($img, $temp_img, 214, 127, 0, 0, 68, 85);
	imagedestroy($temp_img);
}

if (   isset($medals)
    && is_array($medals)
    && sizeof($medals) > 0) {
	foreach ($medals as $gid=>$medal) {
		$group = $mb->GetMedalGroup($gid);
		$mclass = strtolower($group->GetAbbrev());
		$medal = strtolower($medal);
		if (is_numeric($medal)) {
			$mname = strtolower($mclass . '-' . $medal);
		}
		else {
			$mname = strtolower($medal);
		}
	
		if (!$show_aotw && $mname == 'aotw') {
			continue;
		}
		
		if ($mclass == 'hp') {
			$temp_img = imagecreatefrompng("medal/$mname-left.png");
			imagecopy($img, $temp_img, $medals_info['hp-left'][0], $medals_info['hp-left'][1], 0, 0, $medals_info['hp-left'][2], $medals_info['hp-left'][3]);
			imagedestroy($temp_img);
			$temp_img = imagecreatefrompng("medal/$mname-right.png");
			imagecopy($img, $temp_img, $medals_info['hp-right'][0], $medals_info['hp-right'][1], 0, 0, $medals_info['hp-right'][2], $medals_info['hp-right'][3]);
			imagedestroy($temp_img);
		}
		elseif ($mclass == 'p') {
			$temp_img = imagecreatefrompng("medal/$mname-left.png");
			imagecopy($img, $temp_img, $medals_info['p-left'][0], $medals_info['p-left'][1], 0, 0, $medals_info['p-left'][2], $medals_info['p-left'][3]);
			imagedestroy($temp_img);
			$temp_img = imagecreatefrompng("medal/$mname-right.png");
			imagecopy($img, $temp_img, $medals_info['p-right'][0], $medals_info['p-right'][1], 0, 0, $medals_info['p-right'][2], $medals_info['p-right'][3]);
			imagedestroy($temp_img);
		}
		elseif ($mclass == 'cb') {
			$temp_img = imagecreatefrompng("medal/$mname-left.png");
			imagecopy($img, $temp_img, $medals_info['cb-left'][0], $medals_info['cb-left'][1], 0, 0, $medals_info['cb-left'][2], $medals_info['cb-left'][3]);
			imagedestroy($temp_img);
			$temp_img = imagecreatefrompng("medal/$mname-right.png");
			imagecopy($img, $temp_img, $medals_info['cb-right'][0], $medals_info['cb-right'][1], 0, 0, $medals_info['cb-right'][2], $medals_info['cb-right'][3]);
			imagedestroy($temp_img);
		}
		elseif ($mclass == 'm') {
			$temp_img = imagecreatefrompng("medal/$mname.png");
			imagecopy($img, $temp_img, $medals_info[$mclass][0], $medals_info[$mclass][1], 0, 0, $medals_info[$mclass][2], $medals_info[$mclass][3]);
			imagedestroy($temp_img);
		}
		elseif (file_exists('medal/' . $mname . '.png')) {
			$temp_img = imagecreatefrompng("medal/$medal.png");
			imagecopy($img, $temp_img, $medals_info[$mclass][0], $medals_info[$mclass][1], 0, 0, $medals_info[$mclass][2], $medals_info[$mclass][3]);
			imagedestroy($temp_img);
		}
	}
}

if (empty($_REQUEST['mini'])) {
	$box = imageftbbox(10, 0, realpath('./font.ttf'), $person->IDLine(0), array());
	$width = $box[2] - $box[0];
	$height = $box[5] - $box[3];
	$white = imagecolorallocate($img, 255, 255, 255);
	imagefttext($img, 10, 0, 320 - floor($width / 2), 475, $white, realpath('./font.ttf'), $person->IDLine(0), array());
	imagejpeg($img);
}
else {
	$mini = imagecreatetruecolor(160, 120);
	imagecopyresampled($mini, $img, 0, 0, 0, 0, 160, 120, 640, 480);
	imagejpeg($mini);
}
?>
