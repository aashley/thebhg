<?

include_once('Kabal_Hunts/Objects/kabal_hunts.inc'); 

$kh = new Kabal_Hunts();

$run = new Running_Hunts();
$cmp = $run->Completed_Hunts();

$count = count($cmp);

echo "
<TR><TD align=center>
<CENTER><U>Completed Hunts</U></CENTER>
</TD></TR>";

if ($count == 0){
echo "<tr><td align=center><font size=1>";
echo "No completed hunts";
echo "</td></tr>";
} else {

$i = 0;

while ($i < $count){
$hunt = new Hunt($cmp[$i]);
$hunt_id = $hunt->Hunt_ID();
$type = $hunt->Hunt_Info();
$name = $type->Hunt_Name();

echo "<tr><td align=center><a href=view.php?id=";
echo $hunt_id;
echo ">";
echo $name;
echo " (ID #: ";
echo $hunt_id;
echo ")";
echo "</a></td></tr>";

$i++;
}

}

?>