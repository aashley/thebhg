<?php

/**
 * Citadel :: Course List
 *
 * @access public
 * @author Adam Ashley <aashley@optimiser.com>
 * @package Citadel
 * @version $Revision: 1.11 $
 */

/**
 * Generate this page
 *
 * @access public
 * @param array The Crumb Trail from higher pages
 * @param array The path info below this page
 * @return void
 */
function Courses($crumbTrail, $path) {
  global $citadel;

  if (DEBUG) {

    RegisterDebug('Called Courses()');

  }

  $crumbTrail += array('Courses' => $GLOBALS['site']['file_root'].'courses');

  page_header($GLOBALS['site']['title'].' :: Course List',
      '',
      $crumbTrail);

  print '<p>Scum,</p>'
    .'Here you can view basic information on each of the tests currently '
    .'offered at the Citadel. Feel free to check out the "Failed Exams" link '
    .'and see just how stupid some of your fellow hunters are. If you\'re '
    .'still cocky, which am willing to bet you are, go directly to the exam '
    .'by clicking "Take Exam". And for those of you little bookworms, you '
    .'may want to click on "View course notes" to review the notes needed'
    .'to pass each exam before jumping in headfirst like your cocky '
    .'brethren.</p>';

  $exams = &$citadel->GetExams();

  for ($i = 0; $i < sizeof($exams); $i++) {

    $table = new HTML_Table();

    $table->addRow(
        array($exams[$i]->GetName().' ['.$exams[$i]->GetAbbrev().']',
              '<a href="'.$GLOBALS['file_root'].'notes/'
              .strtolower($exams[$i]->GetAbbrev()).'" target="_blank">View '
              .'Course Notes</a> '
              .'| '
              .'<a href="'.$GLOBALS['file_root'].'exams/take/'
              .strtolower($exams[$i]->GetAbbrev()).'">Take Exam</a>'),
        array(),
        'TH');

    $table->addRow(array(nl2br($exams[$i]->GetDescription())),
                   array('colspan' => 2));

    $table->addRow(array('Number of Questions',
                         $exams[$i]->GetNumberofQuestions()));

    $table->addRow(array('Passing Grade',
                         $exams[$i]->GetPassGrade().'%'));

    $table->addRow(array('Credit Bonus',
                         $exams[$i]->GetCreditAward()));

    $markers = $exams[$i]->GetMarkers();

    $markerout = '';

    for ($j = 0; $j < sizeof($markers); $j++) {

      if ($j != 0) {

        $markerout .= '<br>';

      }

      $markerout .= $markers[$j]->GetName().' &lt;<a href="mailto:'
        .$markers[$j]->GetEmail().'">'.$markers[$j]->GetEmail().'</a>&gt;';

    }

    $table->addRow(array('Graded By',
                         $markerout));

    $table->addRow(array('Total Exam Attempts',
          $exams[$i]->CountTaken()
          .' ['
          .'<a href="'.$GLOBALS['site']['file_root'].'results/list/'
          .strtolower($exams[$i]->GetAbbrev()).'">List</a>]'));

    $table->addRow(array('Ungraded Exams',
          $exams[$i]->CountPending()
          .' ['
          .'<a href="'.$GLOBALS['site']['file_root'].'results/list/'
          .strtolower($exams[$i]->GetAbbrev()).'/ungraded">List</a>]'));

    $table->addRow(array('Passing Exams',
          $exams[$i]->CountPassed()
          .' ['
          .'<a href="'.$GLOBALS['site']['file_root'].'results/list/'
          .strtolower($exams[$i]->GetAbbrev()).'/passed">List</a>]'));

    $table->addRow(array('Failing Exams',
          $exams[$i]->CountFailed()
          .' ['
          .'<a href="'.$GLOBALS['site']['file_root'].'results/list/'
          .strtolower($exams[$i]->GetAbbrev()).'/failed">List</a>]'));

    $table->addRow(array('Average Score',
          number_format($exams[$i]->GetAverageScore(), 2).'%'));

    print '<a name="'.strtolower($exams[$i]->GetAbbrev()).'"></a>'
      .'<p>'.$table->toHtml().'</p>';

  }

  page_footer();

}

?>
