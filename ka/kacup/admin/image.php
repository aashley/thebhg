<?php

  $path_to_base = "../";
  $min_rank = 3;

  include('../functions/auth.php');
  include('../functions/db.php');
  
  $image_db = mysql_query("SELECT puzzle, extra FROM cup_events WHERE event_id=3 AND kac_id=".$_REQUEST['kac_id']." AND round=".$_REQUEST['round'], $db);
  $image = mysql_fetch_array($image_db);

  $meta = split("\n", $image[1]);

  Header ("Content-Type: ".$meta[0]);
  Header ("Content-Length: ".$meta[1]);

  echo $image[0];

?>