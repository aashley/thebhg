<?php
	require_once 'bhg_foaf.php';

	$cadre = cadre_to_foaf ($_REQUEST ["id"]);

	header ("Content-Type: text/xml");
	echo $cadre->toXML ();
?>
