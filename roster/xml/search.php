<?php
// Available search types: name, ircnick, email, position, rank
include('header.php');

function id_sort($a, $b) {
	$a = $a->GetID();
	$b = $b->GetID();
	return (($a == $b) ? 0 : (($a > $b) ? 1 : -1));
}

$members = call_user_method("search$type", $roster, $value);
if ($members && count($members)) {
	usort($members, 'id_sort');
	echo "<members>\n";
	foreach ($members as $member) {
		person($member, 1);
	}
	echo "</members>\n";
}
else {
	echo <<<EOE
<error>
	<message>No matches found.</message>
</error>
EOE;
}
?>
