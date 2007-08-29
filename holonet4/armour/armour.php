<?php
include_once '/usr/share/bhg/bhg.php';

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
	//'aotw' => array(15, 318, 124, 113),
	'ghp' => array(331, 257, 70, 50),
	'lhp' => array(287, 59, 32, 25),
	'cb-left' => array(111, 257, 91, 85),
	'cb-right' => array(462, 25, 117, 99),
	'kac' => array(477, 263, 154, 168),
	'm' => array(418, 211, 65, 165),
	'scb' => array(199, 273, 65, 80),
	//'kl' => array(5, 5, 44, 100)
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

$img = imagecreatefromjpeg('blank.jpg');

if (!is_object($person = $GLOBALS['bhg']->roster->getPerson($_REQUEST['person']))) imagejpeg($img);

$rank	 	= strtolower($person->getRank()->getAbbrev());
$position 	= strtolower($person->getPosition()->getAbbrev());

if (file_exists('rank/' . $rank . '.png')) {
	$temp_img = imagecreatefrompng('rank/' . $rank . '.png');
	imagecopy($img, $temp_img, 114, 112, 0, 0, 84, 33);
	imagedestroy($temp_img);
}

if (file_exists('position/' . $position . '.png')) {
	$temp_img = imagecreatefrompng('position/' . $position . '.png');
	imagecopy($img, $temp_img, 214, 127, 0, 0, 68, 85);
	imagedestroy($temp_img);
}

if ($person->inDivision($GLOBALS['bhg']->roster->getDivision(10))){
	$temp_img = imagecreatefrompng('division/commission.png');
	imagecopy($img, $temp_img, 101, 157, 0, 0, 82, 34);
	imagedestroy($temp_img);
}

switch (true){
	case ($person->inDivision($GLOBALS['bhg']->roster->getDivision(10))):
		$div = imagecreatefrompng('division/commission.png');
		break;
		
	case ($person->isLHA()):
		$div = imagecreatefrompng('division/lha.png');
		break;
		
	case ($person->isCadreLeader()):
		$div = imagecreatefrompng('division/cl.png');
		break;
		
	case ($person->inCadre()):
		$div = imagecreatefrompng('division/cadre.png');
		break;
}

if (isset($div)){
	imagecopy($img, $div, 101, 157, 0, 0, 82, 34);
	imagedestroy($div);
}

$medals = $person->getMedals();

$groups = array();

for ($i = 0; $i <= $medals->count(); $i++){
	$medal = $medals->getItem()->getMedal();

	if (isset($groups[$medal->getGroup()->getID()])){
		if ($medal->getSortOrder() > $groups[$medal->getGroup()->getID()]['weight']){
			$groups[$medal->getGroup()->getID()]['weight'] = $medal->getSortOrder();
			$groups[$medal->getGroup()->getID()]['medal'] = substr($medal->getImage(), 0, strpos($medal->getImage(), '.'));
		}
		elseif ($medal->getGroup()->hasDisplayType() && $medal->getGroup()->hasMultiple())
			++$groups[$medal->getGroup()->getID()]['count'];
	} else $groups[$medal->getGroup()->getID()] = array(
				'weight'	=> $medal->getSortOrder(),
				'medal'		=> substr($medal->getImage(), 0, strpos($medal->getImage(), '.')),
				'id'		=> $medal->getID(),
				'count'		=> ($medal->getGroup()->hasDisplayType() && $medal->getGroup()->hasMultiple() ? 1 : 0),
				'abbr'		=> strtolower($medal->getGroup()->getAbbrev()),
			);

	$medals->next();
}

foreach ($groups as $group => $data){
	if (isset($medals_info[$data['abbr'].'-left'])){
		
		$temp_img = imagecreatefrompng('medal/' . $data['medal'] . ($data['count'] ? '-' . $data['count'] : '') . '-left.png');
		imagecopy($img, $temp_img, $medals_info[$data['abbr'] .'-left'][0], $medals_info[$data['abbr'] .'-left'][1], 0, 
			0, $medals_info[$data['abbr'] .'-left'][2], $medals_info[$data['abbr'] .'-left'][3]);
		imagedestroy($temp_img);
		
		$temp_img = imagecreatefrompng('medal/' . $data['medal'] . ($data['count'] ? '-' . $data['count'] : '') . '-right.png');
		imagecopy($img, $temp_img, $medals_info[$data['abbr'] .'-right'][0], $medals_info[$data['abbr'] .'-right'][1], 
			0, 0, $medals_info[$data['abbr'] .'-right'][2], $medals_info[$data['abbr'] .'-right'][3]);
		imagedestroy($temp_img);
	} elseif (isset($medals_info[$data['abbr']])) {
		$temp_img = imagecreatefrompng('medal/' . $data['medal'] . ($data['count'] ? '-' . $data['count'] : '') . '.png');
		imagecopy($img, $temp_img, $medals_info[$data['abbr']][0], $medals_info[$data['abbr']][1], 0, 0, 
			$medals_info[$data['abbr']][2], $medals_info[$data['abbr']][3]);
		imagedestroy($temp_img);
	}
}

if (empty($_REQUEST['mini'])) {
	$box = imageftbbox(10, 0, realpath('./font.ttf'), $person->getIDLine(), array());
	$width = $box[2] - $box[0];
	$height = $box[5] - $box[3];
	$white = imagecolorallocate($img, 255, 255, 255);
	imagefttext($img, 10, 0, 320 - floor($width / 2), 475, $white, realpath('./font.ttf'), $person->getIDLine(), array());
	imagejpeg($img);
}
else {
	$mini = imagecreatetruecolor(160, 120);
	imagecopyresampled($mini, $img, 0, 0, 0, 0, 160, 120, 640, 480);
	imagejpeg($mini);
}
?>
	