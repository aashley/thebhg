<?php

/**
 * Editing Questions - List the Questions
 *
 * @access public
 * @author Adam Ashley <adam_ashley@softhome.net>
 * @package Citadel
 * @version $Revision: 1.8 $
 */

/**
 * Generate the Page
 *
 * @access public
 * @param array The CrumbTrail from higher pages
 * @param object Login_HTTP The logged in user
 * @param object Citadel_Exam The exam we are editing questions for
 * @return void
 */
function Admin_Questions_List($crumbTrail, &$login, &$exam) {

  page_header($GLOBALS['site']['title'].' :: '.gettext('Administration')
      .' :: Edit '.$exam->GetName().' Exam Questions',
      '',
      $crumbTrail);

  print '<h1>Edit '.$exam->GetName().' Exam Questions</h1>';

  $table = new HTML_Table();

  $table->addRow(array('<a href="'.$GLOBALS['site']['file_root']
        .'admin/questions/'.strtolower($exam->GetAbbrev()).'/create">'
        .'Create Question</a>'),
      array(),
      'TH');

  print '<p>'.$table->toHtml().'</p>';

  $questions = &$exam->GetQuestions();

  $table = new HTML_Table();

  foreach ($questions as $question) {

    $subtable = new HTML_Table(array('class' => 'internal'));

    $subtable->addCol(
        array(($question->IsMandatory()
                ? '<span style="color: #ff0000">*</span>'
                : '')
              .'Question:',
              'Answer:',
              'Points:'),
        array(),
        'TH');

    $subtable->addCol(
        array($question->GetQuestionText(),
              $question->GetOfficalAnswer(),
              $question->GetPossibleMarks()));

    $table->addRow(
        array($subtable->toHtml(),
          '<a href="'.$GLOBALS['site']['file_root'].'admin/questions/'
          .strtolower($exam->GetAbbrev()).'/'.$question->GetID().'">Edit</a>',
          '<a href="'.$GLOBALS['site']['file_root'].'admin/questions/'
          .strtolower($exam->GetAbbrev()).'/'.$question->GetID()
          .'/delete">Delete</a>'));

  }

  $table->addRow(array('<span style="font-size:80%; color:#ff0000;">*</span>'
                      .'<span style="font-size:80%;"> denotes mandatory '
                      .'question</span>'),
                 array('colspan' => 3));

  print '<p>'.$table->toHtml().'</p>';

  page_footer();

}

?>
