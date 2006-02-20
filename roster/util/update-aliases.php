<?php

include_once 'roster.inc';
include_once 'Net/Curl.php';

$server_url = 'https://loki.cernun.net:10000/';
$curl = new Net_Curl($server_url.'/session_login.cgi');

function login() {
	global $server_url, $curl;

	$curl->url = $server_url.'/session_login.cgi';
	$curl->type = 'post';
	$curl->verifyPeer = false;
	$curl->followLocation = false;

	$curl->fields = array(
			'user' => 'thebhg',
			'pass' => 'monkey69',
			'save' => 1,
			'submit' => 'Login',
			);

	$result = $curl->execute();

}

function updateAlias($alias_name, $target) {
	global $server_url, $curl;

	$dom_id = '112757614416171';
	
	$curl->url = $server_url.'virtual-server/save_alias.cgi';
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
	
/*	$curl->cookies = array(
		'sid'	=> '00aeb511062331b7ebf3f117a9b72176',
	);*/
	
	$result = $curl->execute();
	
}

login();

$roster = new Roster();

$positions = $roster->getPositions();

foreach ($positions as $position) {

	if ($position->isEmailAlias()) {

		$person = $roster->searchPosition($position->getID());

		if (   is_array($person)
		    && isset($person[0])
		    && $person[0] instanceof Person) {

			$alias = strtolower(str_replace(' ', '', $position->getName()));
			$target = $person[0]->getEmail();

		} else {

			$alias = strtolower(str_replace(' ', '', $position->getName()));
			$target = "darkprince@thebhg.org";

		}
		
		print "$alias: $target\n";
		updateAlias($alias, $target);

	}

}

$kabals = $roster->getKabals();

$chiefs = array();
$cras = array();

foreach ($kabals as $kabal) {

	$chief = $kabal->getChief();

	$alias = "ch-".strtolower(str_replace(' ', '', $kabal->getName()));
	
	if ($chief instanceof Person) {

		if (strlen($chief->getEmail()) > 0) {
	
			$target = $chief->getEmail();

		} else {

			$target = 'judicator@thebhg.org';

		}

	} else {

		$target = 'judicator@thebhg.org';

	}

	print "$alias: $target\n";
	updateAlias($alias, $target);
	$chiefs[] = $alias.'@thebhg.org';

	$cra = $kabal->getCRA();

	$alias = 'cra-'.strtolower(str_replace(' ', '', $kabal->getName()));
	
	if ($cra instanceof Person) {

		if (strlen($cra->getEmail()) > 0) {

			$target = $cra->getEmail();

		} else {

			$target = "ch-".strtolower(str_replace(' ', '', $kabal->getName()))."@thebhg.org";

		}

	} else {

		$target = "ch-".strtolower(str_replace(' ', '', $kabal->getName()))."@thebhg.org";

	}

	print "$alias: $target\n";
	updateAlias($alias, $target);
	$cras[] = $alias.'@thebhg.org';

}

updateAlias('chiefs', implode(', ', $chiefs));
updateAlias('cras', implode(', ', $cras));

?>
