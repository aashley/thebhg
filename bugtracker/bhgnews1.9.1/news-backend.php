<?php
  header("Content-Type: text/xml");
    
  if ($mode == "eh") {
    echo "<?xml version=\"1.0\"?>\n";
    echo "<!DOCTYPE scriptingNews SYSTEM \"http://www.ehnet.org/backend.dtd\">\n";
  } else {
    echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    echo "<!DOCTYPE rss PUBLIC \"-//Netscape Communications//DTD RSS 0.91//EN\"\n \"http://my.netscape.com/publish/formats/rss-0.91.dtd\">\n";
    echo "<rss version=\"0.91\">\n";
  }
  include("news-config.php");
  include("news-functions.php");
  
  if ($mode == "eh") {
    echo "<items>\n";
  } else {
    echo "<channel>\n";
    echo "<title>$web_name</title>\n";
    echo "<link>$web_url</link>\n";
    echo "<description>$web_name</description>\n";
    echo "<language>en-us</language>\n";
  }
  
  $sql = "SELECT * FROM newsboard ORDER BY timestamp DESC LIMIT $backend_num";
  $result = mysql_db_query($dbname, $sql, $db) or die ("Error Retrieving News Articles");
  
  $j=0;
  if ($result_row = mysql_fetch_array($result)) {
    do {
      $j++;
      $topicid = $result_row["topicid"];
      $topic = $result_row["topic"];
      $link = str_replace("%id%", $topicid, $news_home); 
      if ($mode == "eh") {
        $person_obj = $roster_obj->getPerson($result_row["poster"]);
        $name = StripSlashes($person_obj->getName());
        $email = StripSlashes($person_obj->getEmail());
  
        echo "  <news>\n";
        echo "    <name>$name</name>\n";
        echo "    <email>$email</email>\n";
        echo "    <topic>$web_name</topic>\n";
        echo "    <title>$topic</title>\n";
        echo "    <link>$link</link>\n";
        echo "  </news>\n";
      } else {
        echo "  <item>\n";
        echo "    <title>$topic</title>\n";
        echo "    <link>$link</link>\n";
        echo "  </item>\n";
      }
    } while (($result_row = mysql_fetch_array($result)) AND $j < 5);
  } else {
    if ($mode == "eh") {
      echo "  <news>\n";
      echo "    <name>No One</name>\n";
      echo "    <email>noone@somewhere.com</email>\n";
      echo "    <topic>$web_name</topic>\n";
      echo "    <title>No Current News</title>\n";
      echo "    <link>$web_url</link>\n";
      echo "  </news>\n";
    } else {
      echo "  <item>\n";
      echo "    <title>No Current News</title>\n";
      echo "    <link>$web_url</link>\n";
      echo "  </item>\n";
    }
  }
  if ($mode == "eh") {
    echo "</items>\n";
  } else {
    echo "</channel>\n";
    echo "</rss>\n";
  }
?>

