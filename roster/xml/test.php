<?
// A fragment of code that might just come in handy when trying to get information on a person from another server.

$person = array();
unset($tag);

function start_element($parser, $name, $attrs) {
	global $tag, $person;
	$tag = $name;
	foreach ($attrs as $name=>$value) {
		$person["$tag.$name"] .= $value;
	}
}

function end_element($parser, $name) {
	global $tag;
	unset($tag);
}

function handle_data($parser, $data) {
	global $tag, $person;
	$person[$tag] .= $data;
}

$lines = file('https://spanky.cernun.net/r3xml/person.php?id=666');
if ($lines) {
	$parser = xml_parser_create();
	xml_set_element_handler($parser, 'start_element', 'end_element');
	xml_set_character_data_handler($parser, 'handle_data');
	xml_parse($parser, implode("\n", $lines));
	xml_parser_free($parser);

	// Deal with the data however we like. In this example, we print a little bit of other information.
	echo $person['RANK.NAME'] . ' ' . $person['NAME'] . ' of ' . $person['DIVISION.NAME'] . ' has ' . number_format($person['RANKCREDITS']) . ' credits and holds the position of ' . $person['POSITION.NAME'] . '.';
}
else {
	echo 'Unable to load data.';
}
?>
