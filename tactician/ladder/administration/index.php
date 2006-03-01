<?php
include('header.php');

$pos = $login->GetPosition();
if ($login->GetID() == 2650 || $pos->GetID() == 3 || $GLOBALS['access']) {
	page_header('Admin');
}
else {
	page_header('Administration');
	echo 'You are not authorised to administer this site.';
	page_footer();
}

	echo '<div><h2>Ladder Awards</h2>Here, you may process the awards for the ladder for any given completed month.</div>';

	page_footer();
?>
