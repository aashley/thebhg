<?

echo "<table cellspacing=0 cellpadding=0 bordercolor=#000000 border=1 align=center STYLE='border-collapse: collapse' width=98%>";

echo "<form enctype='multipart/form-data' method=POST action=add_hunt.php>";
echo "<tr><td width=25%>";
echo "Hunt Type";
echo "<td width=75%>";

$sql = "SELECT * FROM hunt_info";

$query = mysql_query($sql);

echo "<SELECT SIZE=1 NAME=hunt_type>";
while ($hunt = mysql_fetch_array($query)) {
echo "<OPTION VALUE=";
echo $hunt['id'];
echo ">";
echo $hunt['name'];
echo "</OPTION>";
}
echo "</TD></TR>";

echo "<tr><td width=25% valign=top>";
echo "Hunt";
echo "<td width=75%>";
echo "<textarea name=hunter rows=1 cols=40></textarea>";
echo "</TD></TR>";

echo "<tr><td width=25% valign=top>";
echo "Answer";
echo "<td width=75%>";
echo "<textarea name=answer rows=1 cols=40></textarea>";
echo "</TD></TR>";

echo "<tr><td width=25% valign=top>";
echo "Reasoning";
echo "<td width=75%>";
echo "<textarea name=reasoning rows=1 cols=40></textarea>";

echo "<tr><td width=25% valign=top>";
echo "Number of Options";
echo "<td width=75%>";
echo "<input type=text name=options size=5>";
echo "</TD></TR>";

echo "<tr><td width=25% valign=top>";
echo "Image";
echo "<td width=75%>";
echo "<input type=hidden name=MAX_FILE_SIZE value=30000000>";
echo "<input name=image type=file>";
echo "</TD></TR>";

echo "<tr><td width=25% valign=top>";
echo "Fake ID BHG ID number";
echo "<td width=75%>";
echo "<input type=text name=fake>";
echo "</TD></TR>";

echo "<tr><td width=25% valign=top>";
echo "Cypher Code - Type 1";
echo "<td width=75%>";
echo "<input type=text name=cypher1>";
echo "</TD></TR>";

echo "<tr><td width=25% valign=top>";
echo "Cypher Code - Type 2";
echo "<td width=75%>";
echo "<input type=text name=cypher2>";
echo "</TD></TR>";

echo "<tr><td width=25% valign=top>";
echo "Nerd Code - Binary";
echo "<td width=75%>";
echo "<input type=text name=nerdcypher1>";
echo "</TD></TR>";

echo "<tr><td width=25% valign=top>";
echo "Nerd Code - Hexidecimal";
echo "<td width=75%>";
echo "<input type=text name=nerdcypher2>";
echo "</TD></TR>";

echo "<input type=hidden name=action value=process>";
echo "<tr><td width=25% colspan=2>";
echo "<INPUT TYPE=submit VALUE='Submit Hunt'>";
echo "</TD></TR>";

echo "</form>";
echo "</TD></TR>
</TABLE>";
?>
