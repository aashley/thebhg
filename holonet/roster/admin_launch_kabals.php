<?php
function title() {
	return 'Administration :: Hosting';
}

function auth($person) {
	global $auth_data, $pleb, $roster;
	$auth_data = get_auth_data($person);
	$pleb = $roster->GetPerson($person->GetID());
	return $auth_data['underlord'];
}

function coders() {
	return array(94);
}

function output() {
	global $auth_data, $pleb, $roster, $page;

	roster_header();

	if (isset($_REQUEST['process']) && $_REQUEST['process'] == 'yes') {

		ob_end_flush();

		$category = $roster->getDivisionCategory(2);

		$uap = $roster->getDivision(11);

		$oldkabals = $roster->getKabals();

		$newdata = array(
				'Lightning' => array(
					'chief'			=> 2650,
					'username'	=> 'ligntning',
					'password'	=> '**password**',
					'coder'			=> 'light-39-goal',
					),
				'Titan' => array(
					'chief'			=> 2250,
					'username'	=> 'titan',
					'password'	=> '**password**',
					'coder'			=> 'tiny-73-foot',
					),
				'Daedalus' => array(
					'chief'			=> 1281,
					'username'	=> 'daedalus',
					'password'	=> '**password**',
					'coder'			=> 'dead-29-load',
					),
				'Loki' => array(
					'chief'			=> 1762,
					'username'	=> 'loki',
					'password'	=> '**password**',
					'coder'			=> 'laugh-75-spoon',
					),
				'Mithras' => array(
					'chief'			=> 1594,
					'username'	=> 'mithras',
					'password'	=> '**password**',
					'coder'			=> 'mith-82-rail',
					),
				);

		foreach ($newdata as $name => $data) {

			print '<p>Creating '.$name.' Kabal... ';

			$division = $roster->createDivision($name, $category);

			if ($division === false) {

				print 'Failed. '.$roster->error().'</p>';

				continue;

			} else {

				print 'Success.<br/>';

				$kabal = $roster->getKabal($division->getID());

			}

			flush();

			print 'Loading New Chief... ';

			$chief = $roster->getPerson($data['chief']);

			if ($chief === false) {

				print 'Failed. '.$roster->error().'</p>';

				continue;

			} else {

				print 'Success. '.$chief->getName().'<br/>';
				
			}

			flush();

			print 'Transfering chief to new kabal... ';

			if ($chief->setDivision($kabal)) {

				print 'Success.<br/>';

			} else {

				print 'Failed. '.$chief->error().'</p>';

				continue;

			}

			flush();

			print 'Transfering chief to Chief position... ';

			if ($chief->setPosition(11)) {

				print 'Success.<br/>';

			} else {

				print 'Failed. '.$chief->error().'</p>';

				continue;

			}

			flush();

			print 'Setting Kabal Home Page... ';

			if ($kabal->setURL('http://'.$data['username'].'.thebhg.org/')) {

				print 'Success. http://'.$data['username'].'.thebhg.org/<br/>';

			} else {

				print 'Failed. '.$kabal->error().'</p>';

				continue;

			}

			flush();

		  print 'Setting Mailing List... ';

			if ($kabal->setMailingList($data['username'])) {

				print 'Success. '.$data['username'].'@thebhg.org<br/>';

			} else {

				print 'Failed. '.$kabal->error().'</p>';

				continue;

			}

			flush();

			print 'Creating Coder-ID... ';

			$sql = 'INSERT INTO coders (`name`, `md5`, `news`, `hunts`) '
				.'VALUES("'.$name.' Kabal", "'.strtoupper(md5($data['coder'])).'", 1, 1);';

			if (mysql_query($sql, $roster->roster_db)) {

				print 'Success.<br/>';

			} else {

				print 'Failed. '.mysql_error($roster->roster_db).'<br/>'.$sql.'<br/>';

			}

			print 'Creating Hosting records... ';

			$accounts = array();

			$sql = 'INSERT INTO hosting_account (`type`, `parent`, `target`, `username`, `password`) '
				.'VALUES ("FTP", 0, "'.$data['username'].'.thebhg.org", "'.$data['username'].'", "'.$data['password'].'");';

			if (!mysql_query($sql, $roster->roster_db)) {

				print 'Failed. Could not create ftp hosting account record.<br/>'.$sql.'</p>';
			flush();

				continue;

			}

			$accounts[] = mysql_insert_id($roster->roster_db);

			$sql = 'INSERT INTO hosting_account (`type`, `parent`, `target`, `username`, `password`) '
				.'VALUES ("MySQL", '.$accounts[0].', "'.$data['username'].'", "", "");';

			if (!mysql_query($sql, $roster->roster_db)) {

				print 'Failed. Could not create mysql hosting account record.<br/>'.$sql.'<br/>';
			flush();

			}

			$accounts[] = mysql_insert_id($roster->roster_db);

			$sql = 'INSERT INTO hosting_account (`type`, `parent`, `target`, `username`, `password`) '
				.'VALUES ("CoderID", '.$accounts[0].', "'.$data['username'].'.thebhg.org", "'.$data['coder'].'", "");';

			if (!mysql_query($sql, $roster->roster_db)) {

				print 'Failed. Could not create coderid hosting account record.<br/>'.$sql.'<br/>';
			flush();

			}

			$accounts[] = mysql_insert_id($roster->roster_db);

			$sql = 'INSERT INTO hosting_rule (`account`, `division`, `person`, `position`) '
				.'VALUES ('.$accounts[0].', '.$kabal->getID().', NULL, 11);';

			if (!mysql_query($sql, $roster->roster_db)) {
				
				print 'Failed. Could not create mysql hosting account record.<br/>'.$sql.'<br/>';
			flush();

			} else {

				print 'Success.';

			}
			
			print '</p>';

		}

			flush();

		foreach ($oldkabals as $kabal) {

			print '<p>Closing '.$kabal->getName().' Kabal...';

			$members = $kabal->getMembers();

			foreach ($members as $member) {

				if (!$member->setDivision($uap)) {

					print 'Failed to transfer '.$member->getName().'. '.$member->error().'<br/>';
					flush();

				}

				if (!$member->setPosition(14)) {

					print 'Failed to set '.$member->getName().' back to hunter status. '.$member->error().'<br/>';

				}

			}

			if ($kabal->delete()) {

				print 'Success.';

			} else {

				print 'Failure. '.$kabal->error().'<br/>';

			}

			print '</p>';
			flush();


		}

	} else {

		print '<p>Do you wish to launch the new kabals?</p>'
			.'<a href="'.internal_link('admin_launch_kabals', array('process' => 'yes')).'">Yes</a>';

	}

	admin_footer($auth_data);

}


?>
