<?php
include_once('header.php');

page_header('Index');

$table = new Table();

echo '<div><h2>Welcome to the KAC Hall of Fame</h2><p>Welcome to the KAC Hall of Fame. Within these walls you will find information on the greatest '
	.'hunters the Kabal Authority Cup has ever seen. You can find information here on who has the most points in KAC history, the best individual KACs'
	.', the most event wins, along with other categories bound to create hours of argument about who the best hunter is in KAC history.</p><p>Please '
	.'select the category you are interested in from the list provided at left.</p>	</div>';

$table->EndTable();

page_footer();
?>
