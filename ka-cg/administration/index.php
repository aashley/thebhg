<?php
include_once('header.php');

page_header('Administration');

$div = $user->GetDivision();
echo 'Welcome to CG Administration.';
if ($level == 3) {
	echo ' You have been logged in as a member of the KA Staff, and can therefore edit all aspects of any CG.';
}
elseif ($level == 2) {
	echo ' You have been logged in as a chief, and may view the registrations within your cadre as well as changing your own signup details for any current CG.';
}
elseif ($div->IsCadre()) {
	echo ' As a hunter in a cadre, you may change your signup details for any current CG.';
}

page_footer();
?>
