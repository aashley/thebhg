<?php
include('header.php');
$pleb = $roster->GetPerson($id);
if ($error = $pleb->Error()) {
	echo <<<EOE
<error>
	<message>$error</message>
</error>
EOE;
}
else {
	person($pleb);
}
?>
