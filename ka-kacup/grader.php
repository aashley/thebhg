<?
include('Objects/kabal_hunts.inc');

$connine = new Kabal_Hunts();

$hunt = $id;

$sql = "SELECT * FROM complete where hunt = '$hunt' AND place = 0";

$result = mysql_query($sql);

$get = $hunt;

if (mysql_num_rows($result) > 0){

$call = mysql_fetch_array($result);

$base = new Hunt($call['hunt']);

$info = $base->Hunt_Info();
$reas = $base->Hunt_Reason();
$ans = $base->Hunt_Answer();

$answer = $info->Hunt_Answer();
$options = $info->Hunt_Options();
$reason = $info->Hunt_Reason();
$pic = $info->Hunt_Image();

echo "<table cellpadding=0 cellspacing=0 border=1 STYLE='border-collapse: collapse' width=100%>";
echo "<tr><td align=center colspan=2>";
echo "Hunt Information";
echo "</td></tr>";

if ($answer) {
echo "<tr><td align=center>";
echo "Hunt Answer";
echo "<td align=center>";
echo $ans;
echo "</td></tr>";
}

if ($reason) {
echo "<tr><td align=center>";
echo "Reasoning";
echo "<td align=center>";
echo $reas;
echo "</td></tr>";
}

if ($pic) {
echo "<tr><td align=center>";
echo "Image";
echo "<td align=center>";
echo "<img src=huntimage.php?id=";
echo $call['hunt'];
echo ">";
echo "</td></tr>";
}

echo "</table><br><br>";

$i = 0;
echo "<form method=post action=grade.php>";
$sql = "SELECT * FROM complete where hunt = '$hunt' AND place = 0";

$result = mysql_query($sql);
while ($hunt = mysql_fetch_array($result)){

$per_id = $hunt['bhg_id'];
$answer = $hunt['answer'];
$sub = getdate($hunt['date']);
$ip = $hunt['ipaddress'];
$posted = $sub[mon].'/'.$sub[mday].'/'.$sub[year].' '.$sub[hours].':'.$sub[minutes].':'.$sub[seconds];

include_once ('roster.inc');
$roster = new Roster();

$per = $roster->GetPerson($per_id);

$name = $per->GetName();
$rank = $per->GetRank();

$rank_name = $rank->GetName();

echo "<Input type=hidden NAME=bhg_id_";
echo $i;
echo " value= ";
echo $per_id;
echo ">";

echo "<table cellpadding=0 cellspacing=0 border=1 STYLE='border-collapse: collapse' width=100%>";

echo "<TR><TD width=33%>";
echo "Hunter: ";
echo $rank_name;
echo " ";
echo $name;

echo "<TD width=33%>";
echo "IP: ";
echo $ip;

echo "<TD width=33%>";
echo "Hunt completed: ";
echo $posted;

echo "</TD></TR>";

echo "<TR><TD colspan=3>";
echo "Answer: ";
echo $answer;
echo "</TD></TR>";

echo "<TR><TD colspan=3>";
echo "Place: ";
echo "<SELECT SIZE=1 NAME=answer_";
echo $i;
echo ">";
echo "<OPTION VALUE=2>Correct Answer</OPTION>";
echo "<OPTION VALUE=1>First Place</OPTION>";
echo "<OPTION VALUE=3>Incorrect Answer</OPTION>";
echo "<OPTION VALUE=4>No Effort</OPTION>";
echo "</SELECT>";
echo "</TD></TR>";
echo "</TABLE><BR><BR>";
$i++;
}
echo "<input type=hidden name=hunt value=";
echo $get;
echo ">";
echo "<input type=hidden name=action value=process>";
echo "<input type=hidden name=total value=".$i.">";
echo "<center>";
echo "<INPUT TYPE=submit VALUE='Submit Grades'>";
} else {
echo "<form method=post action=grade.php>";
echo "<center>Sorry, no results for this exam.<br>";
echo "<input type=hidden name=action value=finish>";
echo "<input type=hidden name=kill value=";
echo $get;
echo ">";
echo "<INPUT TYPE=submit VALUE='Finish hunt'>";
}
echo "</form>";


?>