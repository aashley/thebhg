<?php
include_once '/usr/share/bhg/bhg.php';
$img 		= imagecreatefrompng('ipkc.png');

if (!is_object($person = $GLOBALS['bhg']->roster->getPerson($_REQUEST['person']))) imagepng($img);

if (!($white = imagecolorexact($img, 255, 255, 255))) $white = imagecolorallocate($img, 255, 255, 255);
if (!($red = imagecolorexact($img, 255, 0, 0))) $red = imagecolorallocate($img, 255, 0, 0);

$bio 	= $person->getBiographicalData();
$serial = str_split(md5($person->GetID()), 4);
$serial = ($person->isLHA() ? 'LHA' : 'BHG') . '-' . $serial[0] . str_pad($person->getID(), 5, 0, STR_PAD_LEFT) . $serial[1];
imagestring($img, 2, 170, 78, $person->getName(), $white);
imagestring($img, 2, 210, 94, $bio->getHomeworld(), $white);
imagestring($img, 2, 159, 109, ($bio->getAge() < 0 ? 'Unknown' : $bio->getAge() . ' Standard Galactic Years'), $white);
imagestring($img, 2, 180, 125, $bio->getSpecies(), $white);
imagestring($img, 2, 172, 140, $bio->getHeight(), $white);
imagestring($img, 2, 154, 156, $bio->getSex(), $white);
imagestring($img, 2, 206, 171, $serial, $white);
imagefttext($img, 20, 0, 125, 202, $white, realpath('./rage.ttf'), $person->getName(), array());

$faceurl = $bio->getImageURL();

if (!is_null($faceurl)) {
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

if ($person->getDivision()->GetID() == 0 || $person->getDivision()->GetID() == 11)
	imagefttext ($img, 80, 45, 80, 325, $red, realpath('./impact.ttf'), 'REVOKED', array());
elseif ($person->getDivision() == 16)
	imagefttext ($img, 60, 45, 55, 365, $red, realpath('./impact.ttf'), 'DISAVOWED', array());


header('Content-Type: image/png');
imagepng($img);

exit;
?>
