<?php

/**
 * List submissions waiting to be graded for this exam
 *
 * @access public
 * @package Citadel
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @version $Revision: 1.2 $
 */

/**
 * The function to generate the layout
 * 
 * @access public
 * @param array The CrumbTrail from above
 * @param object Login_HTTP The logged in user
 * @param object Citadel_Exam the Exam we listing for
 * @return void
 */
function Admin_Grade_List($crumbTrail, &$login, &$exam) {
  global $citadel;

  page_header($GLOBALS['site']['title'].' :: Administration :: '
      .'Grade '.$exam->GetName().' Exam',
      '',
      $crumbTrail);

  print '<h1>Grade '.$exam->GetName().' Exam</h1>';

  $results = &$exam->GetPending();
  
  $table = new HTML_Table();

  for ($i = 0; $i < sizeof($results); $i++) {

    $person = $results[$i]->GetPerson();

    $table->addRow(
        array($person->GetName(),
              date('F jS Y, g:iA', $results[$i]->GetDateTaken()),
              '<a href="'.$GLOBALS['site']['file_root'].'admin/grade/'
              .strtolower($exam->GetAbbrev()).'/'.$results[$i]->GetID().'">'
              .'Grade</a>')
        );

  }

  print '<p>'.$table->toHtml().'</p>';

  page_footer();

}

?>
