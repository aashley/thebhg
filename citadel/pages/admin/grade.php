<?php

/**
 * Grading Exams
 * 
 * @access public
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @pacakge Citadel
 * @version $Revision: 1.5 $
 */

// {{{ Admin_Grade()

/**
 * Grade an exam
 *
 * @access public
 * @param array crumbTrail from above
 * @param array path info for below this point
 * @param object Login_HTTP the logged in user
 * @return void
 */
function Admin_Grade($crumbTrail, $path, &$login) {
  global $citadel;

  $path = explode('/', $path);

  if (   isset($path[1])
      && $path[1] > '') {

    $exam = $citadel->GetExambyAbbrev($path[1]);

    if (in_array($login->GetID(), $exam->GetMarkers(true))
        || $login->GetID() == 94) {

      if (   isset($path[2])
          && $path[2] > ''
          && is_numeric($path[2])) {

        include_once 'pages/admin/grade/grade.php';
        Admin_Grade_Exam($crumbTrail, $login, $exam, $path[2]);

      } else {

        include_once 'pages/admin/grade/list.php';
        Admin_Grade_List($crumbTrail, $login, $exam);

      }

    } else {

      page_header($GLOBALS['site']['title'].' :: Administration :: '
          .'Grade '.$exam->GetName().' Exam',
          '',
          $crumbTrail);

      print 'You do not have permission to grade this exam.';

      page_footer();

    }

  } else {

    Admin_Grade_Main($login);

  }

}

// }}}
// {{{ Admin_Grade_Main()

function Admin_Grade_Main(&$login) {
  global $citadel;
  
  page_header($GLOBALS['site']['title'].' :: '.gettext('Administration')
      .' :: Grade Exams',
      '',
      $crumbTrail);

  print '<h1>Grade Exams</h1>';

  $exams = &$citadel->GetExamsMarkedBy($login);

  $table = new HTML_Table();

  for ($i = 0; $i < sizeof($exams); $i++) {

    $table->addRow(
        array($exams[$i]->GetName().' ['.$exams[$i]->GetAbbrev().']',
              '<a href="'.$GLOBALS['site']['file_root'].'admin/grade/'
              .strtolower($exams[$i]->GetAbbrev()).'">Grade ('
              .$exams[$i]->CountPending().' pending)</a>')
        );

  }

  print '<p>'.$table->toHtml().'</p>';

  page_footer();

}

// }}}

?>
