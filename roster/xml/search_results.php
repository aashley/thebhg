<?
// A fragment of code that might just come in handy when trying to get information on a person from another server.

$person = array();
unset($tag);

$person_number = 0;

function start_element($parser, $name, $attrs) {
	global $tag, $person, $person_number;
	$tag = $name;
	if ($tag == 'PERSON') {
		$person_number = $attrs['ID'];
	}
	foreach ($attrs as $name=>$value) {
		$person[$person_number]["$tag.$name"] .= $value;
	}
}

function end_element($parser, $name) {
	global $tag;
	unset($tag);
}

function handle_data($parser, $data) {
	global $tag, $person, $person_number;
	$person[$person_number][$tag] .= $data;
}

$lines = file('https://spanky.cernun.net/r3xml/search.php?type=position&value=ch');
if ($lines) {
	$parser = xml_parser_create();
	xml_set_element_handler($parser, 'start_element', 'end_element');
	xml_set_character_data_handler($parser, 'handle_data');
	foreach ($lines as $line) {
		xml_parse($parser, $line);
	}
	xml_parse($parser, '', true);
	xml_parser_free($parser);

	// Deal with the data however we like. In this example, we print a little bit of other information.
	foreach ($person as $id=>$pleb) {
		if ($id == 0) {
			continue;
		}
		echo $pleb['RANK.NAME'] . ' ' . $pleb['NAME'] . ' of ' . $pleb['DIVISION.NAME'] . ' has ' . number_format($pleb['RANKCREDITS']) . ' credits and holds the position of ' . $pleb['POSITION.NAME'] . '.<BR>';
	}
}
else {
	echo 'Unable to load data.';
}
?>
