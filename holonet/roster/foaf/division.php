<?php
	require_once 'bhg_foaf.php';

	$division = division_to_foaf ($_REQUEST ["id"]);

	header ("Content-Type: text/xml");
	echo $division->toXML ();
?>
