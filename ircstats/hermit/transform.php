<?php
if ($argc == 2) {
	$file = $argv[1];
}

header('Content-Type: text/plain');

$lines = file($file);

foreach ($lines as $line) {
	$array = explode('	', $line);
	$id = 0;
	foreach ($array as $nick) {
		if ($id == 0) $id = $nick;
		else echo "INSERT INTO nicks (person, nick) VALUES ($id, '" . mysql_escape_string(str_replace(array('*', '?', "\n"), '', $nick)) . "');\n";
	}
}

?>
