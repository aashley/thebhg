<?
include('Objects/kabal_hunts.inc');
$new = new Kabal_Hunts();

$hun = new Hunt($di);
$grad = $hun->Hunt_Graded();

if ($grad){
echo "<center>Hunt already graded";
} else {

if ($hunt->hunt_id) {

$i = 0;

while ($i < $total){

$place = $_REQUEST[("answer_" . $i)];
$bhg_id = $_REQUEST[("bhg_id_" . $i)];

$process = new Grade($hunt->hunt_id, $bhg_id, $place, 2);

if ($process) {
$die = 1;
$i++;
}
}

$sql = "UPDATE hunts SET graded = '1' WHERE id = '".$hunt->hunt_id."'";

if (mysql_query($sql)) {
$die=1;
}

} else {

echo "<center>You must have a hunt grade object to proceed. Error - 2";

}
}

if ($die == 1){
echo "<center>Hunts graded";
}
?>