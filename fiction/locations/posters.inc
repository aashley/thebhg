<?php

$search = new Search();

$all = $search->AllPosters();

include_once 'roster.inc';

$count = count($all);
$i = 0;
$return = array();

while ($i < $count) {
	$bhg_id = $all[$i];
	$person = new Person($bhg_id);
	$name = $person->GetName();

	array_push($return, $name);

	$i++;
} 

sort($return);

$count = count($return);
$i = 0;

while ($i < $count) {
	echo "<a href=bookshelf.php?id=" . $all[$i] . ">" . $return[$i] . "</a>";

	$i++;
} 

?>