<?php
include('header.php');
$rank = new Rank($id);
if ($error = $rank->Error()) {
	echo <<<EOE
<error>
	<message>$error</message>
</error>
EOE;
}
else {
	rank($rank);
}
?>
