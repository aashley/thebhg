 <?php
//Includes, and useful objects.
$login = new Login_HTTP();
$login_division = $login->GetDivision();
$login_id = $login->GetID();
$login_position = $login->GetPosition();
$access = $ka->HasAccess($login_id);

print '<div>';
echo "<h2>Old Bounties</h2>\n";
echo "<p>Everyone likes to tell stories of past hunts. Well, what if you wanted to know if they were true? This, the place of the old bounties, is just the place to do it.</p>\n";
echo "<p>Look at all the bounties ever posted and settle that long standing bet here. Please don't spill liquids on the records though. Thanks.</p>\n";
echo '</div>';
if ($access == 2) {
    echo '<div>';
    echo '<h2>Limit Displayed Bounties to those for:</h2>';
    echo "<form action=\"".$_SERVER['REQUEST_URI']."\" method=\"post\">\n";
    echo "<select name=\"division_select\" id=\"division_select\">\n";
    echo "<option value=\"-1\"";
    if ($_POST['division_select'] == -1) echo " selected";
    echo ">Everyone</option>\n";
    echo "<option value=\"18\"";
    if ($_POST['division_select'] == 18) echo " selected";
    echo ">Citadel</option>\n";
    $divisions = $roster->GetDivisions();
    foreach ($divisions as $division_obj) {
        if ($division_obj->IsKabal()) {
            echo "<option value=\"".$division_obj->GetID()."\"";
            if ($division_obj->GetID() == $_POST['division_select']) echo " selected";
            echo ">".$division_obj->GetName()."</option>\n";
        }
    }
    echo "</select>\n";
    echo "<input type=\"submit\" value=\"View Division\"></input><br />\n";
    echo "</form>\n";
    echo '</div>';
}

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
    'style' => 'font-size: 10pt; text-align: center; border: 0px; vertical-align: top'
    );

/**
 * Creates the array to be used in the table
 * Past hunts
 */
$htheader = array();
$htbody = array();
for ($i = 0; $i < sizeof($hunttypes); $i++) {

  $htheader[$i] = $hunttypes[$i]->GetName();
  $htbody[$i] = '';

  $hunts = $ka->GetHunts('none', 'past', $hunttypes[$i]->GetID(), $division_num, $no_all);

  foreach ($hunts as $hunt) {

    $htbody[$i] .= '<a href="'.$_SERVER['PHP_SELF']
      .'?site=display_bounty&id='.$hunt->GetID().'">';
    if ($hunt->GetDivisionID() != -1) {
        $division = $hunt->GetDivision();
        $htbody[$i] .= $division->GetName().' - ';
    }
    $htbody[$i] .= $hunttypes[$i]->GetAbbr().' '.$hunt->GetHuntNum().'</a><br />';

  }

}
//Makes a Table to put the array in
$table = new HTML_Table();
$table->addRow($htheader,
               $headattr,
               'TH');
$table->addRow($htbody, $center_attr);
$table->setCaption('View the results of past bounties:');
print $table->toHtml();


/**
 * Submissions
 * Lists all the submissions you've ever submitted.
 */
$submissions = $ka->GetAllSubmissions($login_id);
$table = new HTML_Table();
$table->setCaption('View your summaries:');
$table->addRow(array(   'Event',
                        'Date and Time'),
               $headattr,
               'TH');
if (sizeof($submissions) > 0) {
  foreach ($submissions as $submission) {
    $hunt = $submission->GetHunt();
    $hunttype = $hunt->GetHuntType();
    $table->addRow(array('<a href="'.$_SERVER['PHP_SELF'].'?site=display_sum'
                        .'&id='.$submission->GetID().'">'.$hunttype->GetName()
                        .' '.$hunt->GetHuntNum().'</a>',
                        date("jS M Y, H:i T", $submission->GetTimestamp())), $center_attr);
  }
} else {
  $table->addRow(array('You have not submitted answers to any Tactician '
        .'Bounties'));
}
print $table->toHtml();


?>
