<?php
  include("news-config.php");
  $db = mysql_connect("localhost", $dbusername, $dbpassword);
  mysql_select_db($dbname, $db);
  $sql = "CREATE TABLE newsboard (topicid INT not null AUTO_INCREMENT, timestamp BIGINT not null , poster INT not null , topic TEXT not null , message LONGTEXT not null , PRIMARY KEY (topicid), INDEX (topicid), UNIQUE (topicid));";
  mysql_query($sql, $db) or die ("Error Creating Table");
  echo "Table Successfully Created";
?>