<?php
// Holonet 2 compatibility layer. This doesn't remove the need for changes, but
// it minimises them greatly.

function open_window($name, $width = 0, $height = 0) {
	hr();
	echo '<b>' . $name . '</b><br><br>';
}

function close_window() {}

function options_from_db($query_result) {
	while ($record = mysql_fetch_array($query_result)) {
		$options[] = array(id => $record["id"], name => stripslashes($record["name"]));
	}
	return $options;
}

function drop_down($name, $options, $selected = "NULL") {
	echo "<SELECT NAME=\"$name\">\n";
	while ($option_array = each($options)) {
		$option = $option_array[1];
		$select_element = ($selected != "NULL" && $option["id"] == $selected);
		echo "<OPTION VALUE=\"" . $option["id"] . ($select_element ? " \" SELECTED" : "\"") . " NAME=\"" . $option["name"] . "\">" . $option["name"] . "</OPTION>\n";
	}
	echo "</SELECT>\n";
}

function shorten_string($string, $length = 40) {
	if (strlen($string) > $length) {
		return substr($string, 0, 40)."...";
	}
	else {
		return $string;
	}
}

function format_sentence($months) {
	if ($months == 0) return "No sentence imposed";

	$years = floor($months / 12);
	$months %= 12;
	if ($years > 1) {
		$sentence = "$years years" . format_months($months);
	}
	elseif ($years == 1) {
		$sentence = "1 year" . format_months($months);
	}
	else {
		$sentence = format_months($months);
	}

	return $sentence;
}

function format_months($months) {
	$sentence = "";
	if ($months > 1) {
		$sentence = " $months months";
	}
	elseif ($months == 1) {
		$sentence = " 1 month";
	}
	return $sentence;
}
?>
