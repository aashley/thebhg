<?php
include_once 'header.php';

page_header('Submit Answer');

$id = (int) $id;
$mission_result = mysql_query("SELECT * FROM missions WHERE id=$id", $db);
if ($mission_result && mysql_num_rows($mission_result)) {
	$mission = mysql_fetch_array($mission_result);
	if ($mission['complete'] != 0) {
		echo '<div>This mission has been completed.</div>';
	}
	else {
		if ($mission['author'] == $login->GetID()) {
			echo '<div>Sorry, but you cannot submit an answer to your own mission.</div>';
		}
		else {
			$dupe = mysql_query("SELECT * FROM answers WHERE mission=$id AND person=" . $login->GetID(), $db);
			if ($dupe && mysql_num_rows($dupe)) {
				echo '<div>You have already submitted an answer to this mission.</div>';
			}
			else {
				mysql_query("INSERT INTO answers (mission, person, answer, reason, correct, time) VALUES ($id, " . $login->GetID() . ", '" . addslashes($answer) . "', '" . addslashes($reason) . "', 0, UNIX_TIMESTAMP())", $db);
			
				echo '<div>Your answer has been sent to the Tactician.<br />Answer: '. addslashes($answer) .'<br />Reasoning: ' . addslashes($reason) . '</div>';
			}
		}
	}
}
else {
	echo "<div>Unable to find mission ID $id.</div>";
}

page_footer();
?>
