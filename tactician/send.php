<?php
include('header.php');
page_header('Submit Answer');

$id = (int) $id;
$mission_result = mysql_query("SELECT * FROM missions WHERE id=$id", $db);
if ($mission_result && mysql_num_rows($mission_result)) {
	$mission = mysql_fetch_array($mission_result);
	if ($mission['complete'] != 0) {
		echo 'This mission has been completed.';
	}
	else {
		$login = new Login($rosterid, $password);
		if ($login->IsValid()) {
			if ($mission['author'] == $login->GetID()) {
				echo 'Sorry, but you cannot submit an answer to your own mission.';
			}
			else {
				$dupe = mysql_query("SELECT * FROM answers WHERE mission=$id AND person=" . $login->GetID(), $db);
				if ($dupe && mysql_num_rows($dupe)) {
					echo 'You have already submitted an answer to this mission.';
				}
				else {
					mysql_query("INSERT INTO answers (mission, person, answer, reason, correct, time) VALUES ($id, " . $login->GetID() . ", '" . addslashes($answer) . "', '" . addslashes($reasoning) . "', 0, UNIX_TIMESTAMP())", $db);
				
					echo 'Your answer has been sent to the Tactician.';
				}
			}
		}
		else {
			echo 'Unable to authenticate you against the roster (incorrect password, maybe?)';
		}
	}
}
else {
	echo "Unable to find mission ID $id.";
}

page_footer();
?>
