<?php

/**
 * Citadel :: Graduates List
 *
 * @access public
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package Citadel
 * @version $Revision: 1.3 $
 */

/**
 * Generate the Graduates Page
 *
 * @access public
 * @param array The Crumb Trail from higher pages
 * @param array The path info below this page
 * @return void
 */
function Graduates($crumbTrail, $path) {
  global $citadel;

  if (DEBUG) {

    RegisterDebug('Called Graduates()');

  }

  $crumbTrail += array('Graduates' => $GLOBALS['site']['file_root'].'graduates');

  page_header($GLOBALS['site']['title'].' :: Course Graduates',
      '',
      $crumbTrail);

  print '<p>Scum,</p>'
    .'<p>No matter how hard I try, there are always a few of you who get '
    .'lucky and pass an exam. Those few hunters are listed in the sections '
    .'below. Click on the name of the exam to get a full list of the '
    .'graduated of that course. From that list you can also see how close '
    .'those pitiful fools were to failing if I had decided to randomly mark '
    .'an answer wrong.</p>';

  $exams = &$citadel->GetExams();

  $table = new HTML_Table();

  for ($i = 0; $i < sizeof($exams); $i++) {

    $table->addRow(
        array($exams[$i]->GetName(),
              $exams[$i]->CountPassed().' grads',
              '<a href="'.$GLOBALS['site']['file_root'].'results/list/'
              .strtolower($exams[$i]->GetAbbrev()).'/passed">Graduates</a>',
              '<a href="'.$GLOBALS['site']['file_root'].'courses#'
              .strtolower($exams[$i]->GetAbbrev()).'">Exam Details</a>')
        );

  }

  print '<p>'.$table->toHtml().'</p>';

  page_footer();

}

?>
