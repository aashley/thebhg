<?php

function fixpass($c, $p) {
  global $citadel;

  $sql = 'UPDATE ntc_exam_completed '
        .'SET has_passed = 0';

  mysql_query($sql, $citadel->roster_db);

  $sql = 'SELECT ntc_exam_completed.id '
        .'FROM ntc_exam_completed, '
             .'ntc_exams '
        .'WHERE ntc_exam_completed.score >= ntc_exams.passing_grade '
          .'AND ntc_exam_completed.exam = ntc_exams.id';

  $result = mysql_query($sql, $citadel->roster_db);

  echo 'Updating Exams...<br>';

  while ($exam = mysql_fetch_assoc($result)) {

    $sql = 'UPDATE ntc_exam_completed '
          .'SET has_passed = 1 '
          .'WHERE id = '.$exam['id'];

    if (mysql_query($sql, $citadel->roster_db)) {

      print $id.' updated.<br>';

    } else {

      print $id.' failed.<br>';

    }

  }

}

?>
