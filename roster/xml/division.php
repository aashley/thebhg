<?php
include('header.php');
$division = $roster->GetDivision($id);
if ($error = $division->Error()) {
	echo <<<EOE
<error>
	<message>$error</message>
</error>
EOE;
}
else {
	division($division);
}
?>
