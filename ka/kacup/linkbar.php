<?
include_once('Kabal_Hunts/Objects/kabal_hunts.inc'); 

$kh = new Kabal_Hunts();

$run = new Running_Hunts();
$active = $run->Active_Hunts();
$pending = $run->Pending_Hunts();

$count = count($active);
$gra = count($pending);

echo "<table cellspacing=0 cellpadding=0 border=0 align=center>
<TR><TD align=center>
<CENTER><U>Active Hunts</U></CENTER>
</TD></TR>";

if ($count == 0){
echo "<tr><td align=center><font size=1>";
echo "No active hunts";
echo "</td></tr>";
} else {

$i = 0;

while ($i < $count){
$hunt = new Hunt($active[$i]);
$hunt_id = $hunt->Hunt_ID();
$type = $hunt->Hunt_Info();
$name = $type->Hunt_Name();

echo "<tr><td align=center><font size=1><a href=kh.php?id=";
echo $hunt_id;
echo ">";
echo $name;
echo "</a></td></tr>";

$i++;
}

}

echo "<TR><TD align=center>
&nbsp
</TD></TR>

<TR><TD align=center>
<CENTER><U>Hunt Index</U></CENTER>
</TD></TR>
<TR><TD align=center>
<A HREF=hunts.php>Hunt Types</A><BR>
</TD></TR>
<TR><TD align=center>
<A HREF=completed.php>Completed Hunts</A><BR>
</TD></TR>";

include_once 'roster.inc';
$login = $_COOKIE["BHGLogin_id"];

$kabal = new Kabal(3);
$chief = $kabal->GetChief();
$cra = $kabal->GetCRA();

$ch_id = $chief->getID();
$cra_id = $cra->getID();

if ($login == $ch_id){
echo "<TR><TD align=center>
&nbsp
</TD></TR>

<TR><TD align=center>
<hr>
<CENTER><U>Admin</U></CENTER>
</TD></TR>
<TR><TD align=center>
<A HREF=add_hunt.php><font size=1>New Hunt</font></A>
</TD></TR>
<TR><TD align=center>
&nbsp
</TD></TR>
<TR><TD align=center>
<font size=2>Grade</font>
</TD></TR>";
include_once('Kabal_Hunts/Objects/kabal_hunts.inc'); 

$kh = new Kabal_Hunts();
if ($gra == 0){
echo "<tr><td align=center><font size=1>";
echo "No hunts to grade";
echo "</td></tr>";
} else {

$i = 0;

while ($i < $gra){
$hunt = new Hunt($pending[$i]);
$hunt_id = $hunt->Hunt_ID();
$type = $hunt->Hunt_Info();
$name = $type->Hunt_Name();

echo "<tr><td align=center><font size=1><a href=grade.php?id=";
echo $hunt_id;
echo ">";
echo $name;
echo "</a></td></tr>";

$i++;
}

}
echo "<TR><TD align=center>
<hr>
</TD></TR>";

}

echo "<TR><TD align=center>
&nbsp
</TD></TR>

<TR><TD align=center>
<CENTER><U>Links</U></CENTER>
</TD></TR>
<TR><TD align=center>
<A HREF=main.php>News</A><BR><BR>
</TD></TR>
<TR><TD align=center><font size=1>
<A HREF=login.php>Login</A><BR></font>
</TD></TR>

</table>";
?>