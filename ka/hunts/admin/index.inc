<?php /* To fool Vim */ ?>
<div>
<h2>Kabal Authority Hunts Administration</h2>
<p>Welcome to the Kabal Authority Hunts Administration Center. From here you can
create Hunt Types and Individual Hunts. You can also grade and manage
submissions from previous hunts.</p>
</div>
<?php
if (!isset($_POST['num_months'])) {
    $show_months = 1;
} else {
    $show_months = $_POST['num_months'];
}

echo '<div>'."\n";
echo '<h2>Limit Displayed Hunts:</h2>'."\n";
echo "<form action=\"".$_SERVER['REQUEST_URI']."\" method=\"post\">\n";
if ($access == 2) {
    echo "<select name=\"division\" id=\"division\">\n";
    echo "<option value=\"-1\"";
    if ($division == -1) echo " selected=\"selected\"";
    echo ">Everyone</option>\n";
    echo "<option value=\"18\"";
    if ($division == 18) echo " selected=\"selected\"";
    echo ">Citadel</option>\n";
    $divisions = $roster->GetDivisions();
    foreach ($divisions as $division_obj) {
        if ($division_obj->IsKabal()) {
            echo "<option value=\"".$division_obj->GetID()."\"";
            if ($division_obj->GetID() == $division) echo " selected=\"selected\"";
            echo ">".$division_obj->GetName()."</option>\n";
        }
    }
    echo "</select>\n";
    echo "<input type=\"submit\" value=\"View Division\"></input><br />\n";
}
echo '<br />Show hunts from <input type="text" name="num_months" value="'.$show_months.'" size="5"></input> months ago.<br />'
   . '<input type="submit" value="View"></input>'
   . "</form></div><br />\n";
$smonth = time() - (2592000 * $show_months); //Current time minus 30 days times number of months
$tblhead = array(
    'Hunt Type',
    'Hunt #',
    'Begin Date',
    'End Date',
    'Functions'
    );
$tblheadattr = array(
    'style' => 'font-weight: bold; font-size: 10pt'
    );
$alt1 = array(
    'style' => 'border: 0px; background: #2f2f2f url(\'/images/background3.jpg\') no-repeat fixed 70px 75px'
    );
$alt2 = array(
    'style' => 'border: 0px; background: #555555 url(\'/images/background2.jpg\') no-repeat fixed 70px 75px'
    );
?>
<!--Future Hunts Table Start-->
<?php
$table = new HTML_Table();
$table->setCaption("Future Hunts");
$futurehunts = $ka->GetHunts('none', 'future', -1, $division, true);
$table->AddRow(
    $tblhead,
    $tblheadattr,
    'TH'
    );
foreach ($futurehunts as $hunt) {
    $hunt_type = $hunt->GetHuntType();
    $table->AddRow(
        array(
            $hunt_type->GetName(),
            $hunt->GetHuntNum(),
            date('D, M j, Y', $hunt->GetStartTimestamp()),
            date('D, M j, Y', $hunt->GetEndTimestamp()),
            "<a href=\"".$_SERVER['PHP_SELF']."?site=modify_hunt&amp;id=".$hunt->GetID()."\">Edit</a>"
            . "&nbsp;&nbsp;"
            . "<a href=\"".$_SERVER['PHP_SELF']."?site=delete_hunt&amp;id=".$hunt->GetID()."\">Delete</a>"
        )
    );
}
$table->altRowAttributes(1, $alt1, $alt2);
echo $table->toHTML();
?>
<!--Future Hunts Table End-->

<!--Active Hunts Table Start-->
<?php
$table = new HTML_Table();
$table->setCaption("Currently Active Hunts");
$activehunts = $ka->GetHunts('none', 'active', -1, $division, true);
$table->AddRow(
    $tblhead,
    $tblheadattr,
    'TH'
    );
foreach ($activehunts as $hunt) {
    $hunt_type = $hunt->GetHuntType();
    $table->AddRow(
        array(
            $hunt_type->GetName(),
            $hunt->GetHuntNum(),
            date('D, M j, Y', $hunt->GetStartTimestamp()),
            date('D, M j, Y', $hunt->GetEndTimestamp()),
            "<a href=\"".$_SERVER['PHP_SELF']."?site=modify_hunt&amp;id=".$hunt->GetID()."\">Edit</a>"
            . "&nbsp;&nbsp;"
            . "<a href=\"".$_SERVER['PHP_SELF']."?site=delete_hunt&amp;id=".$hunt->GetID()."\">Delete</a>"
        )
    );
}
$table->altRowAttributes(1, $alt1, $alt2);
echo $table->toHTML();
?>
<!--Active Hunts Table End-->

<!--Past Hunts Table Start-->
<?php
$table = new HTML_Table();
$table->setCaption("Past Hunts");
$pasthunts = $ka->GetHunts('end', 'past', -1, $division, true, $smonth);
$table->AddRow(
    $tblhead,
    $tblheadattr,
    'TH'
    );
foreach ($pasthunts as $hunt) {
    $hunt_type = $hunt->GetHuntType();
    if (!$hunt->IsGraded()) $grade_str = "&nbsp;&nbsp;<a href=\"".$_SERVER['PHP_SELF']."?site=grade_hunt&amp;id=".$hunt->GetID()."\">Grade</a>";
    if ($access == 2) $edit_str = "<a href=\"".$_SERVER['PHP_SELF']."?site=modify_hunt&amp;id=".$hunt->GetID()."\">Edit</a>&nbsp;&nbsp;";
    $table->AddRow(
        array(
            $hunt_type->GetName(),
            $hunt->GetHuntNum(),
            date('D, M j, Y', $hunt->GetStartTimestamp()),
            date('D, M j, Y', $hunt->GetEndTimestamp()),
            "<a href=\"".$_SERVER['PHP_SELF']."?site=grade_edit&amp;id=".$hunt->GetID()."\">Edit Grades</a>"
            . "&nbsp;&nbsp;"
            . $edit_str
            . "<a href=\"".$_SERVER['PHP_SELF']."?site=delete_hunt&amp;id=".$hunt->GetID()."\">Delete</a>"
            . $grade_str
        )
    );
    $grade_str = "";
}
$table->altRowAttributes(1, $alt1, $alt2);
echo $table->toHTML();
?>
<!--Past Hunts Table End-->
