<?php
include_once('header.php');

page_header('Administration');

$div = $user->GetDivision();
echo 'Welcome to CG Administration.';
if ($level == 3) {
	echo ' You have been logged in as a member of the CG Staff, and can therefore edit all aspects of any CG.';
}
elseif ($level == 2) {
	echo ' You have been logged in as a cadre leader, and may view the registrations within your cadre as well as changing your own signup details for any current CG.';
}
elseif ($user->InCadre()) {
	echo ' As a hunter you can submit to events.';
}

page_footer();
?>
