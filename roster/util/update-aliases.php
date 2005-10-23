<?php

include_once 'roster.inc';
include_once 'Net/Curl.php';

function updateAlias($alias_name, $target) {

	$server_url = 'https://loki.cernun.net:10000/';
	$dom_id = '112757614416171';
	
	$curl = new Net_Curl($server_url.'virtual-server/save_alias.cgi');
	$curl->type = 'post';
	$curl->verifyPeer = false;
	$curl->followLocation = false;
	
	$curl->fields = array(
		'new'		=> '',
		'dom'		=> $dom_id,
		'old'		=> $alias_name.'@thebhg.org',
		'name_def'	=> 0,
		'name'		=> $alias_name,
		'type_0'	=> 1,
		'val_0'		=> $target,
		'type_1'	=> 0,
		'val_1'		=> '',
		'type_2'	=> 0,
		'val_2'		=> '',
		'type_3'	=> 0,
		'val_3'		=> '',
	);
	
	$curl->cookies = array(
		'sid'	=> 'c40fd268e089b3fd24c087448997bda9',
	);
	
	$result = $curl->execute();
	
}

$positions = $roster->getPositions();

foreach ($positions as $position) {



?>
