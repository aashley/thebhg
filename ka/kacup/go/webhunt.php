<?php

  $path_to_base = "../";

  include('../functions/auth.php');
  include('../functions/db.php');
  include('../functions/status.php');
  
  $kac_id = cup_running();
  $round = round_running();
  
  if ($kac_id && $round && kabal_in($id)) {
    $image_db = mysql_query("SELECT puzzle, extra FROM cup_events WHERE event_id=3 AND kac_id=$kac_id AND round=$round", $db);
    $image = mysql_fetch_array($image_db);

    $meta = split("\n", $image[1]);

    Header ("Content-Type: ".$meta[0]);
    Header ("Content-Length: ".$meta[1]);

    echo $image[0];
  } else {
    Header ("Content-Type: text/plain");
    echo "Hah, nice try.";
  }

?>