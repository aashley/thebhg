<h2>Per month Bounty Statistics</h2>
<?php
$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
echo "<table>\n"
   . "<caption>Limit Displayed Bounties to those for:</caption>\n"
   . "<tr>\n<td>\n"
   . "<form action=\"".$_SERVER['REQUEST_URI']."\" method=\"get\">\n"
   . "<input type=\"hidden\" name=\"site\" value=\"".$_GET['site']."\" />\n"
   . "<select name=\"division_select\" id=\"division_select\">\n"
   . "<option value=\"-1\"";
if ($_REQUEST['division_select'] == -1) echo " selected";
echo ">Everyone</option>\n"
   . "<option value=\"18\"";
if ($_REQUEST['division_select'] == 18) echo " selected";
echo ">Citadel</option>\n";
$divisions = $roster->GetDivisions();
foreach ($divisions as $division_obj) {
    if ($division_obj->IsKabal()) {
        echo "<option value=\"".$division_obj->GetID()."\"";
        if ($division_obj->GetID() == $_REQUEST['division_select']) echo " selected";
        echo ">".$division_obj->GetName()."</option>\n";
    }
}
echo "</select>\n"
   . "<input type=\"submit\" value=\"View Division\"></input><br />\n"
   . "</form>\n"
   . "</td>\n</tr>\n";
if (!isset($_REQUEST['division_select'])) {
    $division = -1;
} else {
    $division = $_REQUEST['division_select'];
}
echo "<tr>\n<td>\n"
   . "Select month to view:<br />"
   . "<form action=\"".$_SERVER['REQUEST_URI']."\" method=\"post\">\n"
   . "<input type=\"hidden\" name=\"division_select\" value=\"".$division."\"></input>"
   . "<select name=\"month_select\" id=\"month_select\">\n";
if (isset($_POST['month_select'])) $monthcheck = mktime(0, 0, 0, $_POST['month_select']);
else $monthcheck = time();
if (isset($_POST['year_select'])) $yearcheck = mktime(0, 0, 0, $_POST['year_select']);
else $yearcheck = time();
for ($i = 0; $i < 12; $i++) {
    echo '<option value="'.($i + 1).'"';
    if (date('n', $monthcheck) == ($i + 1)) echo " selected";
    echo '>'.$months[$i]."</option>\n";
}
echo "</select>\n";
echo "<select name=\"year_select\" id=\"year_select\">\n";
for ($i = (intval(date("Y")) - 2003); $i >= 0; $i--) {
    $year = mktime(0, 0, 0, 1, 1, (2003 + $i));
    echo '<option value="'.date('Y', $year).'"';
    if (date('Y', $yearcheck) == date('Y', $year)) echo " selected";
    echo '>'.date('Y', $year)."</option>\n";
}
echo "</select>\n"
   . "<input type=\"submit\" value=\"Select Month\"></input><br />\n"
   . "</form>\n";
echo "</td>\n</tr>\n</table>\n";
if ((!isset($_POST['month_select'])) || (!isset($_POST['year_select']))) {
    $smonth = mktime(0, 0, 0, intval(date('n')), 1, intval(date('Y')));
    $emonth = mktime(23, 59, 59, (intval(date('n')) + 1), 0, intval(date('Y')));
} else {
    $smonth = mktime(0, 0, 0, intval($_POST['month_select']), 1, intval($_POST['year_select']));
    $emonth = mktime(23, 59, 59, (intval($_POST['month_select']) + 1), 0, intval($_POST['year_select']));
}

$ka->RenderStats($division, $smonth, $emonth);
?>
