<?

if ($action == "process"){

$new = New_Event($title, $evevt, $year, $month, $day, $refine_to)

if ($new != 0) {

echo "New Event Added - Event ID: ";
echo $new;

} else {

echo $new->error;

}

} else {

echo "<table border=0 align=left width=100%>";
echo "<form method=post action=add.php>";

echo "<TR><TD>";
echo "Title: ";
echo "<input type=text name=title>";
echo "</TD></TR>";

echo "<TR><TD>";
echo "Event: ";
echo "<br>";
echo "<textarea name=event rows=20 cols=60></textarea>";
echo "</TD></TR>";

echo "<TR><TD>";
echo "Day: ";
echo "<input type=text size=4 name=year>";
echo "</TD></TR>";

echo "<TR><TD>";
echo "Month: ";
echo "<input type=text size=4 name=month>";
echo "</TD></TR>";

echo "<TR><TD>";
echo "Year: ";
echo "<input type=text size=4 name=day>";
echo "</TD></TR>";

echo "<TR><TD>";
echo "Refine to: ";
echo "<SELECT SIZE=1 NAME=refine_to>";
echo "<OPTION VALUE=1>Years</OPTION>";
echo "<OPTION VALUE=2>Months</OPTION>";
echo "<OPTION VALUE=3>Days</OPTION>";
echo "</SELECT>";
echo "</TD></TR>";

echo "<TR><TD>";
echo "<INPUT TYPE=submit VALUE='Submit Record'>";
echo "</TD></TR>";

echo "<TR><TD>";
echo "<INPUT TYPE=reset VALUE='Reset Form'>";
echo "</TD></TR>";

echo "<INPUT TYPE=hidden Name=action VALUE=process>";
echo "</form>";
echo "</table>";
}
?>