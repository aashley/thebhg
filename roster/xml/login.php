<?php
include('header.php');
$pleb = new Login($username, $password);
if ($error = $pleb->Error()) {
	echo <<<EOE
<error>
	<message>$error</message>
</error>
EOE;
}
else {
	if ($pleb->IsValid()) {
		person($pleb);
	}
	else {
		echo <<<EOE
	<error>
		<message>Invalid login.</message>
	</error>
EOE;
	}
}
?>
