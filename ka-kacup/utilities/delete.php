<?

if ($action == "delete") {

$event = new Event($event);
$act = $event->Delete();
$title = $event->GetTitle();

if ($act){
echo "Event '";
echo $title;
echo "' has been deleted.";
}

} elseif ($action == "undelete"){

$event = new Event($event);
$act = $event->Undelete();
$title = $event->GetTitle();

if ($act){
echo "Event '";
echo $title;
echo "' has been deleted.";
}

} else {

echo "<table border=0 align=left width=100%>";
echo "<form method=post action=delete.php>";

echo "<TR><TD>";
echo "Event: ";
echo "<SELECT SIZE=1 NAME=event>";

include_once('variables.inc');

$i = 0;

while ($i < $count){

echo "<OPTION VALUE=";
echo $all[$i];
echo ">";

include_once('objects/core.inc');

$event = new Event($all[$i]);
$title = $event->GetTitle();

echo $title;
echo "</OPTION>";

}

echo "</SELECT>";
echo "</TD></TR>";

echo "<TR><TD>";
echo "Action: ";
echo "<SELECT SIZE=1 NAME=action>";
echo "<OPTION VALUE=delete>Years</OPTION>";
echo "<OPTION VALUE=undelete>Months</OPTION>";
echo "</SELECT>";
echo "</TD></TR>";

}

?>