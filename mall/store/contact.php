<?php
include('header.php');
page_header();

echo '<H1>Contact Us</H1><HR NOSHADE SIZE=2>You can contact us at the e-mail addresses below.<BR><BR>';

$tactician = $roster->SearchPosition(3);
$marshal = $roster->SearchPosition(7);

if ($tactician) {
	echo '<A HREF="' . roster_person($tactician[0]->GetID()) . '">Tactician ' . $tactician[0]->GetName() . '</A>: <A HREF="mailto:' . $tactician[0]->GetEmail() . '">' . $tactician[0]->GetEmail() . '</A><BR>';
}
else {
	echo 'There is no Tactician at the moment.<BR>';
}

if ($marshal) {
	echo '<A HREF="' . roster_person($marshal[0]->GetID()) . '">Marshal ' . $marshal[0]->GetName() . '</A>: <A HREF="mailto:' . $marshal[0]->GetEmail() . '">' . $marshal[0]->GetEmail() . '</A><BR>';
}
else {
	echo 'There is no Marshal at the moment.<BR>';
}

page_footer();
?>