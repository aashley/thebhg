<?php

  $pagename = "KA Cup";
  $path_to_base = "../";
  $min_rank = 3;

  include('../functions/auth.php');
  include('../functions/db.php');
  include('../functions/status.php');

  $kac_id = cup_running();
  $round = round_to_grade();

  if ($kac_id) {

    $kac_number_db = mysql_query("SELECT kac_number FROM cup_details WHERE kac_id=$kac_id", $db);
    $kac_number = mysql_result($kac_number_db, 0);
    $pagename .= " $kac_number Round $round :: Grade events";
    include('../header.php');

    if ($_REQUEST['event_id']) {

      $event_id = $_REQUEST['event_id'];

      if ($_POST['next']) {

        $hunter_id = $_POST['hunter_id'];
        $correct = $_POST['correct'];

        if ($_POST['disqualify'] == 1) {
          $grade = -1;
        } elseif (!$correct) {
          $grade = 0;
        } elseif ($event_id == 2) {
          $grade = 0;
          for ($i = 0; $i < count($correct); $i++) {
            $grade += $correct[$i];
          }
        } else {
          $grade = $correct;
        }

        if (mysql_query("UPDATE cup_entries SET graded=1, grade=$grade WHERE kac_id=$kac_id AND round=$round AND event_id=$event_id AND hunter_id=$hunter_id LIMIT 1", $db)) {
          echo "<p>The score was entered successfully. You can continue grading or stop (click the link at the bottom of this page).</p>\n";
        } else {
          echo "<p>Something went wrong. Please let nightweaver@thebhg.org know.</p>\n";
        }

        echo "<br />\n";

      }

      $entry_db = mysql_query("SELECT hunter_id, answer FROM cup_entries WHERE kac_id=$kac_id AND round=$round AND event_id=$event_id AND graded=0 LIMIT 1", $db);
      $entry = mysql_fetch_array($entry_db);
      $correct_db = mysql_query("SELECT solution FROM cup_events WHERE kac_id=$kac_id AND round=$round AND event_id=$event_id", $db);
      $correct = mysql_fetch_array($correct_db);

      $hunter_id = $entry[0];
      if ($hunter_id) {

        echo "<form method=\"post\" action=\"$PHP_SELF?event_id=$event_id\">\n";
        echo "<input type=\"hidden\" name=\"next\" value=\"1\" />\n";
        echo "<input type=\"hidden\" name=\"hunter_id\" value=\"$hunter_id\" />\n";

        if ($event_id == 2) {
          $answer = split("\n", $entry[1]);
          $solution = split("\n", $correct[0]);
          echo "<table>\n";
          echo "<tr><th><p>Correct Answer</p></th><th><p>Hunter's Response</p></th><th><p>Mark</p></th></tr>\n";
          for ($i = 0; $i < 20; $i++) {
            echo "<tr><td><p>".$solution[$i]."</p></td>";
            echo "<td><p>".$answer[$i]."</p></td>";
            echo "<td><p><input type=\"checkbox\" name=\"correct[]\" value=\"1\" /></p></td></tr>\n";
          }
        } else {
          $answer = $entry[1];
          $solution = $correct[0];
          echo "<table>\n";
          echo "<tr><td><p>Correct Answer:</p></td><td><p>".$solution."</p></td></tr>\n";
          echo "<tr><td><p>Hunter's Response:</p></td><td><p>".$answer."</p></td></tr>\n";
          echo "<tr><td><p>Correct?</p></td><td><p><input type=\"checkbox\" name=\"correct\" value=\"1\" /></p></td></tr>\n";
        }
        echo "</table>\n";
        echo "<p>&quot;No effort&quot; entry (Use sparingly): <input type=\"checkbox\" name=\"disqualify\" value=\"1\" /></p>\n";
        echo "<p><input type=\"submit\" value=\"Submit score\"/> <input type=\"reset\" /></p>\n";
        echo "</form>\n";

      }

      echo "<p><a href=\"$PHP_SELF\">Enough grading for now.</a></p>\n";

    } elseif($_POST['round_over']) {

      if (!round_running()) {

        switch($round) {
          case 1:
            $kabals_db = mysql_query("SELECT position_2, position_3, position_4, position_5, position_6, position_7 FROM cup_placings WHERE kac_id=$kac_id", $db);
            $kabals = mysql_fetch_array($kabals_db);
            $pairs[] = array($kabals[0], $kabals[5]);
            $pairs[] = array($kabals[1], $kabals[4]);
            $pairs[] = array($kabals[2], $kabals[3]);
            break;
          case 2:
            $kabals_db = mysql_query("SELECT position_1, winner_2_7, winner_3_6, winner_4_5 FROM cup_placings WHERE kac_id=$kac_id", $db);
            $kabals = mysql_fetch_array($kabals_db);
            $pairs[] = array($kabals[0], $kabals[2]);
            $pairs[] = array($kabals[1], $kabals[3]);
            break;
          case 3:
            $kabals_db = mysql_query("SELECT winner_top, winner_bottom FROM cup_placings WHERE kac_id=$kac_id", $db);
            $kabals = mysql_fetch_array($kabals_db);
            $pairs[] = array($kabals[0], $kabals[1]);
            break;
        }

        for ($pair = 0; $pair < count($pairs); $pair++) {
          for ($event_id = 1; $event_id <= 5; $event_id++) {
              unset($topten);
            for ($kabal = 0; $kabal < count($pairs[$pair]); $kabal++) {
              mysql_query("UPDATE cup_entries SET score=1 WHERE kac_id=$kac_id AND round=$round AND event_id=$event_id AND kabal_id=".$pairs[$pair][$kabal]." AND graded=1 AND grade>=0", $db);
              $topfive_db = mysql_query("SELECT hunter_id, grade, timestamp FROM cup_entries WHERE kac_id=$kac_id AND round=$round AND event_id=$event_id AND kabal_id=".$pairs[$pair][$kabal]." AND graded=1 AND grade>=0 ORDER BY timestamp ASC LIMIT 5", $db);
              while ($topfive = mysql_fetch_array($topfive_db, MYSQL_ASSOC)) {
                $topten['hunter_id'][] = $topfive['hunter_id'];
                $topten['grade'][] = $topfive['grade'];
                $topten['timestamp'][] = $topfive['timestamp'];
              }
            }
            array_multisort($topten['grade'], SORT_DESC, $topten['timestamp'], SORT_ASC, $topten['hunter_id']);
            print_r($topten);
            for ($i = 0; $i < count($topten['hunter_id']); $i++) {
              mysql_query("UPDATE cup_entries SET score=".(10-$i)." WHERE kac_id=$kac_id AND round=$round AND event_id=$event_id AND hunter_id=".$topten['hunter_id'][$i], $db);
            }
          }
          $winner_db = mysql_query("SELECT SUM(score) AS total, kabal_id FROM cup_entries WHERE kac_id=$kac_id AND round=$round GROUP BY kabal_id HAVING kabal_id=".$pairs[$pair][0]." OR kabal_id=".$pairs[$pair][1]." ORDER BY total DESC LIMIT 1", $db);
          $winner = mysql_fetch_array($winner_db, MYSQL_ASSOC);
          switch($round) {
            case 1:
              switch($pair) {
                case 0:
                  $field = "winner_2_7";
                  break;
                case 1:
                  $field = "winner_3_6";
                  break;
                case 2:
                  $field = "winner_4_5";
                  break;
              }
              break;
            case 2:
              switch($pair) {
                case 0:
                  $field = "winner_top";
                  break;
                case 1:
                  $field = "winner_bottom";
                  break;
              }
              break;
            case 3:
              $field = "winner";
              break;
          }
          mysql_query("UPDATE cup_placings SET $field=".$winner['kabal_id']." WHERE kac_id=$kac_id", $db);
        }

        echo "<p>Finished ... Please check the ladder to verify that the scores have been updated, otherwise bug Nightweaver till he solves it.</p>\n";
        echo "<img style=\"text-align: center;\" src=\"../ladder/ladder.php?now=1\" alt=\"The KA Cup Ladder\" />\n";

      }

    } else {

      $entry_db = mysql_query("SELECT event_id, COUNT(event_id) AS ungraded FROM cup_entries WHERE kac_id=$kac_id AND round=$round AND graded=0 GROUP BY event_id ORDER BY event_id ASC", $db);
      while (@$entry[] = mysql_fetch_array($entry_db)) {}
      echo "<table>\n";
      echo "<tr><th><p>Event</p></th><th><p>Number Ungraded</p></th><th><p>Grade Event</p></th></tr>\n";
      $j = 0;
      $events_remaining = 5;
      for ($i = 1; $i <= 5; $i++) {
        echo "<tr><td><p>".get_event_name($i)."</p></td>";
        if ((count($entry) > 0) && ($entry[$j][0] == $i)) {
          echo "<td><p>".$entry[$j][1]."</p></td>";
          echo "<td><p><a href=\"$PHP_SELF?event_id=$i\">Grade</a></p></td></tr>\n";
          $j++;
        } else {
          echo "<td><p>0</p></td>";
          echo "<td><p>Nothing to grade</p></td></tr>\n";
          $events_remaining--;
        }
      }
      echo "</table>\n";
      if (($events_remaining == 0) && !round_running()) {
        echo "<form method=\"post\" action=\"$PHP_SELF\">\n";
        echo "<input type=\"hidden\" name=\"round_over\" value=\"1\" />\n";
        echo "<input type=\"submit\" value=\"Score this round\" />\n";
        echo "</form>\n";
      }
    }

  } else {

    $pagename .= " :: No Cup Running";
    include('../header.php');

    echo "<p>The KA Cup has not begun yet. Please be patient.</p>\n";

  }

  include('../footer.php');

?>
