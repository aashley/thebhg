<?php
  include("news-config.php");
  include("news-functions.php");
  
  if (!isset($PHP_AUTH_USER)) {
    Header( "WWW-Authenticate: Basic realm=\"$news_system_name\"");
    Header( "HTTP/1.0 401 Unauthorized");
    echo "<html><head><title>$news_system_name Admin</title></head><body>";
    echo  "You are not allowed to access this system<p>\n";
    echo "</body></html>";
    exit;  
  } else {
    $login_obj = new Login ($PHP_AUTH_USER, $PHP_AUTH_PW);
    if ($login_obj->IsValid()) {
      $login_id_num = $login_obj->getID();
      $login_id_name = $login_obj->getName();
      $login_position_obj = $login_obj->getPosition();
      $login_id_position = $login_position_obj->getID();
      $login_division_obj = $login_obj->getDivision();
      $login_id_division = $login_division_obj->getID();
    
      echo "<html><head><title>$news_system_name Admin</title></head><body>";

      $login_approved = 0;

      for ($i = 0; $i < sizeof($posters); $i++) {
        if ((($login_id_position == $posters[$i]['position']) AND ($login_id_division == $posters[$i]['division'])) OR
            (($posters[$i]['position'] == -1) AND ($login_id_division == $posters[$i]['division'])) OR
            (($login_id_position == $posters[$i]['position']) AND ($posters[$i]['division'] == -1)) OR
            ($login_id_num == $posters[$i]['id']) OR
            ($login_id_num == $board_admin['id']) OR
            (($login_id_position == $board_admin['position']) AND ($login_id_division == $board_admin['division']))) {
          $login_approved = 1;
        }
      }
    
      if (($login_approved == 1)) {
        if ($post) {
          if ($submit) {
            $time = time();
            $message = str_replace("\n", "<br>", $message);
            $topic = prepVar($topic);
            $topic = strip_tags($topic);
            $sql = "INSERT INTO newsboard (timestamp, poster, topic, message) VALUES ('$time', '$poster', '$topic', '$message');";
            if (mysql_db_query($dbname, $sql, $db)) {
              echo "News Successfully Added";
            } else {
              echo "Error adding News. Please contact admin.";
            }
          } else {
            echo "<FORM METHOD=\"POST\" ACTION=\"$PHP_SELF\">";
            echo "<input type=\"hidden\" name=\"post\" value=\"1\">";
            echo "<input type=\"hidden\" name=\"poster\" value=\"$PHP_AUTH_USER\">";
            echo "<p>Topic: <INPUT TYPE=\"TEXT\" NAME=\"topic\" size=\"35\"></p>";
            echo "<p>Message:<br><textarea name=\"message\" cols=\"50\" rows=\"10\"></textarea></p>";
            echo "<p><input type=\"submit\" value=\"Post\" name=\"submit\"><input type=\"reset\" value=\"Reset\"></p>";
            echo "</form>";
          }
          echo "<p><a href=\"$PHP_SELF\">Return to Admin</a></p>";
        } elseif ($edit) {
          if ($submit) {
            $message_db = mysql_db_query($dbname, "SELECT * FROM newsboard WHERE topicid=$edit;", $db);
            if (($login_id_num == $board_admin['id']) OR
                (($login_id_position == $board_admin['position']) AND ($login_id_division == $board_admin['division'])) OR
                ($login_id_num == mysql_result($message_db, 0, "poster"))) {
              $message = str_replace("\n", "<br>", $message);
              $topic = prepVar($topic);
              $topic = strip_tags($topic);
              $sql = "UPDATE newsboard SET topic='$topic', message='$message' WHERE topicid=$edit;";
              if (mysql_db_query($dbname, $sql, $db)) {
                echo "News Successfully Updated";
              } else {
                echo "Error updating News. Please contact admin.";
              }          
            } else {
              echo "You are not permitted to edit this news post.<br>Only the original poster or the Board Admin can edit.";
            }
          } else {
            $message_db = mysql_db_query($dbname, "SELECT * FROM newsboard WHERE topicid=$edit;", $db);
            if (($login_id_num == $board_admin['id']) OR
                (($login_id_position == $board_admin['position']) AND ($login_id_division == $board_admin['division'])) OR
                ($login_id_num == mysql_result($message_db, 0, "poster"))) {
              $message_text = str_replace("<br>", "\n", mysql_result($message_db, 0, "message"));
              echo "<FORM METHOD=\"POST\" ACTION=\"$PHP_SELF\">";
              echo "<input type=\"hidden\" name=\"edit\" value=\"$edit\">";
              echo "<p>Topic: <INPUT TYPE=\"TEXT\" NAME=\"topic\" size=\"35\" value=\"".htmlspecialchars(mysql_result($message_db, 0, "topic"))."\"></p>";
              echo "<p>Message:<br><textarea name=\"message\" cols=\"50\" rows=\"10\">".$message_text."</textarea></p>";
              echo "<p><input type=\"submit\" value=\"Update\" name=\"submit\"><input type=\"reset\" value=\"Reset\"></p>";
              echo "</form>";
            } else {
              echo "You are not permitted to edit this news post.<br>Only the original poster or the Board Admin can edit.";
            }
          }
          echo "<p><a href=\"$PHP_SELF\">Return to Admin</a></p>";
        } elseif ($delete) {
          if ($submit) {
            $message_db = mysql_db_query($dbname, "SELECT * FROM newsboard WHERE topicid=$delete;", $db);
            if (($login_id_num == $board_admin['id']) OR
                (($login_id_position == $board_admin['position']) AND ($login_id_division == $board_admin['division'])) OR
                ($login_id_num == mysql_result($message_db, 0, "poster"))) {
              $sql = "DELETE FROM newsboard WHERE topicid=$delete;";
              if (mysql_db_query($dbname, $sql, $db)) {
                echo "News Successfully Deleted";
              } else {
                echo "Error deleting News. Please contact admin.";
              }          
            } else {
              echo "You are not permitted to edit this news post.<br>Only the original poster or the Board Admin can edit.";
            }
          } else {
            $message_db = mysql_db_query($dbname, "SELECT * FROM newsboard WHERE topicid=$delete;", $db);
            if (($login_id_num == $board_admin['id']) OR
                (($login_id_position == $board_admin['position']) AND ($login_id_division == $board_admin['division'])) OR
                ($login_id_num == mysql_result($message_db, 0, "poster"))) {
              echo "Do you wish to delete this news post?";
              echo "<table><tr><td>";
              echo "<FORM METHOD=\"POST\" ACTION=\"$PHP_SELF\">";
              echo "<input type=\"hidden\" name=\"delete\" value=\"$delete\">";
              echo "<input type=\"submit\" value=\"Yes\" name=\"submit\">";
              echo "</form>";
              echo "</td><td>";
              echo "<FORM METHOD=\"POST\" ACTION=\"$PHP_SELF\">";
              echo "<input type=\"submit\" value=\"No\">";
              echo "</form></td></tr></table>";
            } else {
              echo "You are not permitted to delete this news post.<br>Only the original poster or the Board Admin can delete.";
            }
          }
          echo "<p><a href=\"$PHP_SELF\">Return to Admin</a></p>";
        } else {
          echo "<center><font size=\"+1\"><b>Administer $news_system_name</b></font></center><p>";
          echo "<a href=\"$PHP_SELF?post=1\">Post a new article</a><p>";
          $sql = "SELECT * FROM newsboard ORDER BY timestamp DESC";
          $result = mysql_db_query($dbname, $sql, $db) or die ("Error Retrieving News Articles");
    
          if ($result_row = mysql_fetch_array($result)) {
            do {
              $date = date($date_format, $result_row["timestamp"]);
              $person_obj = $roster_obj->getPerson ($result_row["poster"]);
              $topic_id = $result_row["topicid"];
              $topic = $result_row["topic"];
              $email = $person_obj->getEmail();
              $position_obj = $person_obj->getPosition();
              $name = $position_obj->getName()." ".$person_obj->getName();
              $message = $result_row["message"];

              echo "<a href=\"$PHP_SELF?edit=$topic_id\">Edit</a> <a href=\"$PHP_SELF?delete=$topic_id\">Delete</a> - $topic Posted By $name at $date<br>";
          
            } while ($result_row = mysql_fetch_array($result));
          } else {
            echo "There is currently no news available.";
          }
        }
      } else {
        echo "You are not allowed to access this system<p>\n";
      }
    
      echo "</body></html>";
    } else {
      header("WWW-Authenticate: Basic realm=\"$news_system_name\"");
      header("HTTP/1.0 401 Unauthorized");
      echo "<html><head><title>$news_system_name Admin</title></head><body>";
      echo "You are not allowed to access this system<p>\n";
      echo "</body></html>";
      exit;
    }
  }
?>
