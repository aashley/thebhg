<?
include('Objects/kabal_hunts.inc');
$new = new Kabal_Hunts();

$hun = new Hunt($hunt);
$grad = $hun->Hunt_Graded();

if ($grad){
echo "<center>Hunt already graded";
} else {

if ($hunt) {

if ($action == 'process1'){

$place = $answer_1;
$bhg_id = $bhg_id_1;

$process = new Grade($hunt, $bhg_id, $place, 2);

if ($process) {
$die = 1;
mysql_query("UPDATE hunts SET graded = '1' WHERE id = '$hunt'");

} else {
echo "Error processing hunt.";
}

} else {

echo "<center>You must have a hunt grade object to proceed. Error - 1";

}

} else {

echo "<center>You must have a hunt grade object to proceed. Error - 2";

}
}

if ($die == 1){
echo "<center>Hunts graded for one hunter.";
}
?>