<?php

/**
 * Editing Questions
 * 
 * @access public
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @pacakge Citadel
 * @version $Revision: 1.3 $
 */

// {{{ Admin_Questions()

/**
 * Edit the questions from an exam
 *
 * @access public
 * @param array crumbTrail from above
 * @param array path info for below this point
 * @param object Login_HTTP the logged in user
 * @return void
 */
function Admin_Questions($crumbTrail, $path, &$login) {
  global $citadel;

  $path = explode('/', $path);

  if (   isset($path[1])
      && $path[1] > '') {

    $exam = $citadel->GetExambyAbbrev($path[1]);

    if (in_array($login->GetID(), $exam->GetMarkers(true))) {

      if (   isset($path[2])
          && $path[2] > '') {

        if (is_numeric($path[2])) {

          include_once 'pages/admin/questions/edit.php';
          
          if (  isset($path[3])
              && $path[3] == 'delete') {
          
            Admin_Questions_Edit($crumbTrail, $login, $exam, $path[2], true);

          } else {
            
            Admin_Questions_Edit($crumbTrail, $login, $exam, $path[2], false);

          }

        } else {

          include_once 'pages/admin/questions/create.php';
          Admin_Questions_Create($crumbTrail, $login, $exam);

        }

      } else {

        include_once 'pages/admin/questions/list.php';
        Admin_Questions_List($crumbTrail, $login, $exam);

      }

    } else {

      page_header($GLOBALS['site']['title'].' :: Administration :: '
          .'Edit '.$exam->GetName().' Exam',
          '',
          $crumbTrail);

      print 'You do not have permission to grade this exam.';

      page_footer();

    }

  } else {

    Admin_Questions_Main($login);

  }

}

// }}}
// {{{ Admin_Edit_Main()

function Admin_Questions_Main(&$login) {
  global $citadel;
  
  page_header($GLOBALS['site']['title'].' :: '.gettext('Administration')
      .' :: Edit Exam Questions',
      '',
      $crumbTrail);

  print '<h1>Edit Exam Questions</h1>';

  $exams = &$citadel->GetExamsMarkedBy($login);

  $table = new HTML_Table();

  for ($i = 0; $i < sizeof($exams); $i++) {

    $table->addRow(
        array($exams[$i]->GetName().' ['.$exams[$i]->GetAbbrev().']',
              '<a href="'.$GLOBALS['site']['file_root'].'admin/questions/'
              .strtolower($exams[$i]->GetAbbrev()).'">Edit Questions</a>')
        );

  }

  print '<p>'.$table->toHtml().'</p>';

  page_footer();

}

// }}}




?>
