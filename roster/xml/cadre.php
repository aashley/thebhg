<?php
include('header.php');
$cadre = $roster->GetCadre($id);
if ($error = $cadre->Error()) {
	echo <<<EOE
<error>
	<message>$error</message>
</error>
EOE;
}
else {
	cadre($cadre);
}
?>
