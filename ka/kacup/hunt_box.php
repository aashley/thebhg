<?

$hunt = new Hunt($id);
$hunt_id = $hunt->Hunt_ID();
$expires = $hunt->Hunt_Remain();
$graded = $hunt->Hunt_Graded();
$exp = $hunt->Hunt_Expire();
$type = $hunt->Hunt_Info();
$abbr = $type->Hunt_Abbr();
$name = $type->Hunt_Name();
$desc = $type->Hunt_Desc();

if ($hunt_id > 0){

echo "<tr><td align=center bgcolor=#dddddd><font size=4>";
echo "<table cellspacing=0 cellpadding=0 border=0>";
echo "<tr><td width=20%>";
echo "<img src=http://www.thebhg.org/cache/kabal/daichi.png>";
echo "<td width=60% align=center><font color=#000000 size=4><b>";
echo $name;
echo "</b></font>";
echo "<br><font size=2 color=#000000>";
echo $expires;
echo "</font>";
echo "<td width=20% align=right>";
echo "<img src=http://www.thebhg.org/cache/kabal/daichi.png>";
echo "</td></tr></table>";
echo "</td></tr>";

if ($exp > time()) {

echo "<tr><td align=center>";
echo $desc;
echo "<br>";
echo "</td></tr>";

// For image //

if ($type->Hunt_Image()) {
echo "<tr><td align=center>";
echo "<br>";
echo "<img src=huntimage.php?id=";
echo $hunt_id;
echo ">";
echo "<br><br>";
echo "</td></tr>";
}

// For Hunt //

if ($hunt->Hunt_Hunt()) {
echo "<tr><td align=center>";
echo "<br>";
echo $hunt->Hunt_Hunt();
echo "<br><br>";
echo "</td></tr>";
}

$login = $_COOKIE["BHGLogin_id"];

echo "<tr><td align=center>";
echo "<br>";
echo "<form method=post action=hunt.php>";

echo "<table cellspacing=0 cellpadding=0 border=0 width=96%>";
include_once 'roster.inc';
$login = $_COOKIE["BHGLogin_id"];

$roster = new Roster();
$person = $roster->GetPerson($login);
$divi = $person->getDivision();
$kabal = $divi->GetID();

if ($kabal == 3){
if ($type->Hunt_Reason()) {
echo "<tr><td width=50% valign=top><b>";
echo "Reasoning: ";
echo "</b><td width=50%>";
echo "<input type=hidden name=reason value=yes>";
echo "<textarea name=reasoning rows=1 cols=40></textarea>";
echo "</td></tr>";
echo "<tr><td colspan=2><hr></td></tr>";
}

echo "<tr><td width=50% valign=top><b>";
echo "Answer: ";
echo "</b><td width=50% rowspan=2>";

if ($type->Hunt_Options()) {

$i = 0;

echo "<input type=hidden name=options value=".$hunt->Hunt_Options().">";

while ($i < $hunt->Hunt_Options()) {

echo "<input type=text size=100 name=ans_".$i.">";

$i++;

}

} else {

echo "<textarea name=answer rows=3 cols=40></textarea>";

}
echo "</td></tr>"; 
echo "<tr><td align=center>";
echo "<hr width=96%>";
echo "<input type=hidden name=action value=process>";
echo "<input type=hidden name=hunt_call value=".$hunt_id.">";
echo "<input type=hidden name=bhg_id value=".$login.">";
echo "<INPUT TYPE=submit VALUE='Turn in Target'>";
echo "</td></tr>"; 

} else {
echo "Sorry, Daichi Kabal hunts are only avilable to Daichi Kabal Members. If you are a member of Daichi Kabal, please <a href=login.php>Login</a>.";
}
echo "</table>";
echo "<br>";
echo "</form>";
echo "</td></tr>";

} else {
echo "<tr><td align=center>";

if ($graded){
echo "This hunt has already been graded.";
} else {
echo "Sorry, this hunt has expired.";
}
echo "</td></tr>";
}
echo "</td></tr>
</table>";
} else {
echo "<center>Sorry, no hunts match your criteria. Try being less shallow.";
}
?>