<?php

  $pagename = "KA Cup";
  $path_to_base = "../";

  include('../functions/auth.php');
  include('../functions/db.php');
  include('../functions/status.php');
  
  $kac_id = cup_running();
  $round = round_running();

  if ($kac_id) {

    $kac_number_db = mysql_query("SELECT kac_number FROM cup_details WHERE kac_id=$kac_id", $db);
    $kac_number = mysql_result($kac_number_db, 0);
    $pagename .= " $kac_number";

    if ($round) {

      $pagename .= " :: Round $round";

      if (kabal_in($id)) {

        if (isset($_POST['submit'])) {

          $pagename .= " :: Submit Event";
          include('../header.php');

          $event_id = $_POST['submit'];
          $event_name = get_event_name($event_id);
          if ($event_id == 2) {
            $answer = join($_POST['answer'], "\n");
          } else {
            $answer = $_POST['answer'];
          }

          $hunter = new Person($id);
          $division_obj = $hunter->GetDivision();
          $kabal = $division_obj->GetID();

          if (mysql_query("INSERT INTO cup_entries VALUES($kac_id, $round, $event_id, $id, $kabal, '$answer', NOW(), 0, 0, 0)", $db)) {
            $mail_headers  = "From: ".$hunter->GetName()." <".$hunter->GetEmail().">\r\n";
            $mail_headers .= "Reply-To: ".$hunter->GetName()." <".$hunter->GetEmail().">\r\n";
            $mail_headers .= "X-Mailer: PHP/".phpversion();
            $sendto = "judicator@thebhg.org, proctor@thebhg.org";
            $subject = "KA Cup $kac_number Round $round $event_name :: Entry Submitted";
            $body = $hunter->IDLine()." has submitted an entry to KA Cup $kac_number in round $round :\n\n";
            $body .= "Event: $event_name\n";
            $body .= "Time of Submission: ".date("Y-m-d @ H:i", time())."\n";
            $body .= "Answer:\n$answer\n\n";
            $body .= "[This is an automated message sent to you to confirm that this has been recorded in the database.]";
            mail($sendto, $subject, $body, $mail_headers);
            echo "<p>Congratulations, your entry has been submitted.</p>\n";
          } else {
            echo "<p>An error occurred submitting your answer. Please try resubmitting, or if that fails contact nightweaver@thebhg.org immediately.</p>\n";
          }

          echo "<p><a href=\"$PHP_SELF\">Back to Events</a></p>\n";

        } elseif (isset($_REQUEST['event_id'])) {

          $event_id = $_REQUEST['event_id'];

          $pagename .= " :: ".$event_id;
          include('../header.php');

          echo "<p><b>Please note: Once you have submitted an event, that's it; so make sure it's right the first time.</b></p>\n";
          echo "<form method=\"post\" action=\"$PHP_SELF\">\n";
          echo "<input type=\"hidden\" name=\"submit\" value=\"$event_id\" />\n";

          switch($event_id) {
            case 1: // Internet (URL) Hunt
              $event_db = mysql_query("SELECT puzzle FROM cup_events WHERE kac_id=$kac_id AND round=$round AND event_id=$event_id", $db);
              $puzzle = mysql_result($event_db, 0);
              echo "<p>You are required to decipher the following URL:</p>\n";
              echo "<blockquote><p>$puzzle</p></blockquote>\n";
              echo "<input type=\"text\" name=\"answer\" size=\"40\" />\n";
              break;
            case 2: // Trivia
              $event_db = mysql_query("SELECT puzzle FROM cup_events WHERE kac_id=$kac_id AND round=$round AND event_id=$event_id", $db);
              $puzzle = split("\n", mysql_result($event_db, 0));
              echo "<table>\n";
              for ($i = 0; $i < 20; $i++) {
                echo "<tr><td><p>$i</p></td>";
                echo "<td><p>".$puzzle[$i]."</p></td>";
                echo "<td><input type=\"text\" name=\"answer[]\" size=\"35\" /></td></tr>\n";
              }
              echo "</table>\n";
              break;
            case 3: // Web Hunt
              echo "<img style=\"text-align: center;\" src=\"webhunt.php\" alt=\"Web Hunt\" />\n";
              echo "<p>You are required to identify the person or thing depicted above.</p>\n";
              echo "<input type=\"text\" name=\"answer\" size=\"40\" />\n";
              break;
            case 4: // Hunt the Hunter
              $event_db = mysql_query("SELECT puzzle, extra FROM cup_events WHERE kac_id=$kac_id AND round=$round AND event_id=$event_id", $db);
              $event = mysql_fetch_array($event_db);
              $puzzle = split("\n", $event[0]);
              $extra = $event[1];
              echo "<p>Please find the $extra of the hunter who matches the following three clues:</p>\n";
              echo "<blockquote><p>\n";
              for ($i = 0; $i < 3; $i++) {
                echo "\t".($i+1)." ".$puzzle[$i]."<br />\n";
              }
              echo "</p></blockquote>\n";
              echo "<input type=\"text\" name=\"answer\" size=\"40\" />\n";
              break;
            case 5: // Time Line              
              $event_db = mysql_query("SELECT puzzle FROM cup_events WHERE kac_id=$kac_id AND round=$round AND event_id=$event_id", $db);
              $puzzle = split("\n", mysql_result($event_db, 0));
              echo "<p>Place the following in chronological order, earliest event first, like 'ABCDE':</p>\n";
              echo "<blockquote><p>\n";
              $j = 0;
              for ($i = 'A'; $i <= 'E'; $i++) {
                echo "\t".($i)." ".$puzzle[$j]."<br />\n";
                $j++;
              }
              echo "</p></blockquote>\n";
              echo "<input type=\"text\" name=\"answer\" size=\"10\" />\n";
              break;
          }

          echo "<p><input type=\"submit\" value=\"Submit answer\" /> <input type=\"reset\" /></p>\n";
          echo "</form>\n";

          echo "<p><a href=\"$PHP_SELF\">Back to Events</a></p>\n";

        } else {

          $pagename .= " :: Do Events";
          include('../header.php');

          $events = events_pending($id);

          echo "<table>\n";
          echo "<tr><th><p>Event</p></th><th><p>Status</p></th></tr>\n";
          $i = 0;
          for ($event = 1; $event <= 5; $event++) {
            echo "<tr><td><p>".get_event_name($event)."</p></td>";
            if ($events && ($i <= count($events)) && ($events[$i] == $event)) {
              echo "<td><p><a href=\"$PHP_SELF?event_id=$event\">Do this event</a></p></td></tr>\n";
              $i++;
            } else {
              echo "<td><p>Done</p></td></tr>\n";
            }
          }

        }

      } else {

        $pagename .= " :: Knocked Out";
        include('../header.php');

        echo "<p>Your kabal has been knocked out. Better luck next time.</p>\n";

      }

    } else {

      $pagename .= " :: Round Not Running";
      include('../header.php');

      echo "<p>There is no round currently running. Please wait for the events to be graded and the next round to start.</p>\n";

    }

  } else {

    $pagename .= " :: No Cup Running";
    include('../header.php');

    echo "<p>The KA Cup has not begun yet. Please be patient.</p>\n";

  }

  include('../footer.php');

?>
