<?php

  include_once($path_to_base.'functions/db.php');
  include_once($path_to_base.'functions/roster.php');

  function cup_running() { // Returns the id of the Cup currently running, or False if there is none.
    global $db;
    $check_db = mysql_query("SELECT cup_details.kac_id FROM cup_details, cup_placings WHERE cup_details.kac_id=cup_placings.kac_id AND winner=0 AND r1_start<=NOW() ORDER BY kac_id DESC LIMIT 1", $db);
    if (@$check = mysql_fetch_array($check_db)) {
      return $check[0];
    } else {
      return False;
    }
  }
  
  function cup_pending() { // Returns the id of the Cup currently pending, or False if there is none.
    global $db;
    $check_db = mysql_query("SELECT cup_details.kac_id FROM cup_details, cup_placings WHERE r1_start>NOW() ORDER BY cup_details.kac_id DESC LIMIT 1", $db);
    if (@$check = mysql_fetch_array($check_db)) {
      return $check[0];
    } else {
      return False;
    }
  }
  
  function round_running() { // Returns which round is currently running, or False if none.
    global $db;
    if (cup_running()) {
      $check_r1_db = mysql_query("SELECT kac_id FROM cup_details WHERE r1_start<=NOW() AND r1_finish>=NOW() ORDER BY kac_id DESC LIMIT 1", $db);
      $check_r2_db = mysql_query("SELECT cup_details.kac_id FROM cup_details, cup_placings WHERE cup_details.kac_id=cup_placings.kac_id AND r2_start<=NOW() AND r2_finish>=NOW() AND winner_2_7>0 ORDER BY kac_id DESC LIMIT 1", $db);
      $check_r3_db = mysql_query("SELECT cup_details.kac_id FROM cup_details, cup_placings WHERE cup_details.kac_id=cup_placings.kac_id AND r3_start<=NOW() AND r3_finish>=NOW() AND winner_top>0 ORDER BY kac_id DESC LIMIT 1", $db);
      if (@$check_r1 = mysql_fetch_array($check_r1_db)) {
        return 1;
      } elseif (@$check_r2 = mysql_fetch_array($check_r2_db)) {
        return 2;
      } elseif (@$check_r3 = mysql_fetch_array($check_r3_db)) {
        return 3;
      } else {
        return False;
      }
    } else {
      return False;
    }
  }

  function round_to_grade() { // Returns which round to grade.
    global $db;
    $round = round_running();
    if ($round) {
      return $round;
    } else {
      $check_r1_db = mysql_query("SELECT kac_id FROM cup_details WHERE r1_finish<=NOW() AND r2_start>=NOW() ORDER BY kac_id DESC LIMIT 1", $db);
      $check_r2_db = mysql_query("SELECT kac_id FROM cup_details WHERE r2_finish<=NOW() AND r3_start>=NOW() ORDER BY kac_id DESC LIMIT 1", $db);
      $check_r3_db = mysql_query("SELECT cup_details.kac_id FROM cup_details, cup_placings WHERE cup_details.kac_id=cup_placings.kac_id AND r3_finish<=NOW() AND winner=0 ORDER BY kac_id DESC LIMIT 1", $db);
      if (@$check_r1 = mysql_fetch_array($check_r1_db)) {
        return 1;
      } elseif (@$check_r2 = mysql_fetch_array($check_r2_db)) {
        return 2;
      } elseif (@$check_r3 = mysql_fetch_array($check_r3_db)) {
        return 3;
      } else {
        return False;
      }
    }
  }      

  function kabal_in($hunter_id) { // Returns True or False depending on whether the hunter $hunter_id's kabal is still in the Cup.
    global $db;
    $hunter = new Person($hunter_id);
    $division_obj = $hunter->GetDivision();
    if ($division_obj->IsKabal()) {
      $kabal_id = $division_obj->GetID();
      $kac_id = cup_running();
      $this_round = round_running();
      if ($this_round == 1) {
        return True;
      } elseif ($this_round == 2) {
        $kabals_db = mysql_query("SELECT position_1, winner_2_7, winner_3_6, winner_4_5 FROM cup_placings WHERE kac_id=$kac_id LIMIT 1", $db);
        $kabals = mysql_fetch_array($kabals_db);
        if (($kabal_id == $kabals[0]) || ($kabal_id == $kabals[1]) || ($kabal_id == $kabals[2]) || ($kabal_id = $kabals[3])) {
          return True;
        } else {
          return False;
        }
      } elseif ($this_round == 3) {
        $kabals_db = mysql_query("SELECT winner_top, winner_bottom FROM cup_placings WHERE kac_id=$kac_id LIMIT 1", $db);
        $kabals = mysql_fetch_array($kabals_db);
        if (($kabal_id == $kabals[0]) || ($kabal_id == $kabals[1])) {
          return True;
        } else {
          return False;
        }
      } else {
        return False;
      }
    } else {
      return False;
    }
  }

  function events_pending($hunter_id) { // Returns an array of all the event_ids the hunter has yet to complete for the current round, or false if (s)he's completed them all.
    global $db;
    if (kabal_in($hunter_id)) {
      $kac_id = cup_running();
      $round = round_running();
      $entries_db = mysql_query("SELECT event_id FROM cup_entries WHERE kac_id=$kac_id AND round=$round AND hunter_id=$hunter_id ORDER BY event_id ASC", $db);
      while ($entries[] = mysql_fetch_array($entries_db)) {}
      $j = 0;
      for ($i = 1; $i <= 5; $i++) {
        if (isset($entries) && (count($entries) > 0) && ($entries[$j][0] == $i)) {
          $j++;
        } else {
          $events[] = $i;
        }
      }
      if (isset($events)) {
        return $events;
      } else {
        return False;
      }
    } else {
      return False;
    }
  }

  function get_event_name($event_id) { // Converts the event_id to the associated event name.
    switch($event_id) {
      case 1:
        return "Internet (URL) Hunt";
        break;
      case 2:
        return "Trivia";
        break;
      case 3:
        return "Web Hunt";
        break;
      case 4:
        return "Hunt the Hunter";
        break;
      case 5:
        return "Time Line";
        break;
    }
  }

?>
