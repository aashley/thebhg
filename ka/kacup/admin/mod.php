<?php

  $pagename .= " :: Modify Cup";
  include('../header.php');
  if (!(cup_pending() || cup_running())) {
    echo "<p>There is no cup to modify at this time.</p>\n";
  } else {
    $kac_id = cup_pending();
    if (!$kac_id) { $kac_id = cup_running(); }
    $cup_db = mysql_query("SELECT * FROM cup_details WHERE kac_id=$kac_id", $db);
    $cup = mysql_fetch_array($cup_db, MYSQL_ASSOC);
    $placings_db = mysql_query("SELECT * FROM cup_placings WHERE kac_id=$kac_id", $db);
    $placings = mysql_fetch_array($placings_db, MYSQL_ASSOC);
    if (isset($_POST['mod_dates'])) {
      for ($i = 1; $i <= 3; $i++) {
        $varname = 'r'.$i.'_start';
        $$varname = $_POST[$varname];
        $varname = 'r'.$i.'_finish';
        $$varname = $_POST[$varname];
      }
      if (mysql_query("UPDATE cup_details SET r1_start='$r1_start', r1_finish='$r1_finish', r2_start='$r2_start', r2_finish='$r2_finish', r3_start='$r3_start', r3_finish='$r3_finish' WHERE kac_id=$kac_id", $db)) {
        echo "<p>KA Cup dates updated successfully.</p>\n";
      } else {
        echo "<p>Error updating dates, please report this bug pronto.</p>\n";
      }
      echo "<p><a href=\"$PHP_SELF?modify=1\">Back to modify page</a>.</p>\n";
    } elseif (isset($_POST['mod_kabals'])) {
      if (isset($_POST['refresh'])) {
        $placings = get_placings();
      } else {
        $placings = $_POST['placings'];
      }
      if (mysql_query("UPDATE cup_placings SET position_1=".$placings[0].", position_2=".$placings[1].", position_3=".$placings[2].", position_4=".$placings[3].", position_5=".$placings[4].", position_6=".$placings[5].", position_7=".$placings[6]." WHERE kac_id=$kac_id", $db)) {
        echo "<p>Kabal placings updated successfully.</p>\n";
      } else {
        echo "<p>Error updating kabal placings, please report this bug pronto.</p>\n";
      }
      echo "<p><a href=\"$PHP_SELF?modify=1\">Back to modify page</a>.</p>\n";
    } elseif (isset($_POST['mod_event'])) {
      $round = $_POST['round'];
      $event_id = $_POST['event_id'];
      $event_name = get_event_name($event_id);
      switch($event_id) {
        case 1:
          $puzzle = $_POST['puzzle'];
          $extra = 'NULL';
          $solution = $_POST['solution'];
          break;
        case 2:
          $puzzle = join($_POST['puzzle'], "\n");
          $extra = 'NULL';
          $solution = join($_POST['solution'], "\n");
          break;
        case 3:
          $file = fopen($_FILES['wh-image']['tmp_name'], "rb");
        	$puzzle = addslashes(fread($file, 1048576));
        	fclose($file);
        	$filesize = filesize($_FILES['wh-image']['tmp_name']);
        	$extra = "'".$_FILES['wh-image']['type']."\n".$filesize."'";
          $solution = $_POST['solution'];
          break;
        case 4:
          $puzzle = join($_POST['puzzle'], "\n");
          $extra = "'".$_POST['extra']."'";
          $solution = $_POST['solution'];
          break;
        case 5:
          $puzzle = join($_POST['puzzle'], "\n");
          $extra = 'NULL';
          $solution = $_POST['solution'];
          break;
      }
      if (mysql_query("UPDATE cup_events SET puzzle='$puzzle', extra=$extra, solution='$solution' WHERE kac_id=$kac_id AND round=$round AND event_id=$event_id", $db)) {
        echo "<p>Round $round $event_name was successfully Updated.</p>\n";
      } else {
        echo "<p>There was an error updating the round $round $event_name. Please report it pronto.</p>\n";
      }
      echo "<p><a href=\"$PHP_SELF?modify=1\">Back to modify page</a>.</p>\n";
    } elseif (isset($_POST['submit_event'])) {
      $round = $_POST['round'];
      $event_id = $_POST['event_id'];
      $event_name = get_event_name($event_id);
      switch($event_id) {
        case 1:
          $puzzle = $_POST['puzzle'];
          $extra = 'NULL';
          $solution = $_POST['solution'];
          break;
        case 2:
          $puzzle = join($_POST['puzzle'], "\n");
          $extra = 'NULL';
          $solution = join($_POST['solution'], "\n");
          break;
        case 3:
          $file = fopen($_FILES['wh-image']['tmp_name'], "rb");
        	$puzzle = addslashes(fread($file, 1048576));
        	fclose($file);
        	$filesize = filesize($_FILES['wh-image']['tmp_name']);
        	$extra = "'".$_FILES['wh-image']['type']."\n".$filesize."'";
          $solution = $_POST['solution'];
          break;
        case 4:
          $puzzle = join($_POST['puzzle'], "\n");
          $extra = "'".$_POST['extra']."'";
          $solution = $_POST['solution'];
          break;
        case 5:
          $puzzle = join($_POST['puzzle'], "\n");
          $extra = 'NULL';
          $solution = $_POST['solution'];
          break;
      }
      if (mysql_query("INSERT INTO cup_events VALUES($kac_id, $round, $event_id, '$puzzle', $extra, '$solution')", $db)) {
        echo "<p>Round $round $event_name was successfully entered.</p>\n";
      } else {
        echo "<p>There was an error entering the round $round $event_name. Please report it pronto.</p>\n";
      }
      echo "<p><a href=\"$PHP_SELF?modify=1\">Back to modify page</a>.</p>\n";
    } elseif (isset($_REQUEST['dates'])) {
      $dates_db = mysql_query("SELECT r1_start, r1_finish, r2_start, r2_finish, r3_start, r3_finish FROM cup_details WHERE kac_id=$kac_id", $db);
      $dates = mysql_fetch_array($dates_db, MYSQL_ASSOC);
      echo "<form method=\"post\" action=\"$PHP_SELF?modify=1\">\n";
      echo "<input type=\"hidden\" name=\"mod_dates\" value=\"1\" />\n";
      echo "<table>\n";
      for ($i = 1; $i <= 3; $i++) {
        echo "<tr><td><p>Round $i Start:</td><td><input type=\"text\" name=\"r".$i."_start\" value=\"".$dates['r'.$i.'_start']."\" /></td></tr>\n";
        echo "<tr><td><p>Round $i Finish:</td><td><input type=\"text\" name=\"r".$i."_finish\" value=\"".$dates['r'.$i.'_finish']."\" /></td></tr>\n";
      }
      echo "</table>\n";
      echo "<p><input type=\"submit\" value=\"Update dates\" /> <input type=\"reset\" /></p>\n";
      echo "</form>\n";
    } elseif (isset($_REQUEST['placings'])) {
      echo "<form method=\"post\" action=\"$PHP_SELF?modify=1\">\n";
      echo "<input type=\"hidden\" name=\"mod_kabals\" value=\"1\" />\n";
      echo "<input type=\"hidden\" name=\"refresh\" value=\"1\" />\n";
      echo "<input type=\"submit\" value=\"Get latest placings from KAG DB\" />\n";
      echo "</form>\n";
      echo "<form method=\"post\" action=\"$PHP_SELF?modify=1\">\n";
      echo "<input type=\"hidden\" name=\"mod_kabals\" value=\"1\" />\n";
      $placings_db = mysql_query("SELECT position_1, position_2, position_3, position_4, position_5, position_6, position_7 FROM cup_placings WHERE kac_id=$kac_id", $db);
      $placings = mysql_fetch_array($placings_db);
      for ($i = 0; $i < 7; $i++) {
        $kabal = new Kabal($placings[$i]);
        $position['id'][$i] = $placings[$i];
        $position['name'][$i] = $kabal->GetName();
        array_multisort($position['name'], $position['id']);
      }
      for ($i = 0; $i < 7; $i++) {
        echo "<p>".($i+1)." <select name=\"placings[]\">\n";
        for ($j = 0; $j < 7; $j++) {
          echo "<option value=\"".$position['id'][$j]."\" ";
          if ($position['id'][$j] == $placings[$i]) { echo "selected=\"selected\" "; }
          echo "/>".$position['name'][$j]."\n";
        }
        echo "</select></p>\n";
      }
      echo "<p><input type=\"submit\" value=\"Update Placings\" /> <input type=\"reset\" /></p>\n";
      echo "</form>\n";
    } elseif (isset($_REQUEST['edit_event'])) {
      $round = $_REQUEST['round'];
      $event_id = $_REQUEST['event_id'];
      $event_name = get_event_name($event_id);
      echo "<p style=\"text-align: center; font-size: small;\"><b>Edit Round $round $event_name</b></p>\n";
      if ($event_id == 3) {
        echo "<form method=\"post\" action=\"$PHP_SELF?modify=1\" enctype=\"multipart/form-data\">\n";
      } else {
        echo "<form method=\"post\" action=\"$PHP_SELF?modify=1\">\n";
      }
      echo "<input type=\"hidden\" name=\"mod_event\" value=\"1\" />\n";
      echo "<input type=\"hidden\" name=\"round\" value=\"$round\" />\n";
      echo "<input type=\"hidden\" name=\"event_id\" value=\"$event_id\" />\n";
      $event_db = mysql_query("SELECT * FROM cup_events WHERE kac_id=$kac_id AND round=$round AND event_id=$event_id", $db);
      $event = mysql_fetch_array($event_db, MYSQL_ASSOC);
      switch($event_id) {
        case 1:
          echo "<table><tr><td><p>Masked URL (What hunters see):</td><td><input type=\"text\" name=\"puzzle\" value=\"".$event['puzzle']."\" size=\"40\" /></p></td></tr>\n";
          echo "<tr><td><p>Solution:</td><td><input type=\"text\" name=\"solution\" value=\"".$event['solution']."\" size=\"40\" /></p></td></tr></table>\n";
          break;
        case 2:
          echo "<table><tr><td></td><td><p>Question</p></td><td><p>Answer</p></td></tr>\n";
          for($i = 1; $i <= 20; $i++) {
            $puzzle = split("\n", $event['puzzle']);
            $solution = split("\n", $event['solution']);
            echo "<tr><td><p>$i</p></td>";
            echo "<td><input type=\"text\" name=\"puzzle[]\" value=\"".$puzzle[$i-1]."\" size=\"35\" /></td>";
            echo "<td><input type=\"text\" name=\"solution[]\" value=\"".$solution[$i-1]."\" size=\"35\" /></td></tr>\n";
          }
          echo "</table>\n";
          break;
        case 3:
          echo "<img style=\"text-align: center;\" src=\"image.php?kac_id=$kac_id&amp;round=$round\" alt=\"Web Hunt\" />\n";
          echo "<table><tr><td><p>New image file to use:</p></td><td><input type=\"file\" name=\"wh-image\" /></td></tr>\n";
          echo "<tr><td><p>Answer:</p></td><td><input type=\"text\" name=\"solution\" value=\"".$event['solution']."\" size=\"30\" /></td></tr></table>\n";
          break;
        case 4:
          $puzzle = split("\n", $event['puzzle']);
          echo "<table><tr><td><p>First clue:</p></td><td><input type=\"text\" name=\"puzzle[]\" value=\"".$puzzle[0]."\" size=\"40\" /></td></tr>\n";
          echo "<tr><td><p>Second clue:</p></td><td><input type=\"text\" name=\"puzzle[]\" value=\"".$puzzle[1]."\" size=\"40\" /></td></tr>\n";
          echo "<tr><td><p>Third clue:</p></td><td><input type=\"text\" name=\"puzzle[]\" value=\"".$puzzle[2]."\" size=\"40\" /></td></tr>\n";
          echo "<tr><td><p>What's wanted:</p></td><td><input type=\"text\" name=\"extra\" value=\"".$event['extra']."\" size=\"40\" /></td></tr></table>\n";
          echo "<tr><td><p>Solution:</p></td><td><input type=\"text\" name=\"solution\" value=\"".$event['solution']."\" size=\"40\" /></td></tr></table>\n";
          break;
        case 5:
          $puzzle = split("\n", $event['puzzle']);
          echo "<p>Please enter the events in a random order (not chronologically) ... this form may randomly sort them eventually, but doesn't yet. Also, give the answer in the order of first event to last event.</p>\n";
          echo "<table>\n";
          $j = 0;
          for($i = 'A'; $i <= 'E'; $i++) {
            echo "<tr><td><p>Event $i:</p></td><td><input type=\"text\" name=\"puzzle[]\" value=\"".$puzzle[$j]."\" size=\"40\" /></td></tr>\n";
            $j++;
          }
          echo "<tr><td><p>Solution: (eg, EADBC)</p></td><td><input type=\"text\" name=\"solution\" value=\"".$event['solution']."\" size=\"20\" /></td></tr></table>\n";
          echo "</table>\n";
          break;
      }
      echo "<p><input type=\"submit\" value=\"Submit Event\" /> <input type=\"reset\" /></p>\n";
      echo "</form>\n";
    } elseif (isset($_REQUEST['new_event'])) {
      $round = $_REQUEST['round'];
      $event_id = $_REQUEST['event_id'];
      $event_name = get_event_name($event_id);
      echo "<p style=\"text-align: center; font-size: small;\"><b>New Round $round $event_name</b></p>\n";
      if ($event_id == 3) {
        echo "<form method=\"post\" action=\"$PHP_SELF?modify=1\" enctype=\"multipart/form-data\">\n";
      } else {
        echo "<form method=\"post\" action=\"$PHP_SELF?modify=1\">\n";
      }
      echo "<input type=\"hidden\" name=\"submit_event\" value=\"1\" />\n";
      echo "<input type=\"hidden\" name=\"round\" value=\"$round\" />\n";
      echo "<input type=\"hidden\" name=\"event_id\" value=\"$event_id\" />\n";
      switch($event_id) {
        case 1:
          echo "<table><tr><td><p>Masked URL (What hunters see):</p></td><td><input type=\"text\" name=\"puzzle\" size=\"40\" /></td></tr>\n";
          echo "<tr><td><p>Solution:</p></td><td><input type=\"text\" name=\"solution\" size=\"40\" /></td></tr></table>\n";
          break;
        case 2:
          echo "<table><tr><td></td><td><p>Question</p></td><td><p>Answer</p></td></tr>\n";
          for($i = 1; $i <= 20; $i++) {
            echo "<tr><td><p>$i</p></td><td><input type=\"text\" name=\"puzzle[]\" size=\"35\" /></td><td><input type=\"text\" name=\"solution[]\" size=\"35\" /></td></tr>\n";
          }
          echo "</table>\n";
          break;
        case 3:
          echo "<table><tr><td><p>Image file to use:</p></td><td><input type=\"file\" name=\"wh-image\" /></td></tr>\n";
          echo "<tr><td><p>Answer:</p></td><td><input type=\"text\" name=\"solution\" size=\"30\" /></td></tr></table>\n";
          break;
        case 4:
          echo "<table><tr><td><p>First clue:</p></td><td><input type=\"text\" name=\"puzzle[]\" size=\"40\" /></td></tr>\n";
          echo "<tr><td><p>Second clue:</p></td><td><input type=\"text\" name=\"puzzle[]\" size=\"40\" /></td></tr>\n";
          echo "<tr><td><p>Third clue:</p></td><td><input type=\"text\" name=\"puzzle[]\" size=\"40\" /></td></tr>\n";
          echo "<tr><td><p>What's wanted:</p></td><td><input type=\"text\" name=\"extra\" size=\"40\" value=\"eg, BHG ID Line, TC Pin\" /></td></tr></table>\n";
          echo "<tr><td><p>Solution:</p></td><td><input type=\"text\" name=\"solution\" size=\"40\" /></td></tr></table>\n";
          break;
        case 5:
          echo "<p>Please enter the events in a random order (not chronologically) ... this form may randomly sort them eventually, but doesn't yet. Also, give the answer in the order of first event to last event.</p>\n";
          echo "<table>\n";
          for($i = 'A'; $i <= 'E'; $i++) {
            echo "<tr><td><p>Event $i:</p></td><td><input type=\"text\" name=\"puzzle[]\" size=\"40\" /></td></tr>\n";
          }
          echo "<tr><td><p>Solution: (eg, EADBC)</p></td><td><input type=\"text\" name=\"solution\" size=\"20\" /></td></tr></table>\n";
          echo "</table>\n";
          break;
      }
      echo "<p><input type=\"submit\" value=\"Submit Event\" /> <input type=\"reset\" /></p>\n";
      echo "</form>\n";
    } else {
      echo "<p style=\"text-align: center; font-size: small;\"><b>KA Cup ".$cup['kac_number']."</b></p>\n";
      echo "<table align=\"center\" style=\"width: 100%;\"><tr><td>\n";
      echo "<table style=\"width: 100%;\"><tr><th style=\"text-align: center;\"><p>Dates: <a class=\"highlight\" href=\"$PHP_SELF?modify=1&amp;dates=1\">Modify</a></p></th></tr>\n";
      echo "<tr><td class=\"center\"><p>\n";
      echo "Round 1: ".$cup['r1_start']." to ".$cup['r1_finish']."<br />\n";
      echo "Round 2: ".$cup['r2_start']." to ".$cup['r2_finish']."<br />\n";
      echo "Round 3: ".$cup['r3_start']." to ".$cup['r3_finish']."<br />\n";
      echo "</p></td></tr></table>\n";
      if (cup_pending()) {
        echo "</td><td rowspan=\"2\">\n";
      } else {
        echo "</td><td>\n";
      }
      echo "<table style=\"width: 100%;\"><tr><th colspan=\"3\" style=\"text-align: center;\"><p>Events</p></th></tr>\n";
      echo "<tr><td class=\"center\"><p>Round</p></td><td class=\"center\"><p>Event</p></td><td class=\"center\"><p>New/Edit</p></td></tr>\n";
      $events_db = mysql_query("SELECT round, event_id FROM cup_events WHERE kac_id=$kac_id ORDER BY round ASC, event_id ASC", $db);
      while ($events[] = mysql_fetch_array($events_db)) {}
      $i = 0;
      for ($round = 1; $round <= 3; $round++) {
        for ($event_id = 1; $event_id <= 5; $event_id++) {
          $event_name = get_event_name($event_id);
          echo "<tr><td class=\"center\"><p>$round</p></td><td class=\"center\"><p>$event_name</p></td>\n";
          if (($round == $events[$i][0]) && ($event_id == $events[$i][1])) {
            echo "<td class=\"center\"><p><a class=\"highlight\" href=\"$php_self?modify=1&amp;edit_event=1&amp;round=$round&amp;event_id=$event_id\">Edit</a></p></td></tr>\n";
            $i++;
          } else {
            echo "<td class=\"center\"><p><a class=\"highlight\" href=\"$php_self?modify=1&amp;new_event=1&amp;round=$round&amp;event_id=$event_id\">New</a></p></td></tr>\n";
          }
        }
      }
      echo "</table>\n";
      if (cup_pending()) {
        echo "</td></tr>\n";
        echo "<tr><td>\n";
        echo "<table style=\"width: 100%;\"><tr><th colspan=\"2\" style=\"text-align: center;\"><p>Starting Places: <a class=\"highlight\" href=\"$PHP_SELF?modify=1&amp;placings=1\">Modify</a></p></th></tr>\n";
        echo "<tr><td class=\"center\"><p>Rank</p></td><td class=\"center\"><p>Kabal</p></td></tr>\n";
        for ($i = 1; $i < 8; $i++) {
          echo "<tr><td class=\"center\"><p>$i</p></td>";
//          $kabal = new Kabal($placings['position_'.$i]);
//          echo "<td><p>".$kabal->GetName()."</p></td></tr>\n";
          echo "<td class=\"center\"><p>".$placings['position_'.$i]."</p></td></tr>\n";
        }
        echo "</table>\n";
      }
      echo "</td></tr></table>\n";
    }
  }
  include('../footer.php');

?>
