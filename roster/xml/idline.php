<?
// A piece of code that will print your BHG ID line.

// Change the variable below to your Roster ID.
$roster_id = 666;

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

$lines = file("https://spanky.cernun.net/r3xml/person.php?id=$roster_id");
if ($lines) {
	$parser = xml_parser_create();
	xml_set_element_handler($parser, 'start_element', 'end_element');
	xml_set_character_data_handler($parser, 'handle_data');
	xml_parse($parser, implode("\n", $lines));
	xml_parser_free($parser);

	echo $person['IDLINE'];
}
else {
	echo 'Unable to load data.';
}
?>
