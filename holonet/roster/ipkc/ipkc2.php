<?php
/* IPKC 2.0: "Purdy"
 *
 * A new, clean version of the IPKC code.
 *
 * Written by Jernai Teifsel <jernai@iinet.net.au>
 */

// Some other parameters.
$blank_name = 'ipkc.png';

include('roster.inc');
$roster = new Roster();
$pleb = $roster->GetPerson($_REQUEST['id']);

$name = $pleb->GetName();
$bio = $pleb->GetBioData();
$homeworld = $bio->GetHomeworld();
$age = (int) $bio->GetAge();
if ($age == 0) {
  $age = '';
}
$species = $bio->GetSpecies();
$height = $bio->GetHeight();
$sex = $bio->GetSex();
$joindate = $pleb->GetJoinDate();
$faceurl = $bio->GetImageURL();
$division = $pleb->GetDivision();

srand(intval(substr($joindate, 2, 2) . substr($joindate, 5, 2) . substr($joindate, 8, 2)));
$serial = rand(100, 99999);

$blank_size = getimagesize($blank_name);
$blank_img = imagecreatefrompng($blank_name);
$img = imagecreatetruecolor($blank_size[0], $blank_size[1]);
imagecopy($img, $blank_img, 0, 0, 0, 0, $blank_size[0], $blank_size[1]);

$red = imagecolorexact($img, 255, 0, 0);
if (!$red) {
	$red = imagecolorallocate($img, 255, 0, 0);
}
$white = imagecolorexact($img, 255, 255, 255);
if (!$white) {
	$white = imagecolorallocate($img, 255, 255, 255);
}
imagestring($img, 2, 170, 78, $name, $white);
imagestring($img, 2, 206, 93, $homeworld, $white);
imagestring($img, 2, 155, 109, $age, $white);
imagestring($img, 2, 177, 125, $species, $white);
imagestring($img, 2, 169, 140, $height, $white);
imagestring($img, 2, 151, 156, $sex, $white);
imagestring($img, 2, 206, 171, "BHG-$serial-" . $pleb->GetID(), $white);
//imagestring($img, 2, 125, 187, $name, $white);
imagefttext($img, 20, 0, 125, 202, $white, realpath('./rage.ttf'), $name, array());
if ($division->GetID() == 0 || $division->GetID() == 11) {
	imagefttext ($img, 80, 45, 80, 325, $red, realpath('./impact.ttf'), 'REVOKED', array());
}
elseif ($division->GetID() == 16) {
	imagefttext ($img, 60, 45, 55, 365, $red, realpath('./impact.ttf'), 'DISAVOWED', array());
}

if ($faceurl) {
	if ($face_size = @getimagesize($faceurl)) {
		switch ($face_size[2]) {
			case 1:
				$face_img = @imagecreatefromgif($faceurl);
				break;
			case 2:
				$face_img = @imagecreatefromjpeg($faceurl);
				break;
			case 3:
				$face_img = @imagecreatefrompng($faceurl);
				break;
		}
		if (isset($face_img)) {
			@imagecopy($img, $face_img, 15, 80, 0, 0, $face_size[0], $face_size[1]);
		}
	}
}

header('Expires: ' . date('r', time() + 604800));
if (isset($_REQUEST['mini'])) {
	$thumb = imagecreatetruecolor(113, 148);
	imagecopyresampled($thumb, $img, 0, 0, 0, 0, 113, 148, $blank_size[0], $blank_size[1]);
	$img = $thumb;
}
if (isset($_REQUEST['format'])) {
	switch (strtolower($_REQUEST['format'])) {
		case 'png':
			header('Content-Type: image/png');
			imagepng($img);
			break;
		case 'jpeg': case 'jpg': default:
			header('Content-Type: image/jpeg');
			imagejpeg($img, '', 70);
	}
} else {
	header('Content-Type: image/jpeg');
	imagejpeg($img, '', 70);
}

exit;
?>
