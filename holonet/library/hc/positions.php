<?php

$database = "thebhg_roster";
$connection = mysql_connect("localhost", "thebhg_roster", "bhgrosterpass");
mysql_select_db($database,$connection);

if ($_POST['submit']) {
	if ($_POST['kabal']) {
		$kabal = $roster->GetKabal($_POST['kabal']);
		$kabal_name = $kabal->GetName();
		$pos = $roster->GetPosition($_POST['position']);
		$pos_name = $pos->GetName();
		$from = new Date(mktime(0,0,0,1,1,2002));
		$to = new Date(time());
		$plebs = $roster->SearchPositionBetween($pos,$from,$to,$kabal);
		
		print "<p>Every {$pos_name} of {$kabal_name}:";
		
		foreach ($plebs as $pleb) {
			print "<br>".$pleb->GetName();
		}
		
		print "</p>";
	}
	
	$sql = "SELECT * FROM `roster_history` WHERE (`item1` ='".$_POST['position']."' OR `item2` ='".$_POST['position']."') AND `type` ='2'";
	$query = mysql_query($sql,$connection);
	
	print "<p>";
	while ($event = mysql_fetch_array($query)) {
		$date_format = "j F Y";
		$date = date($date_format,$event['date']);
		$pleb = new Person($event['person']);
		$pleb_name = $pleb->GetName();
		$oldpos = new Position($event['item1']);
		$oldpos_name = $oldpos->GetName();
		$newpos = new Position($event['item2']);
		$newpos_name = $newpos->GetName();
		
		print "<br>{$date}: {$pleb_name} changed from {$oldpos_name} to {$newpos_name}\n";
	}
	print "</p>";
} else {
	$positions = $roster->GetPositions();
	$kabals = $roster->GetKabals();
	print "<form method=\"post\" action=\"{$PHP_SELF}\">
		<p><select name=\"position\">";
	
	foreach ($positions as $position) {
		$id = $position->GetID();
		$name = $position->GetName();
		
		print "<option value=\"{$id}\">{$name}</option>";
	}
	
	print "</select>
		<br><br><select name=\"kabal\">
		<option value=\"0\">Choose a Kabal</option>";
	
	foreach ($kabals as $kabal) {
		$id = $kabal->GetID();
		$name = $kabal->GetName();
		
		print "<option value=\"{$id}\">{$name}</option>";
	}
	
	print "</select>
		<br><br><input type=\"submit\" name=\"submit\" value=\"Submit\">
		</p></form>";
}

?>