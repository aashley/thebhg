<?php
include_once('header.php');

page_header('Administration');

$div = $user->GetDivision();
echo 'Welcome to KAG Administration.';
if ($level == 3) {
	echo ' You have been logged in as a member of the KA Staff, and can therefore edit all aspects of any KAG.';
}
elseif ($level == 2) {
	echo ' You have been logged in as a chief, and may view the registrations within your kabal as well as changing your own signup details for any current KAG.';
}
elseif ($div->IsKabal()) {
	echo ' As a hunter in a kabal, you may change your signup details for any current KAG.';
}

page_footer();
?>
