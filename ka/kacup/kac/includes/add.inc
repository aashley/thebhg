<?

echo "<table cellspacing=0 cellpadding=0 bordercolor=#000000 border=1 align=center STYLE='border-collapse: collapse' width=98%>";

echo "<form enctype='multipart/form-data' method=POST action=admin.php>";
echo "<tr><td width=25%>";
echo "Hunt Type";
echo "<td width=75%>";

$sql = "SELECT * FROM kac_types";
$query = mysql_query($sql);
$event = mysql_fetch_array($query);

echo "<SELECT SIZE=1 NAME=type>";
while ($event = mysql_fetch_array($query)) {
echo "<OPTION VALUE=";
echo $event['id'];
echo ">";
echo $event['name'];
echo "</OPTION>";
}
echo "</TD></TR>";

echo "<tr><td width=25% valign=top>";
echo "Event";
echo "<td width=75%>";
echo "<textarea name=event rows=1 cols=40></textarea>";
echo "</TD></TR>";

echo "<tr><td width=25% valign=top>";
echo "Answer";
echo "<td width=75%>";
echo "<textarea name=answer rows=1 cols=40></textarea>";
echo "</TD></TR>";

echo "<tr><td width=25% valign=top>";
echo "Image";
echo "<td width=75%>";
echo "<input type=hidden name=MAX_FILE_SIZE value=30000000>";
echo "<input name=image type=file>";
echo "</TD></TR>";

echo "<input type=hidden name=op value=add>";
echo "<input type=hidden name=action value=process>";

echo "<input type=hidden name=action value=process>";
echo "<tr><td width=25% colspan=2 align=center>";
echo "<INPUT TYPE=submit VALUE='Submit Event'>";
echo "</TD></TR>";

echo "</form>";
echo "</TD></TR>
</TABLE>";
?>
