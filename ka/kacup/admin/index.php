<?php

  $pagename = "KA Cup Admin";
  $path_to_base = "../";
  $min_rank = 3;

  include('../functions/auth.php');
  include('../functions/db.php');
  include('../functions/status.php');

  function get_placings() {
    // Get the placings from the last KAG
    global $db;
    $last_kag = mysql_query("SELECT MAX(id) FROM kag_seasons WHERE events_stop < NOW() AND first>0 AND second>0 AND third>0", $db);
    $placings_db = mysql_query("SELECT Kabal_ID, SUM(Scores) AS Total FROM kag_scores WHERE KAG_ID=".mysql_result($last_kag, 0)." GROUP BY Kabal_ID ORDER BY Total DESC", $db);

    while ($placings = mysql_fetch_array($placings_db, MYSQL_ASSOC)) {
      $places[] = $placings['Kabal_ID'];
    }
    return $places;
  }

  if (isset($_REQUEST['new'])) {
    include('new.php');
  }

  if (isset($_REQUEST['modify'])) {
    include('mod.php');
  }

?>