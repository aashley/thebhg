<?php

  $pagename .= " :: New Cup";
  include('../header.php');
  if (cup_pending() || cup_running()) {
    echo "<p>You cannot create a new cup at this time.</p>\n";
  } else {
    if (isset($_POST['create_new'])) {
      $last_kac_db = mysql_query("SELECT MAX(kac_number) FROM cup_details", $db);
      $kac_number = mysql_result($last_kac_db, 0) + 1;
      for ($i = 1; $i <= 3; $i++) {
        $start_name = 'r'.$i.'_start';
        $$start_name = $_POST[$start_name]." 0:00:00";
        $finish_name = 'r'.$i.'_finish';
        $$finish_name = $_POST[$finish_name]." 23:59:59";
      }
      $kabals = $_POST['kabals'];
      if (mysql_query("INSERT INTO cup_details VALUES(NULL, $kac_number, '$r1_start', '$r1_finish', '$r2_start', '$r2_finish', '$r3_start', '$r3_finish')", $db)) {
        $kac_id_db = mysql_query("SELECT MAX(kac_id) FROM cup_details", $db);
        $kac_id = mysql_result($kac_id_db, 0);
        if (mysql_query("INSERT INTO cup_placings VALUES($kac_id, ".$kabals[0].", ".$kabals[1].", ".$kabals[2].", ".$kabals[3].", ".$kabals[4].", ".$kabals[5].", ".$kabals[6].", 0, 0, 0, 0, 0, 0)", $db)) {
          echo "<p>The new KA Cup has been successfully entered into the database! Please start <a href=\"$PHP_SELF?modify=1\">entering the events</a>.</p>\n";
        } else {
          echo "<p>An error occurred entering the placings details. Please report the error to nightweaver@thebhg.org pronto.</p>\n";
        }
      } else {
        echo "<p>A fatal error occurred entering the details for the new cup. Please report the error to nightweaver@thebhg.org pronto.</p>\n";
      }
    } else {
      echo "<form method=\"post\" action=\"$PHP_SELF?new=1\">\n";
      echo "<input type=\"hidden\" name=\"create_new\" value=\"1\" />\n";
      $placings = get_placings();
      for ($i = 0; $i < 8; $i++) {
        $kabal = new Kabal($placings[$i]);
        $kabals[] = $kabal->GetName();
      }
      echo "<p><b>Starting lineup:</b></p>\n";
      echo "<ul style=\"list-style-type: none;\">\n";
      echo "<li>1st place: ".$kabals[0]." <input type=\"hidden\" name=\"kabals[]\" value=\"".$placings[0]."\" /></li>\n";
      echo "<li>2nd place: ".$kabals[1]." <input type=\"hidden\" name=\"kabals[]\" value=\"".$placings[1]."\" /></li>\n";
      echo "<li>3rd place: ".$kabals[2]." <input type=\"hidden\" name=\"kabals[]\" value=\"".$placings[2]."\" /></li>\n";
      echo "<li>4th place: ".$kabals[3]." <input type=\"hidden\" name=\"kabals[]\" value=\"".$placings[3]."\" /></li>\n";
      echo "<li>5th place: ".$kabals[4]." <input type=\"hidden\" name=\"kabals[]\" value=\"".$placings[4]."\" /></li>\n";
      echo "<li>6th place: ".$kabals[5]." <input type=\"hidden\" name=\"kabals[]\" value=\"".$placings[5]."\" /></li>\n";
      echo "<li>7th place: ".$kabals[6]." <input type=\"hidden\" name=\"kabals[]\" value=\"".$placings[6]."\" /></li>\n";
      echo "</ul>\n";
      echo "<table>\n";
      echo "<tr><td><p>Round One Start Date (YYYY-MM-DD):</p></td><td><input type=\"text\" name=\"r1_start\" value=\"YYYY-MM-DD\" size=\"15\" /></td><td><p>@ 12:00am EST</p></td></tr>\n";
      echo "<tr><td><p>Round One Finish Date (YYYY-MM-DD):</p></td><td><input type=\"text\" name=\"r1_finish\" value=\"YYYY-MM-DD\" size=\"15\" /></td><td><p>@ 11:59pm EST</p></td></tr>\n";
      echo "<tr><td><p>Round Two Start Date (YYYY-MM-DD):</p></td><td><input type=\"text\" name=\"r2_start\" value=\"YYYY-MM-DD\" size=\"15\" /></td><td><p>@ 12:00am EST</p></td></tr>\n";
      echo "<tr><td><p>Round Two Finish Date (YYYY-MM-DD):</p></td><td><input type=\"text\" name=\"r2_finish\" value=\"YYYY-MM-DD\" size=\"15\" /></td><td><p>@ 11:59pm EST</p></td></tr>\n";
      echo "<tr><td><p>Round Three Start Date (YYYY-MM-DD):</p></td><td><input type=\"text\" name=\"r3_start\" value=\"YYYY-MM-DD\" size=\"15\" /></td><td><p>@ 12:00am EST</p></td></tr>\n";
      echo "<tr><td><p>Round Three Finish Date (YYYY-MM-DD):</p></td><td><input type=\"text\" name=\"r3_finish\" value=\"YYYY-MM-DD\" size=\"15\" /></td><td><p>@ 11:59pm EST</p></td></tr>\n";
      echo "</table>\n";
      echo "<p><input type=\"submit\" value=\"New KAC\" /> <input type=\"reset\" /></p>\n";
      echo "</form>\n";
    }
  }
  include('../footer.php');

?>
