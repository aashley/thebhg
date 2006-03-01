<?php
include_once('header.php');

page_header('Administration');

$div = $user->GetDivision();
echo 'Welcome to KAC Administration. ';
if ($level == 3) {
	echo 'You have been logged in as part of the Kabal Authority, and as such have access to all aspects of the Kabal Auhtority Cup. Please do not change any functions which you have no working knowledge of, as they are default.';
}
elseif ($level == 2) {
	echo 'You have been logged in as a chief. You have no special features just yet.';
}
elseif ($div->IsKabal()) {
	echo 'From here, you can submit for all events which you have access to.';
}

page_footer();
?>
