<?php

  $pagename = "KA Cup";
  $path_to_base = "../";

  include('../functions/auth.php');
  include('../functions/db.php');
  include('../functions/status.php');

  $kac_id = $_REQUEST['kac_id'];
  
  if ($kac_id) {

    include_once('../functions/roster.php');

    $kac_number_db = mysql_query("SELECT kac_number FROM cup_details WHERE kac_id=$kac_id", $db);
    $kac_number = mysql_result($kac_number_db, 0);
    $pagename .= " $kac_number :: Individual Results";
    include('../header.php');
    echo "<p>Please make sure awards haven't already been made. Suggested awards can be found in the KA Cup rules.</p>\n";
    if ($kac_id == cup_running()) {
      if (round_running()) {
        $max_round = round_running() - 1;
      } else {
        $max_round = round_to_grade();
      }
    } else {
      $max_round = 3;
    }
    if ($max_round == 0) {
      echo "<p>No rounds have been completed in this cup yet. Please wait.</p>\n";
    } else {
      for ($round = 1; $round <= $max_round; $round++) {
	unset ($first, $second, $third, $correct, $incorrect);
        echo "<ul><li><b>Round $round:</b></li>\n";
        echo "<ul><li><b>First places:</b></li><ul>\n";
        $first_db = mysql_query("SELECT hunter_id, count(score) AS total FROM cup_entries WHERE kac_id=$kac_id AND round=$round AND score=10 GROUP BY hunter_id", $db);
        while ($first_item = mysql_fetch_array($first_db)) {
          $hunter = new Person($first_item[0]);
          $first['name'][] = $hunter->GetName();
          $kabal_obj = $hunter->GetDivision();
          $first['kabal'][] = $kabal_obj->GetName();
          $first['total'][] = $first_item[1];
        }
        array_multisort($first['kabal'], $first['name'], $first['total']);
        for ($i = 0; $i < count($first['name']); $i++) {
          echo "<li>".$first['name'][$i]." (".$first['kabal'][$i].") : ".$first['total'][$i]." first places.</li>\n";
        }
        echo "</ul></ul>\n";
        echo "<ul><li><b>Second places:</b></li><ul>\n";
        $second_db = mysql_query("SELECT hunter_id, count(score) AS total FROM cup_entries WHERE kac_id=$kac_id AND round=$round AND score=9 GROUP BY hunter_id", $db);
        while ($second_item = mysql_fetch_array($second_db)) {
          $hunter = new Person($second_item[0]);
          $second['name'][] = $hunter->GetName();
          $kabal_obj = $hunter->GetDivision();
          $second['kabal'][] = $kabal_obj->GetName();
          $second['total'][] = $second_item[1];
        }
        array_multisort($second['kabal'], $second['name'], $second['total']);
        for ($i = 0; $i < count($second['name']); $i++) {
          echo "<li>".$second['name'][$i]." (".$second['kabal'][$i].") : ".$second['total'][$i]." second places.</li>\n";
        }
        echo "</ul></ul>\n";
        echo "<ul><li><b>Third places:</b></li><ul>\n";
        $third_db = mysql_query("SELECT hunter_id, count(score) AS total FROM cup_entries WHERE kac_id=$kac_id AND round=$round AND score=8 GROUP BY hunter_id", $db);
        while ($third_item = mysql_fetch_array($third_db)) {
          $hunter = new Person($third_item[0]);
          $third['name'][] = $hunter->GetName();
          $kabal_obj = $hunter->GetDivision();
          $third['kabal'][] = $kabal_obj->GetName();
          $third['total'][] = $third_item[1];
        }
        array_multisort($third['kabal'], $third['name'], $third['total']);
        for ($i = 0; $i < count($third['name']); $i++) {
          echo "<li>".$third['name'][$i]." (".$third['kabal'][$i].") : ".$third['total'][$i]." third places.</li>\n";
        }
        echo "</ul></ul>\n";
        echo "<ul><li><b>Correct answers:</b></li><ul>\n";
        $correct_db = mysql_query("SELECT hunter_id, count(score) AS total FROM cup_entries WHERE kac_id=$kac_id AND round=$round AND grade>0 AND score<8 GROUP BY hunter_id", $db);
        while ($correct_item = mysql_fetch_array($correct_db)) {
          $hunter = new Person($correct_item[0]);
          $correct['name'][] = $hunter->GetName();
          $kabal_obj = $hunter->GetDivision();
          $correct['kabal'][] = $kabal_obj->GetName();
          $correct['total'][] = $correct_item[1];
        }
        array_multisort($correct['kabal'], $correct['name'], $correct['total']);
        for ($i = 0; $i < count($correct['name']); $i++) {
          echo "<li>".$correct['name'][$i]." (".$correct['kabal'][$i].") : ".$correct['total'][$i]." correct answers.</li>\n";
        }
        echo "</ul></ul>\n";
        echo "<ul><li><b>Inorrect answers:</b></li><ul>\n";
        $incorrect_db = mysql_query("SELECT hunter_id, count(score) AS total FROM cup_entries WHERE kac_id=$kac_id AND round=$round AND grade=0 AND score<8 GROUP BY hunter_id", $db);
        while ($incorrect_item = mysql_fetch_array($incorrect_db)) {
          $hunter = new Person($incorrect_item[0]);
          $incorrect['name'][] = $hunter->GetName();
          $kabal_obj = $hunter->GetDivision();
          $incorrect['kabal'][] = $kabal_obj->GetName();
          $incorrect['total'][] = $incorrect_item[1];
        }
        array_multisort($incorrect['kabal'], $incorrect['name'], $incorrect['total']);
        for ($i = 0; $i < count($incorrect['name']); $i++) {
          echo "<li>".$incorrect['name'][$i]." (".$incorrect['kabal'][$i].") : ".$incorrect['total'][$i]." incorrect answers.</li>\n";
        }
        echo "</ul></ul>\n";
        echo "</ul>\n";
      }
    }

  } else {

    $pagename .= " :: Suggested Awards :: Select a KAC";
    include('../header.php');

    echo "<p>Please choose the KA Cup to view individual results for:</p>\n";
    
    $kac_number_db = mysql_query("SELECT kac_id, kac_number FROM cup_details ORDER BY kac_id DESC", $db);
    echo "<ul>\n";
    while ($kac_number[] = mysql_fetch_array($kac_number_db)) {}
    print_r($kac_number);
    for ($i = 0; $i < count($kac_number); $i++) {
      echo "<li><a href=\"?kac_id=".$kac_number[$i][0]."\">KA Cup ".$kac_number[$i][1]."</a></li>\n";
    }
    echo "</ul>\n";

  }

  include('../footer.php');

?>
