<?php
	require_once 'bhg_foaf.php';

	$person = person_to_foaf ($_REQUEST ["id"]);

	header ("Content-Type: text/xml");
	echo $person->toXML ();
?>

