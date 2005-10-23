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

	if ($position->isEmailAlias()) {

		$person = $roster->searchPosition($position->getID());

		if (   is_array($person)
		    && isset($person[0])
		    && $person[0] instanceof Person) {

			print strtolower(str_replace(' ', '', $position->getName())).": ".$person[0]->getEmail()."\n");

		} else {

			print strtolower(str_replace(' ', '', $position->getName())).": darkprince@thebhg.org\n");

		}

	}

}

$kabals = $roster->getKabels();

foreach ($kabals as $kabal) {

	$chief = $kabal->getChief();

	if ($chief instanceof Person) {

		if (strlen($chief->getEmail()) > 0) {
			
			print "ch-".strtolower(str_replace(' ', '', $kabal->getName())).": "
				.$chief->getEmail()."\n";

		} else {

			print "ch-".strtolower(str_replace(' ', '', $kabal->getName())).": "
				."judicator@thebhg.org\n";

		}

	}

	$cra = $kabal->getCRA();

	if ($cra instanceof Person) {

		if (strlen($cra->getEmail()) > 0) {

			print 'cra-'.strtolower(str_replace(' ', '', $kabal->getName())).": "
				.$cra->getEmail()."\n";

		} else {

			print "cra-".strtolower(str_replace(' ', '', $kabal->getName())).": "
				."ch-".strtolower(str_replace(' ', '', $kabal->getName()))."@thebhg.org\n";
		}

	}

}

?>
