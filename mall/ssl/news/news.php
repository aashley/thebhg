<?php
  include("news-config.php");
  include("news-functions.php");
  if ($days == "" || $days <= 0) $days = $default_days;
  $time = time();
  $maxdays = ($days * 86400);
  $maxdays = $time - $maxdays;
  unset ($output);
  
  if ($select_by == "days") { 
    $sql = "SELECT * FROM newsboard WHERE timestamp > $maxdays ORDER BY timestamp DESC"; 
  } else { 
    $sql = "SELECT * FROM newsboard ORDER BY timestamp DESC LIMIT $days"; 
  } 
  $result = mysql_db_query($dbname, $sql, $db) or die ("Error Retrieving News Articles");

  if ($result_row = mysql_fetch_array($result)) {
    do {
      $date = date($date_format, $result_row["timestamp"]); 
      $person_obj = $roster_obj->getPerson($result_row["poster"]);
      $topic_id = $result_row["topicid"];
      $topic = $result_row["topic"];
      $email = $person_obj->getEmail();
      $position_obj = $person_obj->getPosition();
      $name = $position_obj->getName()." ".$person_obj->getName();
      $message = convertURL($result_row["message"]);
  
      if (!file_exists(dirname($SCRIPT_FILENAME)."/news-layout.php")) {
        $output .= "Error: Layout File does not exist. Please contact admin.";
        $output .= $script_url."news-layout.php";
      } else {
        $layout = file($script_url."news-layout.php", 1);
        for ($i = 0; $i < sizeof($layout); $i++) {
          $layout[$i] = str_replace("%topic%", "<a name=\"".$topic_id."\"></a>".$topic, $layout[$i]);
          $layout[$i] = str_replace("%email%", $email, $layout[$i]);
          $layout[$i] = str_replace("%name%", stripslashes($name), $layout[$i]);
          $layout[$i] = str_replace("%date%", $date, $layout[$i]);
          $layout[$i] = str_replace("%message%", $message, $layout[$i]);
          $output .= $layout[$i];
        }
      }    
    } while ($result_row = mysql_fetch_array($result));
  } else {
  
    if (!file_exists(dirname($SCRIPT_FILENAME)."/news-layout.php")) {
      $output .= "Error: Layout File does not exist. Please contact admin.";
    } else {
      $layout = file($script_url."news-layout.php", 1);
      for ($i = 0; $i < sizeof($layout); $i++) {
        $layout[$i] = str_replace("%topic%", "No News", $layout[$i]);
        $layout[$i] = str_replace("%email%", "", $layout[$i]);
        $layout[$i] = str_replace("%name%", $news_system_name, $layout[$i]);
        $layout[$i] = str_replace("%date%", $date = date($date_format, time()), $layout[$i]);
        $layout[$i] = str_replace("%message%", "There is currently no news available.", $layout[$i]);
        $output .= $layout[$i];
      }
    }    
  }
  
  if (!file_exists(dirname($SCRIPT_FILENAME)."/news-display-layout.php")) {
    $output .= "Error: Layout File does not exist. Please contact admin.";
  } else {
    $layout = file($script_url."news-display-layout.php", 1);
    for ($i = 0; $i < sizeof($layout); $i++) {
      if ($select_by == "days") { 
        $layout[$i] = str_replace("%display%", "<form method=\"post\" action=\"$PHP_SELF\">Display Days: <input type=\"text\" name=\"days\" value=\"$days\" size=2></form>", $layout[$i]); 
      } else { 
        $layout[$i] = str_replace("%display%", "<form method=\"post\" action=\"$PHP_SELF\">Display Posts: <input type=\"text\" name=\"days\" value=\"$days\" size=2></form>", $layout[$i]); 
      } 
      $output .= $layout[$i];
    }
  }    
  
  if ($output_method == "print") {
    echo $output;
  } else {
    if (isset($$output_method)) {
      echo "Error: That output_method variable name ($output_method) is already in use";
    } else {
      $$output_method = $output;
    }
  }
?>
