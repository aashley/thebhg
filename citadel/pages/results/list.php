<?php

/**
 * Citadel :: Results :: List Results
 *
 * This pages lists the various results people have had
 *
 * @access public
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package Citadel
 * @version $Revision: 1.6 $
 */

/**
 * Generate the List View
 *
 * @access public
 * @param array CrumbTrail from earlier pages
 * @param array path info from below this page
 * @return void
 */
function Results_List($crumbTrail, $path) {
  global $citadel;

  $path = explode('/', $path);

  $exam = $citadel->GetExambyAbbrev($path[1]);

  switch (strtolower($path[2])) {

    case 'ungraded':
      $type = 'Ungraded';
      $results = &$exam->GetPending();
      break;

    case 'passed':
      $type = 'Passing';
      $results = &$exam->GetPassed();
      break;

    case 'failed':
      $type = 'Failing';
      $results = &$exam->GetFailed();
      break;

    default:
      $type = 'All';
      $results = &$exam->GetResults();
      break;

  }

  $crumbTrail += array('Listing' => $GLOBALS['site']['file_root'].'exams/list');

  page_header($GLOBALS['site']['title'].' :: Results :: '.$exam->GetName()
      .' :: Listing '.$type,
      '',
      $crumbTrail);

  print '<h1>Listing '.$type.' Results for the '.$exam->GetName().' Exam</h1>';

  $table = new HTML_Table();

  $table->addRow(array('Score',
                       'ID Line'),
                 array(),
                 'TH');

  for ($i = 0; $i < sizeof($results); $i++) {

    $person = $results[$i]->GetPerson();

    $table->addRow(
        array(($results[$i]->IsGraded()
                  ? number_format($results[$i]->GetScore(), 2).'%'
                  : 'N/A'),
              ($results[$i]->IsGraded()
                  ? '<a href="'.$GLOBALS['site']['file_root'].'results/view/'
                    .$results[$i]->GetID().'">'.$person->IDLine(0).'</a>'
                  : $person->IDLine(0))));

  }

  print '<p>'.$table->toHtml().'</p>';

  page_footer();

}

?>
