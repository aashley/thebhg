<?php
$pleb = $roster->GetPerson($_REQUEST['id']);

function title() {
	global $pleb;

	return 'Property :: ' . $pleb->GetName();
}

function output() {
	global $pleb;

	$div = $pleb->GetDivision();

	roster_header();

	echo 'Sections: <a href="#ssl">SSL&nbsp;Ships</a> | <a href="#kiw">KIW&nbsp;Weapons</a> | <a href="#kke">KKE&nbsp;Items</a> | <a href="#dsm">DSM&nbsp;Armour</a>';

	hr();

	echo '<a name="ssl" href="http://mall.thebhg.org/ssl/index.php?frame=registries/kabal.php&amp;id=' . $div->GetID() . '&amp;anchor=' . $pleb->GetID() . '"><b>SSL Ships</b></a><br><br>';
	readfile('http://mall.thebhg.org/ssl/person-property.php?id=' . $pleb->GetID());
	hr();

	echo '<a name="kiw" href="http://mall.thebhg.org/kiw/index.php?frame=registries/kabal.php&amp;id=' . $div->GetID() . '&amp;anchor=' . $pleb->GetID() . '"><b>KIW Weapons</b></a><br><br>';
	readfile('http://mall.thebhg.org/kiw/person-property.php?id=' . $pleb->GetID());
	hr();

	echo '<a name="kke" href="http://mall.thebhg.org/kke/index.php?frame=registries/kabal.php&amp;id=' . $div->GetID() . '&amp;anchor=' . $pleb->GetID() . '"><b>KKE Items</b></a><br><br>';
	readfile('http://mall.thebhg.org/kke/person-property.php?id=' . $pleb->GetID());
	hr();

	echo '<a name="dsm" href="http://mall.thebhg.org/dsm/index.php?frame=registries/kabal.php&amp;id=' . $div->GetID() . '&amp;anchor=' . $pleb->GetID() . '"><b>DSM Armour</b></a><br><br>';
	readfile('http://mall.thebhg.org/dsm/person-property.php?id=' . $pleb->GetID());
	hr();
	
	echo '<a name="rgt" href="http://mall.thebhg.org/rgt/index.php?frame=registries/kabal.php&amp;id=' . $div->GetID() . '&amp;anchor=' . $pleb->GetID() . '"><b>RGT Vehicles</b></a><br><br>';
	readfile('http://mall.thebhg.org/rgt/person-property.php?id=' . $pleb->GetID());
	hr();
	
	echo '<a name="krf" href="http://mall.thebhg.org/krf/index.php?frame=registries/kabal.php&amp;id=' . $div->GetID() . '&amp;anchor=' . $pleb->GetID() . '"><b>KRF Droids</b></a><br><br>';
	readfile('http://mall.thebhg.org/krf/person-property.php?id=' . $pleb->GetID());
	
	roster_footer();
}
?>
