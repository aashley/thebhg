<?

if ($action == "process"){

if ($ends < $starts){
echo "A Kabal Authority Cup season can not end before it starts. Hit back and try again.";
} else {

$st = explode("-", $starts);
$en = explode("-", $ends);

$start = mktime (0,0,0,$st[0],$st[1],$st[2]);
$end = mktime (0,0,0,$en[0],$en[1],$en[2]);

$run = new NewSeason($start, $end);

if ($run){
echo "New season started! Season ";
echo $run->write;
echo " will being on ";
echo $starts;
echo "!";
} else {
echo $run->write;
}
}

} else {

echo "<table cellspacing=0 cellpadding=0 bordercolor=#000000 border=1 align=center STYLE='border-collapse: collapse' width=98%>";

echo "<form method=POST action=index.php>";
echo "<tr><td width=25% align=center colspan=2>";
echo "Begin new Kabal Authority Season";

echo "<tr><td width=25% valign=top>";
echo "Start Date (mm-dd-yyyy)";
echo "<td width=75%>";
echo "<input type=text name=starts>";
echo "</TD></TR>";

echo "<tr><td width=25% valign=top>";
echo "End Date (mm-dd-yyyy)";
echo "<td width=75%>";
echo "<input type=text name=ends>";
echo "</TD></TR>";

echo "<input type=hidden name=op value=season>";
echo "<input type=hidden name=action value=process>";

echo "<tr><td width=25% colspan=2 align=center>";
echo "<INPUT TYPE=submit VALUE='Start New Season'>";
echo "</TD></TR>";

echo "</form>";
echo "</TD></TR>
</TABLE>";
}
?>
