<?php
include('header.php');
$position = new Position($id);
if ($error = $position->Error()) {
	echo <<<EOE
<error>
	<message>$error</message>
</error>
EOE;
}
else {
	position($position);
}
?>
