 <?php
//Includes, and useful objects.
$login = new Login_HTTP();
$login_division = $login->GetDivision();
$login_id = $login->GetID();
$login_position = $login->GetPosition();
$access = $ka->HasAccess($login_id);

/**
 * Renumbers the keys from 0 to the number of keys
 * @param array $to_sort Array to sort
 * @return array Sorted array
 * @access public
 * @author SyNthetiC PaRadoX <synthparadox@hotmail.com>
 */
function array_resort($to_sort) {
    $another = array();
    foreach ($to_sort as $item) {
        $another[] = $item;
    }
    return $another;
}

print '<div>';
echo "<h2>The KA Hunt Center</h2>\n";
echo "<p>Here, members of the BHG can browse through the contracts that are sent to this organization, attempting to hunt down culprits in return for healthy sums of credits. Below are listed the current contracts. Best of luck, Hunter. Solving missions in the BHG is rarely an easy task. Think that you can do it? Prove your mettle, and earn your credits, by using the links below.</p>\n";
echo "<p>If anyone wishes to submit an event please contact me personally. Credits will always be paid out to hunters creating Trivia for me to use or creating other types of events. I am also always looking for new event ideas. Any questions, or events to be mailed to <a href=\"mailto:".$judicator->GetEmail()."\">".$judicator->GetName()."</a>.</p>\n";
if (($login_position->GetID() == 6) || ($login_position->GetID() == 8)) echo '<p><a href="/manuals/index.php?site=jud_admin">JUD/PR\'s Admin</a></p>'."\n";
echo '</div>';

if (!isset($_POST['num_months'])) {
    $show_months = 1;
} else {
    $show_months = $_POST['num_months'];
}

echo '<div>'."\n";
echo '<h2>Limit Displayed Hunts:</h2>'."\n";
echo "<form action=\"".$_SERVER['REQUEST_URI']."\" method=\"post\">\n";
if ($access == 2) {
    echo "<select name=\"division_select\" id=\"division_select\">\n";
    echo "<option value=\"-1\"";
    if ($_POST['division_select'] == -1) echo ' selected="selected"';
    echo ">Everyone</option>\n";
    echo "<option value=\"18\"";
    if ($_POST['division_select'] == 18) echo ' selected="selected"';
    echo ">Citadel</option>\n";
    $divisions = $roster->GetDivisions();
    foreach ($divisions as $division_obj) {
        if ($division_obj->IsKabal()) {
            echo "<option value=\"".$division_obj->GetID()."\"";
            if ($division_obj->GetID() == $_POST['division_select']) echo ' selected="selected"';
            echo ">".$division_obj->GetName()."</option>\n";
        }
    }
    echo "</select>\n";
}
echo '<br />Show hunts from <input type="text" name="num_months" value="'.$show_months.'" size="5"></input> months ago.<br />'
   . '<input type="submit" value="View"></input>'
   . "</div><br />\n";


$no_all = false;
if (!isset($_POST['division_select'])) {
    $division_num = $login_division->GetID();
}
else {
    $division_num = $_POST['division_select'];
    if ($division_num != -1) $no_all = true;
}

$hunttypes = $ka->GetHuntTypes();
$headattr = array(
    'style' => 'font-weight: bold; font-size: 10pt; text-align: center'
    );
$center_attr = array(
    'style' => 'font-size: 10pt; text-align: center; border: 0px'
    );
$full_width = array(
    'style' => 'width: 100%'
    );

$smonth = time() - (2592000 * $show_months); //Current time minus 30 days times number of months
/**
 * Creates the array to be used in the table
 * Active hunts that one has not submitted for yet
 */
$htheader = array();
$htbody = array();
for ($i = 0; $i < count($hunttypes); $i++) {
    $hunts = $ka->GetHunts('none', 'active', $hunttypes[$i]->GetID(), $division_num, $no_all);

    foreach ($hunts as $hunt) {

        if (!$hunt->HasSubmitted($login->GetID())) {

            $htbody[$i] .= '<a href="'.$_SERVER['PHP_SELF']
              .'?site=display_hunt&id='.$hunt->GetID().'">';
            if ($hunt->GetDivisionID() != -1) {
                $division = $hunt->GetDivision();
                $htbody[$i] .= $division->GetName().' - ';
            }
            $htbody[$i] .= $hunttypes[$i]->GetAbbr().' '.$hunt->GetHuntNum().'</a><br />';
            $htheader[$i] = $hunttypes[$i]->GetName();
        }

    }
}
$htheader = array_resort($htheader);
$htbody = array_resort($htbody);
//Makes a Table to put the array in
$table = new HTML_Table($full_width);
if ((count($htheader) != 0) && (count($htbody) != 0)) {
    $table->addRow($htheader,
                   $headattr,
                   'TH');
    $table->addRow($htbody, $center_attr);
}
else {
    $table->addRow(array('-None-'), $center_attr);
}
$table->setCaption('The following activities are currently available for you:');
print $table->toHTML();


/**
 * Creates the array to be used in the table
 * Active hunts that one has submitted for already
 */
$htheader = array();
$htbody = array();
for ($i = 0; $i < count($hunttypes); $i++) {
    $hunts = $ka->GetHunts('none', 'active', $hunttypes[$i]->GetID(), $division_num, $no_all);

    foreach ($hunts as $hunt) {

        if ($hunt->HasSubmitted($login->GetID())) {

            $htbody[$i] .= '<a href="'.$_SERVER['PHP_SELF']
              .'?site=display_hunt&id='.$hunt->GetID().'">';
            if ($hunt->GetDivisionID() != -1) {
                $division = $hunt->GetDivision();
                $htbody[$i] .= $division->GetName().' - ';
            }
            $htbody[$i] .= $hunttypes[$i]->GetAbbr().' '.$hunt->GetHuntNum().'</a><br />';
            $htheader[$i] = $hunttypes[$i]->GetName();
        }

    }
}
$htheader = array_resort($htheader);
$htbody = array_resort($htbody);
//Makes a Table to put the array in
$table = new HTML_Table($full_width);
if ((count($htheader) != 0) && (count($htbody) != 0)) {
    $table->addRow($htheader,
                   $headattr,
                   'TH');
    $table->addRow($htbody, $center_attr);
}
else {
    $table->addRow(array('-None-'), $center_attr);
}
$table->setCaption('Here are hunts you have already submitted for:');
print $table->toHtml();


/**
 * Creates the array to be used in the table
 * Past hunts, last 30 days * number of months only
 */
$htheader = array();
$htbody = array();
for ($i = 0; $i < count($hunttypes); $i++) {
    $hunts = $ka->GetHunts('end', 'past', $hunttypes[$i]->GetID(), $division_num, $no_all, $smonth);

    foreach ($hunts as $hunt) {

        $htbody[$i] .= '<a href="'.$_SERVER['PHP_SELF']
          .'?site=display_hunt&id='.$hunt->GetID().'">';
        if ($hunt->GetDivisionID() != -1) {
            $division = $hunt->GetDivision();
            $htbody[$i] .= $division->GetName().' - ';
        }
        $htbody[$i] .= $hunttypes[$i]->GetAbbr().' '.$hunt->GetHuntNum().'</a><br />';
        $htheader[$i] = $hunttypes[$i]->GetName();

    }
}
$htheader = array_resort($htheader);
$htbody = array_resort($htbody);
//Makes a Table to put the array in
$table = new HTML_Table($full_width);
if ((count($htheader) != 0) && (count($htbody) != 0)) {
    $table->addRow($htheader,
                   $headattr,
                   'TH');
    $table->addRow($htbody, $center_attr);
}
else {
    $table->addRow(array('-None-'), $center_attr);
}
$table->setCaption('View the results of past hunts:');
print $table->toHtml();


/**
 * Submissions
 * Lists all the submissions you've submitted in the last 30 days * number of months to show.
 */
$submissions = $ka->GetAllSubmissions($login_id, $smonth);
$table = new HTML_Table();
$table->setCaption('View your submissions:');
$table->addRow(array(   'Event',
                        'Date and Time'),
               $headattr,
               'TH');
if (sizeof($submissions) > 0) {
  foreach ($submissions as $submission) {
    $hunt = $submission->GetHunt();
    $hunttype = $hunt->GetHuntType();
    $table->addRow(array('<a href="'.$_SERVER['PHP_SELF'].'?site=display_sub'
                        .'&id='.$submission->GetID().'">'.$hunttype->GetName()
                        .' '.$hunt->GetHuntNum().'</a>',
                        date("jS M Y, H:i T", $submission->GetTimestamp())), $center_attr);
  }
} else {
  $table->addRow(array('You have not submitted answers to any Kabal Authority '
        .'Hunts'));
}
print $table->toHtml();


?>
