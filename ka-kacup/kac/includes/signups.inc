<?

$bhg_id = $login->GetID();
$name = $login->GetName();
$divi = $login->GetDivision();
$kabal = $divi->GetID();

$stat = new Stats();
$current = $stat->FutureSeason();
$season = new Season($current);
$start = $season->GetStart();
$time = time();
$calc = $start-$time;
$sign = new Signup();
$mine = $sign->GetMySignups($bhg_id, $current);
$count = count($mine);

if ($action == "process"){

$i = 0;
$even = 0;

while ($i < $events){

$eve = $_REQUEST['event_'.$i];
$txt = $_REQUEST['event_name_'.$i];

$new = $sign->Process('$bhg_id', '$eve', '$kabal', '$current');

if ($new){
echo "Signup accepted for the ".$txt." event!<br>";
$even++;
} else {
echo $sign->error." (".$txt.")";
}

$i++;

}

if ($even > 0){
echo "<br><br>";
echo "Signed up for ".$even." events! Good luck!";
}

} else {


if ($calc > 0){

$min = $calc/(60*60*24);
$days = round($min);

if ($days >= 7){

echo "<table cellspacing=0 cellpadding=0 bordercolor=#000000 border=1 align=center STYLE='border-collapse: collapse' width=98%>";

echo "<form method=POST action=$PHP_SELF>";
echo "<tr><td align=center colspan=3>";
echo "You are currently are signed up for ".$count." events.";

echo "<tr><td valign=top>Delete Event<td valign=top>Event Name</td></tr>";

$i = 0;

while ($i < $count) {

$even_id = $mine[$i];

$sql = "SELECT * FROM kac_submissions WHERE id = '$even_id'";
$query = mysql_query($sql);
$event = mysql_fetch_array($query);

echo "<tr><td valign=top>";
echo " <input type=checkbox name=".$i.">";

echo "<td valign=top>";

$type = new Type($event['type']);
$name = $type->GetName();
$id = $type->GetID();

echo $name;


echo "</td></tr>";

echo "<input type=hidden name=event_".$i." value=".$id.">";
echo "<input type=hidden name=event_name_".$i." value=".$name.">";
$i++;
}

echo "</TD></TR>";

echo "<input type=hidden name=events value=".$i.">";
echo "<input type=hidden name=bhg_id value=".$bhg_id.">";
echo "<input type=hidden name=kabal value=".$kabal.">";
echo "<input type=hidden name=op value=editsignups>";
echo "<input type=hidden name=action value=process>";

echo "<tr><td width=25% colspan=2 align=center>";
echo "<INPUT TYPE=submit VALUE='Edit Events For - ".$name."'>";
echo "</TD></TR>";

echo "</form>";
echo "</TABLE>";
} else {
echo "Signups can no longer be changed. The current season has already begun.";
}
} else {
echo "Signups can no longer be changed. The current season's registration date is over.";
}


}
?>
