<?
include('Objects/kabal_hunts.inc');

$connine = new Kabal_Hunts();
$hunt = new Hunt($id);
$exp = $hunt->Hunt_Expire();
$time = time();
$graded = $hunt->Hunt_Graded();
$hunt_id = $hunt->Hunt_ID();
$expires = $hunt->Hunt_Expire();
$ans = $hunt->Hunt_Answer();
$first = $hunt->First_Place();
$correct = $hunt->Correct();
$incorrect = $hunt->Incorrect();
$noeffort = $hunt->Noeffort();

$exp = $hunt->Hunt_Expire();
$type = $hunt->Hunt_Info();
$abbr = $type->Hunt_Abbr();
$name = $type->Hunt_Name();
$desc = $type->Hunt_Desc();

$fcount = count($first);
$ccount = count($correct);
$icount = count($incorrect);
$ncount = count($noeffort);

if ($hunt_id) {

if ($time > $expires){

if ($graded == 1){

if ($type == 3) {

echo "<tr><td align=center>";
echo "<br>";
echo "<img src=huntimage.php?id=";
echo $hunt_id;
echo ">";
echo "<br><br>";
echo "</td></tr>";

echo "<tr><td align=center>";
echo "Best Caption: ";
if ($fcount == 0){
echo "<br><font size=1>";
echo "No superior caption";
echo "</td></tr>";
} else {

$i = 0;

while ($i < $fcount){
$bhg_id = $first[$i];
$cap = new Answer($id, $bhg_id);

echo "<br>";
echo $cap->GetAnswer();
echo "<br>";
echo "~<a href=http://holonet.thebhg.org/index.php?module=roster&page=hunter&id=";
echo $bhg_id;
echo ">";
include_once('roster.inc');
$roster = new Roster();
$person = $roster->GetPerson($bhg_id);
$name = $person->getName();
echo $name;
echo "</a>";

$i++;
}
echo "</td></tr>";
}

include('Objects/kabal_hunts.inc');

$connine = new Kabal_Hunts();

echo "<tr><td align=center>";
echo "Other Caption: ";
if ($ccount == 0){
echo "<br><font size=1>";
echo "No other captions";
echo "</td></tr>";
} else {

$i = 0;

while ($i < $ccount){
$bhg_id = $correct[$i];
$cap = new Answer($id, $bhg_id);

echo "<br>";
echo $cap->GetAnswer();
echo "<br>";
echo "~<a href=http://holonet.thebhg.org/index.php?module=roster&page=hunter&id=";
echo $bhg_id;
echo ">";

include_once('roster.inc');
$roster = new Roster();
$person = $roster->GetPerson($bhg_id);
$name = $person->getName();
echo $name;
echo "</a>";

$i++;
}
echo "</td></tr>";
}

include('Objects/kabal_hunts.inc');

$connine = new Kabal_Hunts();

} else {

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

// Answer //

if ($type->Hunt_Answer()) {
echo "<tr><td align=center>";
echo "Correct Answer: ";
echo "<br>";
echo $ans;
echo "</td></tr>";
}

// Reasoning //

if ($type->Hunt_Reason()) {
echo "<tr><td width=50% valign=top><b>";
echo "Reasoning: ";
echo "</b><td width=50%>";
echo "<input type=hidden name=reason value=yes>";
echo "<textarea name=reasoning rows=1 cols=40></textarea>";
echo "</td></tr>";
echo "<tr><td colspan=2><hr></td></tr>";
}

echo "<tr><td align=center>";

include_once('roster.inc');
echo "<table border=0 cellspacing=0 cellpadding=0>";
echo "<tr><td align=center>";
echo "First Place: ";
echo "</td></tr>";
if ($fcount == 0){
echo "<tr><td align=center><font size=1>";
echo "No first place finishes";
echo "</td></tr>";
} else {

$i = 0;

while ($i < $fcount){
$bhg_id = $first[$i];
$roster = new Roster();
$person = $roster->GetPerson($bhg_id);
$name = $person->getName();

echo "<tr><td align=center><a href=http://holonet.thebhg.org/index.php?module=roster&page=hunter&id=";
echo $bhg_id;
echo ">";
echo $name;
echo "</a></td></tr>";

$i++;
}

}

echo "<TR><TD align=center>
&nbsp
</TD></TR>";

echo "<tr><td align=center>";
echo "Correct Answers: ";
echo "</td></tr>";
if ($ccount == 0){
echo "<tr><td align=center><font size=1>";
echo "No correct answers";
echo "</td></tr>";
} else {

$i = 0;

while ($i < $ccount){
$bhg_id = $correct[$i];
$roster = new Roster();
$person = $roster->GetPerson($bhg_id);
$name = $person->getName();

echo "<tr><td align=center><a href=http://holonet.thebhg.org/index.php?module=roster&page=hunter&id=";
echo $bhg_id;
echo ">";
echo $name;
echo "</a></td></tr>";

$i++;
}

}

echo "<TR><TD align=center>
&nbsp
</TD></TR>";


echo "<tr><td align=center>";
echo "Incorrect Answers: ";
echo "</td></tr>";
if ($icount == 0){
echo "<tr><td align=center><font size=1>";
echo "No incorrect answers";
echo "</td></tr>";
} else {

$i = 0;

while ($i < $icount){
$bhg_id = $incorrect[$i];
$roster = new Roster();
$person = $roster->GetPerson($bhg_id);
$name = $person->getName();

echo "<tr><td align=center><a href=http://holonet.thebhg.org/index.php?module=roster&page=hunter&id=";
echo $bhg_id;
echo ">";
echo $name;
echo "</a></td></tr>";

$i++;
}

}

echo "<TR><TD align=center>
&nbsp
</TD></TR>";


echo "<tr><td align=center>";
echo "Lack of Effort Answers: ";
echo "</td></tr>";
if ($ncount == 0){
echo "<tr><td align=center><font size=1>";
echo "No Lack of Effort answers";
echo "</td></tr>";
} else {

$i = 0;

while ($i < $ncount){
$bhg_id = $noeffort[$i];
$roster = new Roster();
$person = $roster->GetPerson($bhg_id);
$name = $person->getName();

echo "<tr><td align=center><a href=http://holonet.thebhg.org/index.php?module=roster&page=hunter&id=";
echo $bhg_id;
echo ">";
echo $name;
echo "</a></td></tr>";

$i++;
}

}

echo "</table></tr></td>";

}

} else {
echo "This hunt not graded.";
}

} else {
echo "This hunt still active.";
}

} else {
echo "Hunt not found.";
}

echo "</td></tr>
</table>";

?>