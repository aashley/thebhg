<?php
include("bhgnews/news-config.php");
include("bhgnews/news-functions.php");
if ($days == "" || $days <= 0) $days = $default_days;
$time = time();
$maxdays = ($days * 86400);
$maxdays = $time - $maxdays;

$db = mysql_connect("localhost", $dbusername, $dbpassword);
mysql_select_db($dbname);
$db_roster = mysql_connect($roster_host, "thebhg_roster", base64_decode("Ymhncm9zdGVycGFzcw=="));

if ($select_by == "days") { 
  $sql = "SELECT * FROM podracer_newsboard WHERE timestamp > $maxdays ORDER BY timestamp DESC"; 
} else { 
  $sql = "SELECT * FROM podracer_newsboard ORDER BY timestamp DESC LIMIT $days"; 
} 
$result = mysql_db_query($dbname, $sql, $db) or die ("Error Retrieving News Articles");

if ($result_row = mysql_fetch_array($result)) {
  do {
    $date = date($date_format, $result_row["timestamp"]);    
    $poster_details = mysql_db_query("thebhg_roster", "SELECT roster.*, position.* FROM roster, position WHERE id=".$result_row["poster"]." AND roster.position=position.positionid;", $db_roster);
    
    $topic_id = $result_row["topicid"];
    $topic = $result_row["topic"];
    $email = mysql_result($poster_details, 0, "email");
    $name = mysql_result($poster_details, 0, "PositionName")." ".mysql_result($poster_details, 0, "name");
    $message = convertURL($result_row["message"]);

    if (!file_exists(dirname($SCRIPT_FILENAME)."/bhgnews/news-layout.php")) {
      $output = "Error: Layout File does not exist. Please contact admin.";
    } else {
      $layout = file("bhgnews/news-layout.php", 1);
      for ($i = 0; $i < sizeof($layout); $i++) {
        $layout[$i] = str_replace("%topic%", "<a name=\"".$topic_id."\"></a>".$topic, $layout[$i]);
        $layout[$i] = str_replace("%email%", $email, $layout[$i]);
        $layout[$i] = str_replace("%name%", $name, $layout[$i]);
        $layout[$i] = str_replace("%date%", $date, $layout[$i]);
        $layout[$i] = str_replace("%message%", $message, $layout[$i]);
        $output .= $layout[$i];
      }
    }    
  } while ($result_row = mysql_fetch_array($result));
} else {
  if (!file_exists(dirname($SCRIPT_FILENAME)."/bhgnews/news-layout.php")) {
    $output = "Error: Layout File does not exist. Please contact admin.";
  } else {
    $layout = file("bhgnews/news-layout.php", 1);
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

if (!file_exists(dirname($SCRIPT_FILENAME)."/bhgnews/news-display-layout.php")) {
  $output = "Error: Layout File does not exist. Please contact admin.";
} else {
  $layout = file("bhgnews/news-display-layout.php", 1);
  for ($i = 0; $i < sizeof($layout); $i++) {
    if ($select_by == "days") { 
      $layout[$i] = str_replace("%display%", "<p align=\"right\"><form method=\"post\" action=\"$PHP_SELF\">Display Days: <input type=\"text\" name=\"days\" value=\"$days\" size=\"2\" class=\"input\"></form></p>", $layout[$i]); 
    } else { 
      $layout[$i] = str_replace("%display%", "<p align=\"right\"><form method=\"post\" action=\"$PHP_SELF\">Display Posts: <input type=\"text\" name=\"days\" value=\"$days\" size=\"2\" class=\"input\"></form></p>", $layout[$i]); 
    } 
    $output .= $layout[$i];
  }
}    
?>