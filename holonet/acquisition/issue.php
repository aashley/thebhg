<?php
function title() {
	return 'Issue ' . $_REQUEST['year'] . '-' . $_REQUEST['week'];
}

function output() {
	cover($_REQUEST['year'], $_REQUEST['week']);
}
?>
